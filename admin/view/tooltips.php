<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'automatic-tooltips' ) );
}

?>

<!-- process data -->

<?php

//Initialize variables -------------------------------------------------------------------------------------------------
$dismissible_notice_a = [];

//Preliminary operations -----------------------------------------------------------------------------------------------
global $wpdb;

//Sanitization ---------------------------------------------------------------------------------------------

//Actions
$data['edit_id']        = isset( $_GET['edit_id'] ) ? intval( $_GET['edit_id'], 10 ) : null;
$data['delete_id']      = isset( $_POST['delete_id'] ) ? intval( $_POST['delete_id'], 10 ) : null;
$data['clone_id']       = isset( $_POST['clone_id'] ) ? intval( $_POST['clone_id'], 10 ) : null;
$data['update_id']      = isset( $_POST['update_id'] ) ? intval( $_POST['update_id'], 10 ) : null;
$data['form_submitted'] = isset( $_POST['form_submitted'] ) ? intval( $_POST['form_submitted'], 10 ) : null;

//Filter and search data
$data['s']  = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash($_GET['s']) ) : null;
$data['cf'] = isset( $_GET['cf'] ) ? intval( $_GET['cf'], 10 ) : null;

//Form data
if ( ! is_null( $data['update_id'] ) or ! is_null( $data['form_submitted'] ) ) {

	//Main Form data
	$data['category_id'] = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'], 10 ) : null;
	$data['keyword']     = isset( $_POST['keyword'] ) ? sanitize_text_field( $_POST['keyword'] ) : null;
	$data['text']        = isset( $_POST['text'] ) ? sanitize_textarea_field( $_POST['text'] ) : null;

	if ( isset( $_POST['post_types'] ) and is_array( $_POST['post_types'] ) ) {
		$data['post_types'] = array_map( function ( $a ) {
			return sanitize_key( $a );
		}, $_POST['post_types'] );
	} else {
		$data['post_types'] = '';
	}

	if ( isset( $_POST['categories'] ) and is_array( $_POST['categories'] ) ) {
		$data['categories'] = array_map( function ( $a ) {
			return sanitize_key( $a );
		}, $_POST['categories'] );
	} else {
		$data['categories'] = '';
	}

	if ( isset( $_POST['tags'] ) and is_array( $_POST['tags'] ) ) {
		$data['tags'] = array_map( function ( $a ) {
			return sanitize_key( $a );
		}, $_POST['tags'] );
	} else {
		$data['tags'] = '';
	}

	$data['case_sensitive_search'] = isset( $_POST['case_sensitive_search'] ) ? intval( $_POST['case_sensitive_search'], 10 ) : null;
	$data['left_boundary']         = isset( $_POST['left_boundary'] ) ? intval( $_POST['left_boundary'], 10 ) : null;
	$data['right_boundary']        = isset( $_POST['right_boundary'] ) ? intval( $_POST['right_boundary'], 10 ) : null;
	$data['keyword_before']        = isset( $_POST['keyword_before'] ) ? sanitize_text_field( $_POST['keyword_before'] ) : null;
	$data['keyword_after']         = isset( $_POST['keyword_after'] ) ? sanitize_text_field( $_POST['keyword_after'] ) : null;
	$data['limit']                 = isset( $_POST['limit'] ) ? intval( $_POST['limit'], 10 ) : null;
	$data['priority']              = isset( $_POST['priority'] ) ? intval( $_POST['priority'], 10 ) : null;

	//Validation -------------------------------------------------------------------------------------------------------

	//validation on "keyword"
	if ( mb_strlen( trim( $data['keyword'] ) ) === 0 or mb_strlen( trim( $data['keyword'] ) ) > 255 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Keyword" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	//validation on "text"
	if ( mb_strlen( trim( $data['text'] ) ) === 0 or mb_strlen( trim( $data['text'] ) ) > 1000 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Text" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	/*
	 * Do not allow only numbers as a keyword. Only numbers in a keyword would cause the index of the protected block to
	 * be replaced. For example the keyword "1" would cause the "1" present in the index of the following protected
	 * blocks to be replaced with an tooltip:
	 *
	 * - [pb]1[/pb]
	 * - [b]31[/pb]
	 * - [pb]812[/pb]
	 */
	if ( preg_match( '/^\d+$/', $data['keyword'] ) === 1 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'A keyword that includes only digits is not allowed.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	/*
	 * Do not allow to create specific keyword that would be able to replace the start delimiter or the protected block
	 * [pb], part of the start delimiter, the end delimited [/pb] or part of the end delimiter.
	 */
	if ( preg_match( '/^\[$|^\[p$|^\[pb$|^\[pb]$|^\[\/$|^\[\/p$|^\[\/pb$|^\[\/pb\]$|^\]$|^b\]$|^pb\]$|^\/pb\]$|^p$|^pb$|^pb\]$|^\/$|^\/p$|^\/pb$|^\/pb]$|^b$|^b\$]/i', $data['keyword'] ) === 1 ) {

		$dismissible_notice_a[] = [
			'message' => __( 'The specified keyword is not allowed.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;

		$specified_keyword_not_allowed = true;
	}

	/*
	 * Do not allow to create specific keyword that would be able to replace the start delimiter of the tooltip [al],
	 * part of the start delimiter, the end delimited [/al] or part of the end delimiter.
	 */
	if ( ! isset( $specified_keyword_not_allowed ) and preg_match( '/^\[$|^\[a$|^\[al$|^\[al]$|^\[\/$|^\[\/a$|^\[\/al$|^\[\/al\]$|^\]$|^l\]$|^al\]$|^\/al\]$|^a$|^al$|^al\]$|^\/$|^\/a$|^\/al$|^\/al]$|^l$|^l\$]/i', $data['keyword'] ) === 1 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The specified keyword is not allowed.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	//validation on "limit"
	if ( intval( $data['limit'], 10 ) === 0 or intval( $data['limit'], 10 ) > 1000000 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Limit" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	//validation on "priority"
	if ( intval( $data['priority'], 10 ) > 1000000 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Priority" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	//validation on "keyword_before"
	if ( mb_strlen( trim( $data['keyword_before'] ) ) > 255 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Keyword Before" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	//validation on "keyword_after"
	if ( mb_strlen( trim( $data['keyword_after'] ) ) > 255 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Keyword After" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

}

//Update or add the record in the database
if ( ! is_null( $data['update_id'] ) and ! isset( $invalid_data ) ) {

	//update the database
	$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_tooltip";
	$safe_sql   = $wpdb->prepare( "UPDATE $table_name SET 
            category_id = %d,
            keyword = %s,
            text = %s,
            case_sensitive_search = %d,
            `limit` = %d,
            priority = %d,
            left_boundary = %d,
            right_boundary = %d,
            keyword_before = %s,
            keyword_after = %s,
            post_types = %s,
            categories = %s,
            tags = %s
            WHERE tooltip_id = %d",
		$data['category_id'],
		$data['keyword'],
		$data['text'],
		$data['case_sensitive_search'],
		$data['limit'],
		$data['priority'],
		$data['left_boundary'],
		$data['right_boundary'],
		$data['keyword_before'],
		$data['keyword_after'],
		maybe_serialize( $data['post_types'] ),
		maybe_serialize( $data['categories'] ),
		maybe_serialize( $data['tags'] ),
		$data['update_id'] );

	$query_result = $wpdb->query( $safe_sql );

	if ( $query_result !== false ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The tooltip has been successfully updated.', 'automatic-tooltips' ),
			'class'   => 'updated'
		];
	}

} else {

	//add ------------------------------------------------------------------
	if ( ! is_null( $data['form_submitted'] ) and ! isset( $invalid_data ) ) {

		$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_tooltip";
		$safe_sql   = $wpdb->prepare( "INSERT INTO $table_name SET 
            category_id = %d,
            keyword = %s,
            text = %s,
            case_sensitive_search = %d,
            `limit` = %d,
            priority = %d,
            left_boundary = %d,
            right_boundary = %d,
            keyword_before = %s,
            keyword_after = %s,
            post_types = %s,
            categories = %s,
            tags = %s",
			$data['category_id'],
			$data['keyword'],
			$data['text'],
			$data['case_sensitive_search'],
			$data['limit'],
			$data['priority'],
			$data['left_boundary'],
			$data['right_boundary'],
			$data['keyword_before'],
			$data['keyword_after'],
			maybe_serialize( $data['post_types'] ),
			maybe_serialize( $data['categories'] ),
			maybe_serialize( $data['tags'] )
		);

		$query_result = $wpdb->query( $safe_sql );

		if ( $query_result !== false ) {
			$dismissible_notice_a[] = [
				'message' => __( 'The tooltip has been successfully added.', 'automatic-tooltips' ),
				'class'   => 'updated'
			];
		}

	}

}

//delete an tooltip
if ( ! is_null( $data['delete_id'] ) ) {

	$table_name   = $wpdb->prefix . $this->shared->get( 'slug' ) . "_tooltip";
	$safe_sql     = $wpdb->prepare( "DELETE FROM $table_name WHERE tooltip_id = %d ", $data['delete_id'] );
	$query_result = $wpdb->query( $safe_sql );

	if ( $query_result !== false ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The tooltip has been successfully deleted.', 'automatic-tooltips' ),
			'class'   => 'updated'
		];
	}

}

//clone the tooltip
if ( ! is_null( $data['clone_id'] ) ) {

	//clone the tooltip
	$table_name     = $wpdb->prefix . $this->shared->get( 'slug' ) . "_tooltip";
	$query_result_1 = $wpdb->query( "CREATE TEMPORARY TABLE daextauttol_temporary_table SELECT * FROM $table_name WHERE tooltip_id = " . $data['clone_id'] );
	$query_result_2 = $wpdb->query( "UPDATE daextauttol_temporary_table SET tooltip_id = NULL" );
	$query_result_3 = $wpdb->query( "INSERT INTO $table_name SELECT * FROM daextauttol_temporary_table" );
	$query_result_4 = $wpdb->query( "DROP TEMPORARY TABLE IF EXISTS daextauttol_temporary_table" );

	if ( $query_result_1 !== false and
	     $query_result_2 !== false and
	     $query_result_3 !== false and
	     $query_result_4 !== false ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The tooltip has been successfully duplicated.', 'automatic-tooltips' ),
			'class'   => 'updated'
		];
	}

}

//get the tooltip data
if ( ! is_null( $data['edit_id'] ) ) {
	$table_name  = $wpdb->prefix . $this->shared->get( 'slug' ) . "_tooltip";
	$safe_sql    = $wpdb->prepare( "SELECT * FROM $table_name WHERE tooltip_id = %d ", $data['edit_id'] );
	$tooltip_obj = $wpdb->get_row( $safe_sql );
}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_html_e( 'Automatic Tooltips - Tooltips', 'automatic-tooltips' ); ?></h2>

        <!-- Search Form -->

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daextauttol-tooltips">

            <p><?php esc_html_e( 'Perform your Search', 'automatic-tooltips' ); ?></p>

			<?php

			//Custom Filter
			if ( $data['cf'] !== null ) {
				echo '<input type="hidden" name="cf" value="' . esc_attr( $data['cf'] ) . '">';
			}

			?>

            <input type="text" name="s"
                   value="<?php echo esc_attr( $data['s'] ); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="">

        </form>

        <!-- Filter Form -->

        <form method="GET" action="admin.php" id="daext-filter-form">

            <input type="hidden" name="page" value="<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-tooltips">

            <p><?php esc_html_e( 'Filter by Category', 'automatic-tooltips' ); ?></p>

            <select id="cf" name="cf" class="daext-display-none">

                <option value="all" <?php if ( isset( $data['cf'] ) ) {
					selected( $data['cf'], 'all' );
				} ?>><?php esc_html_e( 'All', 'automatic-tooltips' ); ?></option>

				<?php

				$table_name   = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
				$safe_sql     = "SELECT category_id, name FROM $table_name ORDER BY category_id DESC";
				$categories_a = $wpdb->get_results( $safe_sql, ARRAY_A );

				foreach ( $categories_a as $key => $category ) {

					if ( ! is_null( $data['cf'] ) ) {
						echo '<option value="' . esc_attr( $category['category_id'] ) . '" ' . selected( $data['cf'],
								$category['category_id'],
								false ) . '>' . esc_html( stripslashes( $category['name'] ) ) . '</option>';
					} else {
						echo '<option value="' . esc_attr( $category['category_id'] ) . '">' . esc_html( stripslashes( $category['name'] ) ) . '</option>';
					}

				}

				?>

            </select>

        </form>

    </div>

    <div id="daext-menu-wrapper">

		<?php $this->dismissible_notice( $dismissible_notice_a ); ?>

        <!-- table -->

		<?php

		//custom filter
		if ( is_null( $data['cf'] ) ) {
			$filter = '';
		} else {
			$filter = $wpdb->prepare( "WHERE category_id = %d", $data['cf'] );
		}

		//create the query part used to filter the results when a search is performed
		if ( ! is_null( $data['s'] ) ) {

			$search_string = $data['s'];

			//create the query part used to filter the results when a search is performed
			if ( ( mb_strlen( trim( $filter ) ) > 0 ) ) {
				$filter .= $wpdb->prepare( ' AND (keyword LIKE %s OR text LIKE %s)',
					'%' . $search_string . '%',
					'%' . $search_string . '%' );
			} else {
				$filter = $wpdb->prepare( 'WHERE (keyword LIKE %s OR text LIKE %s)',
					'%' . $search_string . '%',
					'%' . $search_string . '%' );
			}

		}

		//retrieve the total number of tooltips
		$table_name  = $wpdb->prefix . $this->shared->get( 'slug' ) . "_tooltip";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $filter" );

		//Initialize the pagination class
		require_once( $this->shared->get( 'dir' ) . '/admin/inc/class-daextauttol-pagination.php' );
		$pag = new daextauttol_pagination();
		$pag->set_total_items( $total_items );//Set the total number of items
		$pag->set_record_per_page( 10 ); //Set records per page
		$pag->set_target_page( "admin.php?page=" . $this->shared->get( 'slug' ) . "-tooltips" );//Set target page
		$pag->set_current_page();//set the current page number

		?>

        <!-- Query the database -->
		<?php
		$query_limit = $pag->query_limit();
		$results     = $wpdb->get_results( "SELECT * FROM $table_name $filter ORDER BY tooltip_id DESC $query_limit",
			ARRAY_A ); ?>

		<?php if ( count( $results ) > 0 ) : ?>

            <div class="daext-items-container">

                <!-- list of tables -->
                <table class="daext-items">
                    <thead>
                    <tr>
                        <th>
                            <div><?php esc_html_e( 'ID', 'automatic-tooltips' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The ID of the tooltip.', 'automatic-tooltips' ); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_html_e( 'Keyword', 'automatic-tooltips' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The keyword on which the tooltip will be added.', 'automatic-tooltips' ); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_html_e( 'Category', 'automatic-tooltips' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The category of the tooltip.', 'automatic-tooltips' ); ?>"></div>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

					<?php foreach ( $results as $result ) : ?>
                        <tr>
                            <td><?php echo intval( $result['tooltip_id'], 10 ); ?></td>
                            <td><?php echo esc_html( stripslashes( $result['keyword'] ) ); ?></td>
                            <td><?php echo esc_html( stripslashes( $this->shared->get_category_name( $result['category_id'] ) ) ); ?></td>
                            <td class="icons-container">
                                <form method="POST"
                                      action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-tooltips">
                                    <input type="hidden" name="clone_id"
                                           value="<?php echo esc_attr( $result['tooltip_id'] ); ?>">
                                    <input class="menu-icon clone help-icon" type="submit" value="">
                                </form>
                                <a class="menu-icon edit"
                                   href="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-tooltips&edit_id=<?php echo esc_attr( $result['tooltip_id'] ); ?>"></a>
                                <form id="form-delete-<?php echo esc_attr( $result['tooltip_id'] ); ?>" method="POST"
                                      action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-tooltips">
                                    <input type="hidden" value="<?php echo esc_attr( $result['tooltip_id'] ); ?>"
                                           name="delete_id">
                                    <input class="menu-icon delete" type="submit" value="">
                                </form>
                            </td>
                        </tr>
					<?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- Display the pagination -->
			<?php if ( $pag->total_items > 0 ) : ?>
                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo esc_html( $pag->total_items ); ?>
                            &nbsp<?php esc_html_e( 'items', 'automatic-tooltips' ); ?></span>
						<?php $pag->show(); ?>
                    </div>
                </div>
			<?php endif; ?>

		<?php else : ?>

			<?php

			if ( mb_strlen( trim( $filter ) ) > 0 ) {
				echo '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_html__( 'There are no results that match your filter.', 'automatic-tooltips' ) . '</p></div>';
			}

			?>

		<?php endif; ?>

        <div>

            <form method="POST" action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-tooltips"
                  autocomplete="off">

                <input type="hidden" value="1" name="form_submitted">

				<?php if ( ! is_null( $data['edit_id'] ) ) : ?>

                <!-- Edit a Tooltip -->

                <div class="daext-form-container">

                    <h3 class="daext-form-title"><?php esc_html_e( 'Edit Tooltip', 'automatic-tooltips' ); ?>
                        &nbsp<?php echo esc_html( $tooltip_obj->tooltip_id ); ?></h3>

                    <table class="daext-form daext-form-table">

                        <input type="hidden" name="update_id"
                               value="<?php echo esc_attr( $tooltip_obj->tooltip_id ); ?>"/>

                        <!-- Keyword -->
                        <tr>
                            <th scope="row"><label
                                        for="keyword"><?php esc_html_e( 'Keyword', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
                                <input value="<?php echo esc_attr( stripslashes( $tooltip_obj->keyword ) ); ?>"
                                       type="text"
                                       id="keyword" maxlength="255" size="30" name="keyword"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The keyword on which the tooltip will be added.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Text -->
                        <tr>
                            <th scope="row"><label
                                        for="text"><?php esc_html_e( 'Text', 'automatic-tooltips' ); ?></label></th>
                            <td>
                                <textarea type="text"
                                          id="text" maxlength="255" size="30"
                                          name="text"><?php echo esc_html( stripslashes( $tooltip_obj->text ) ); ?></textarea>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The text of the tooltip.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Category ID -->
                        <tr>
                            <th scope="row"><label
                                        for="tags"><?php esc_html_e( 'Category', 'automatic-tooltips' ); ?></label></th>
                            <td>
								<?php

								echo '<select id="category-id" name="category_id" class="daext-display-none">';

								echo '<option value="0" ' . selected( $tooltip_obj->category_id, 0,
										false ) . '>' . esc_html__( 'None', 'automatic-tooltips' ) . '</option>';

								$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
								$sql        = "SELECT category_id, name FROM $table_name ORDER BY category_id DESC";
								$category_a = $wpdb->get_results( $sql, ARRAY_A );

								foreach ( $category_a as $key => $category ) {
									echo '<option value="' . esc_attr( $category['category_id'] ) . '" ' . selected( $tooltip_obj->category_id,
											$category['category_id'],
											false ) . '>' . esc_html( stripslashes( $category['name'] ) ) . '</option>';
								}

								echo '</select>';
								echo '<div class="help-icon" title="' . esc_attr__( 'The category of the tooltip.', 'automatic-tooltips' ) . '"></div>';

								?>
                            </td>
                        </tr>

                        <!-- Affected Posts Options -------------------------------------------------------------------------- -->
                        <tr class="group-trigger" data-trigger-target="affected-posts-options">
                            <th class="group-title"><?php esc_html_e( 'Affected Posts', 'automatic-tooltips' ); ?></th>
                            <td>
                                <div class="expand-icon"></div>
                            </td>
                        </tr>

                        <!-- Post Types -->
                        <tr class="affected-posts-options">
                            <th scope="row"><label
                                        for="post-types"><?php esc_html_e( 'Post Types', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
								<?php

								$current_post_types_a = maybe_unserialize( $tooltip_obj->post_types );

								$available_post_types_a = get_post_types( array(
									'public'  => true,
									'show_ui' => true
								) );

								//Remove the "attachment" post type
								$available_post_types_a = array_diff( $available_post_types_a, array( 'attachment' ) );

								echo '<select id="post-types" name="post_types[]" class="daext-display-none" multiple>';

								foreach ( $available_post_types_a as $key => $single_post_type ) {
									if ( is_array( $current_post_types_a ) and in_array( $single_post_type,
											$current_post_types_a ) ) {
										$selected = 'selected';
									} else {
										$selected = '';
									}
									$post_type_obj = get_post_type_object( $single_post_type );
									echo '<option value="' . esc_attr( $single_post_type ) . '" ' . esc_attr($selected) . '>' . esc_html( $post_type_obj->label ) . '</option>';
								}

								echo '</select>';

								echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which post types the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any post type.', 'automatic-tooltips' ) . '"></div>';

								?>
                            </td>
                        </tr>

                        <!-- Categories -->
                        <tr class="affected-posts-options">
                            <th scope="row"><label
                                        for="categories"><?php esc_html_e( 'Categories', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
								<?php

								$current_categories_a = maybe_unserialize( $tooltip_obj->categories );

								echo '<select id="categories" name="categories[]" class="daext-display-none" multiple>';

								$categories = get_categories( array(
									'hide_empty' => 0,
									'orderby'    => 'term_id',
									'order'      => 'DESC'
								) );

								foreach ( $categories as $key => $category ) {
									if ( is_array( $current_categories_a ) and in_array( $category->term_id,
											$current_categories_a ) ) {
										$selected = 'selected';
									} else {
										$selected = '';
									}
									echo '<option value="' . esc_attr( $category->term_id ) . '" ' . esc_attr($selected) . '>' . esc_html( $category->name ) . '</option>';
								}

								echo '</select>';
								echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which categories the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any category.', 'automatic-tooltips' ) . '"></div>';

								?>
                            </td>
                        </tr>

                        <!-- Tags -->
                        <tr class="affected-posts-options">
                            <th scope="row"><label
                                        for="tags"><?php esc_html_e( 'Tags', 'automatic-tooltips' ); ?></label></th>
                            <td>
								<?php

								$current_tags_a = maybe_unserialize( $tooltip_obj->tags );

								echo '<select id="tags" name="tags[]" class="daext-display-none" multiple>';

								$categories = get_categories( array(
									'hide_empty' => 0,
									'orderby'    => 'term_id',
									'order'      => 'DESC',
									'taxonomy'   => 'post_tag'
								) );

								foreach ( $categories as $key => $category ) {
									if ( is_array( $current_tags_a ) and in_array( $category->term_id, $current_tags_a ) ) {
										$selected = 'selected';
									} else {
										$selected = '';
									}
									echo '<option value="' . esc_attr( $category->term_id ) . '" ' . esc_attr($selected) . '>' . esc_html( $category->name ) . '</option>';
								}

								echo '</select>';
								echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which tags the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any tag.', 'automatic-tooltips' ) . '"></div>';

								?>
                            </td>
                        </tr>

                        <!-- Advanced Match Options ---------------------------------------------------------------- -->
                        <tr class="group-trigger" data-trigger-target="advanced-match-options">
                            <th class="group-title"><?php esc_html_e( 'Advanced Match', 'automatic-tooltips' ); ?></th>
                            <td>
                                <div class="expand-icon"></div>
                            </td>
                        </tr>

                        <!-- Case Sensitive Search -->
                        <tr class="advanced-match-options">
                            <th scope="row"><?php esc_html_e( 'Case Sensitive Search', 'automatic-tooltips' ); ?></th>
                            <td>
                                <select id="case-sensitive-search" name="case_sensitive_search"
                                        class="daext-display-none">
                                    <option value="0" <?php selected( intval( $tooltip_obj->case_sensitive_search ),
										0 ); ?>><?php esc_html_e( 'No', 'automatic-tooltips' ); ?></option>
                                    <option value="1" <?php selected( intval( $tooltip_obj->case_sensitive_search ),
										1 ); ?>><?php esc_html_e( 'Yes', 'automatic-tooltips' ); ?></option>
                                </select>
                                <div class="help-icon"
                                     title='<?php esc_attr_e( 'If you select "No" the defined keyword will match both lowercase and uppercase variations.', 'automatic-tooltips' ); ?>'></div>
                            </td>
                        </tr>

                        <!-- Left Boundary -->
                        <tr class="advanced-match-options">
                            <th scope="row"><?php esc_html_e( 'Left Boundary', 'automatic-tooltips' ); ?></th>
                            <td>
                                <select id="left-boundary" name="left_boundary" class="daext-display-none">
                                    <option value="0" <?php selected( intval( $tooltip_obj->left_boundary ),
										0 ); ?>><?php esc_html_e( 'Generic', 'automatic-tooltips' ); ?></option>
                                    <option value="1" <?php selected( intval( $tooltip_obj->left_boundary ),
										1 ); ?>><?php esc_html_e( 'White Space', 'automatic-tooltips' ); ?></option>
                                    <option value="2" <?php selected( intval( $tooltip_obj->left_boundary ),
										2 ); ?>><?php esc_html_e( 'Comma', 'automatic-tooltips' ); ?></option>
                                    <option value="3" <?php selected( intval( $tooltip_obj->left_boundary ),
										3 ); ?>><?php esc_html_e( 'Point', 'automatic-tooltips' ); ?></option>
                                    <option value="4" <?php selected( intval( $tooltip_obj->left_boundary ),
										4 ); ?>><?php esc_html_e( 'None', 'automatic-tooltips' ); ?></option>
                                </select>
                                <div class="help-icon"
                                     title='<?php esc_attr_e( 'Use this option to match keywords preceded by a generic boundary or by a specific character.', 'automatic-tooltips' ); ?>'></div>
                            </td>
                        </tr>

                        <!-- Right Boundary -->
                        <tr class="advanced-match-options">
                            <th scope="row"><?php esc_html_e( 'Right Boundary', 'automatic-tooltips' ); ?></th>
                            <td>
                                <select id="right-boundary" name="right_boundary" class="daext-display-none">
                                    <option value="0" <?php selected( intval( $tooltip_obj->right_boundary ),
										0 ); ?>><?php esc_html_e( 'Generic', 'automatic-tooltips' ); ?></option>
                                    <option value="1" <?php selected( intval( $tooltip_obj->right_boundary ),
										1 ); ?>><?php esc_html_e( 'White Space', 'automatic-tooltips' ); ?></option>
                                    <option value="2" <?php selected( intval( $tooltip_obj->right_boundary ),
										2 ); ?>><?php esc_html_e( 'Comma', 'automatic-tooltips' ); ?></option>
                                    <option value="3" <?php selected( intval( $tooltip_obj->right_boundary ),
										3 ); ?>><?php esc_html_e( 'Point', 'automatic-tooltips' ); ?></option>
                                    <option value="4" <?php selected( intval( $tooltip_obj->right_boundary ),
										4 ); ?>><?php esc_html_e( 'None', 'automatic-tooltips' ); ?></option>
                                </select>
                                <div class="help-icon"
                                     title='<?php esc_attr_e( 'Use this option to match keywords followed by a generic boundary or by a specific character.', 'automatic-tooltips' ); ?>'></div>
                            </td>
                        </tr>

                        <!-- Keyword Before -->
                        <tr class="advanced-match-options">
                            <th scope="row"><label
                                        for="keyword-before"><?php esc_html_e( 'Keyword Before', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
                                <input value="<?php echo esc_attr( stripslashes( $tooltip_obj->keyword_before ) ); ?>"
                                       type="text" id="keyword-before" maxlength="255" size="30" name="keyword_before"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'Use this option to match occurrences preceded by a specific string.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Keyword After -->
                        <tr class="advanced-match-options">
                            <th scope="row"><label
                                        for="keyword-after"><?php esc_html_e( 'Keyword After', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
                                <input value="<?php echo esc_attr( stripslashes( $tooltip_obj->keyword_after ) ); ?>"
                                       type="text" id="keyword-after" maxlength="255" size="30" name="keyword_after"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'Use this option to match occurrences followed by a specific string.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Limit -->
                        <tr class="advanced-match-options">
                            <th scope="row"><label
                                        for="limit"><?php esc_html_e( 'Limit', 'automatic-tooltips' ); ?></label></th>
                            <td>
                                <input value="<?php echo intval( $tooltip_obj->limit, 10 ); ?>" type="text"
                                       id="limit" maxlength="7" size="30" name="limit"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'With this option you can determine the maximum number of tooltips generates from the defined keyword.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Priority -->
                        <tr class="advanced-match-options">
                            <th scope="row"><label
                                        for="priority"><?php esc_html_e( 'Priority', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
                                <input value="<?php echo intval( $tooltip_obj->priority, 10 ); ?>" type="text"
                                       id="priority" maxlength="7" size="30" name="priority"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The priority value determines the order used to apply the tooltips on the post.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                    </table>

                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input class="button" type="submit"
                               value="<?php esc_html_e( 'Update Tooltip', 'automatic-tooltips' ); ?>">
                        <input id="cancel" class="button" type="submit"
                               value="<?php esc_attr_e( 'Cancel', 'automatic-tooltips' ); ?>">
                    </div>

					<?php else : ?>

                    <!-- Create New Tooltip -->

                    <div class="daext-form-container">

                        <div class="daext-form-title"><?php esc_html_e( 'Create New Tooltip', 'automatic-tooltips' ); ?></div>

                        <table class="daext-form daext-form-table">

                            <!-- Keyword -->
                            <tr>
                                <th scope="row"><label
                                            for="keyword"><?php esc_html_e( 'Keyword', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="keyword" maxlength="255" size="30" name="keyword"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'The keyword on which the tooltip will be added.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                            <!-- Text -->
                            <tr>
                                <th scope="row"><label
                                            for="text"><?php esc_html_e( 'Text', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <textarea type="text" id="text" maxlength="255" size="30" name="text"></textarea>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'The text of the tooltip.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                            <!-- Category ID -->
                            <tr>
                                <th scope="row"><label
                                            for="tags"><?php esc_html_e( 'Category', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
									<?php

									echo '<select id="category-id" name="category_id" class="daext-display-none">';

									echo '<option value="0" ' . selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_category_id" ) ),
											0, false ) . '>' . esc_html__( 'None', 'automatic-tooltips' ) . '</option>';

									$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
									$sql        = "SELECT category_id, name FROM $table_name ORDER BY category_id DESC";
									$category_a = $wpdb->get_results( $sql, ARRAY_A );

									foreach ( $category_a as $key => $category ) {
										echo '<option value="' . esc_attr( $category['category_id'] ) . '" ' . selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_category_id" ) ),
												$category['category_id'],
												false ) . '>' . esc_html( stripslashes( $category['name'] ) ) . '</option>';
									}

									echo '</select>';
									echo '<div class="help-icon" title="' . esc_attr__( 'The category of the tooltip.', 'automatic-tooltips' ) . '"></div>';

									?>
                                </td>
                            </tr>

                            <!-- Affected Posts Options ------------------------------------------------------------ -->
                            <tr class="group-trigger" data-trigger-target="affected-posts-options">
                                <th class="group-title"><?php esc_html_e( 'Affected Posts', 'automatic-tooltips' ); ?></th>
                                <td>
                                    <div class="expand-icon"></div>
                                </td>
                            </tr>

                            <!-- Post Types -->
                            <tr class="affected-posts-options">
                                <th scope="row"><label
                                            for="post-types"><?php esc_html_e( 'Post Types', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
									<?php

									$defaults_post_types_a = get_option( "daextauttol_defaults_post_types" );

									$available_post_types_a = get_post_types( array(
										'public'  => true,
										'show_ui' => true
									) );

									//Remove the "attachment" post type
									$available_post_types_a = array_diff( $available_post_types_a, array( 'attachment' ) );

									echo '<select id="post-types" name="post_types[]" class="daext-display-none" multiple>';

									foreach ( $available_post_types_a as $key => $single_post_type ) {
										if ( is_array( $defaults_post_types_a ) and in_array( $single_post_type,
												$defaults_post_types_a ) ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										$post_type_obj = get_post_type_object( $single_post_type );
										echo '<option value="' . esc_attr( $single_post_type ) . '" ' . esc_attr($selected) . '>' . esc_html( $post_type_obj->label ) . '</option>';
									}

									echo '</select>';

									echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which post types the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any post type.', 'automatic-tooltips' ) . '"></div>';

									?>
                                </td>
                            </tr>

                            <!-- Categories -->
                            <tr class="affected-posts-options">
                                <th scope="row"><label
                                            for="categories"><?php esc_html_e( 'Categories', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
									<?php

									$defaults_categories_a = get_option( "daextauttol_defaults_categories" );

									echo '<select id="categories" name="categories[]" class="daext-display-none" multiple>';

									$categories = get_categories( array(
										'hide_empty' => 0,
										'orderby'    => 'term_id',
										'order'      => 'DESC'
									) );

									foreach ( $categories as $key => $category ) {
										if ( is_array( $defaults_categories_a ) and in_array( $category->term_id,
												$defaults_categories_a ) ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo '<option value="' . esc_attr( $category->term_id ) . '" ' . esc_attr($selected) . '>' . esc_html( $category->name ) . '</option>';
									}

									echo '</select>';
									echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which categories the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any category.', 'automatic-tooltips' ) . '"></div>';

									?>
                                </td>
                            </tr>

                            <!-- Tags -->
                            <tr class="affected-posts-options">
                                <th scope="row"><label
                                            for="tags"><?php esc_html_e( 'Tags', 'automatic-tooltips' ); ?></label></th>
                                <td>
									<?php

									$defaults_tags_a = get_option( "daextauttol_defaults_tags" );

									echo '<select id="tags" name="tags[]" class="daext-display-none" multiple>';

									$categories = get_categories( array(
										'hide_empty' => 0,
										'orderby'    => 'term_id',
										'order'      => 'DESC',
										'taxonomy'   => 'post_tag'
									) );

									foreach ( $categories as $key => $category ) {
										if ( is_array( $defaults_tags_a ) and in_array( $category->term_id,
												$defaults_tags_a ) ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo '<option value="' . esc_attr( $category->term_id ) . '" ' . esc_attr($selected) . '>' . esc_html( $category->name ) . '</option>';
									}

									echo '</select>';
									echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which tags the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any tag.', 'automatic-tooltips' ) . '"></div>';

									?>
                                </td>
                            </tr>

                            <!-- Advanced Match Options ------------------------------------------------------------ -->
                            <tr class="group-trigger" data-trigger-target="advanced-match-options">
                                <th class="group-title"><?php esc_attr_e( 'Advanced Match', 'automatic-tooltips' ); ?></th>
                                <td>
                                    <div class="expand-icon"></div>
                                </td>
                            </tr>

                            <!-- Case Sensitive Search -->
                            <tr class="advanced-match-options">
                                <th scope="row"><?php esc_html_e( 'Case Sensitive Search', 'automatic-tooltips' ); ?></th>
                                <td>
                                    <select id="case-sensitive-search" name="case_sensitive_search"
                                            class="daext-display-none">
                                        <option value="0" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_case_sensitive_search" ) ),
											0 ); ?>><?php esc_html_e( 'No', 'automatic-tooltips' ); ?></option>
                                        <option value="1" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_case_sensitive_search" ) ),
											1 ); ?>><?php esc_html_e( 'Yes', 'automatic-tooltips' ); ?></option>
                                    </select>
                                    <div class="help-icon"
                                         title='<?php esc_attr_e( 'If you select "No" the defined keyword will match both lowercase and uppercase variations.', 'automatic-tooltips' ); ?>'></div>
                                </td>
                            </tr>

                            <!-- Left Boundary -->
                            <tr class="advanced-match-options">
                                <th scope="row"><?php esc_html_e( 'Left Boundary', 'automatic-tooltips' ); ?></th>
                                <td>
                                    <select id="left-boundary" name="left_boundary" class="daext-display-none">
                                        <option value="0" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_left_boundary" ) ),
											0 ); ?>><?php esc_html_e( 'Generic', 'automatic-tooltips' ); ?></option>
                                        <option value="1" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_left_boundary" ) ),
											1 ); ?>><?php esc_html_e( 'White Space', 'automatic-tooltips' ); ?></option>
                                        <option value="2" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_left_boundary" ) ),
											2 ); ?>><?php esc_html_e( 'Comma', 'automatic-tooltips' ); ?></option>
                                        <option value="3" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_left_boundary" ) ),
											3 ); ?>><?php esc_html_e( 'Point', 'automatic-tooltips' ); ?></option>
                                        <option value="4" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_left_boundary" ) ),
											4 ); ?>><?php esc_html_e( 'None', 'automatic-tooltips' ); ?></option>
                                    </select>
                                    <div class="help-icon"
                                         title='<?php esc_attr_e( 'Use this option to match keywords preceded by a generic boundary or by a specific character.', 'automatic-tooltips' ); ?>'></div>
                                </td>
                            </tr>

                            <!-- Right Boundary -->
                            <tr class="advanced-match-options">
                                <th scope="row"><?php esc_html_e( 'Right Boundary', 'automatic-tooltips' ); ?></th>
                                <td>
                                    <select id="right-boundary" name="right_boundary" class="daext-display-none">
                                        <option value="0" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_right_boundary" ) ),
											0 ); ?>><?php esc_html_e( 'Generic', 'automatic-tooltips' ); ?></option>
                                        <option value="1" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_right_boundary" ) ),
											1 ); ?>><?php esc_html_e( 'White Space', 'automatic-tooltips' ); ?></option>
                                        <option value="2" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_right_boundary" ) ),
											2 ); ?>><?php esc_html_e( 'Comma', 'automatic-tooltips' ); ?></option>
                                        <option value="3" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_right_boundary" ) ),
											3 ); ?>><?php esc_html_e( 'Point', 'automatic-tooltips' ); ?></option>
                                        <option value="4" <?php selected( intval( get_option( $this->shared->get( 'slug' ) . "_defaults_right_boundary" ) ),
											4 ); ?>><?php esc_html_e( 'None', 'automatic-tooltips' ); ?></option>
                                    </select>
                                    <div class="help-icon"
                                         title='<?php esc_attr_e( 'Use this option to match keywords followed by a generic boundary or by a specific character.', 'automatic-tooltips' ); ?>'></div>
                                </td>
                            </tr>

                            <!-- Keyword Before -->
                            <tr class="advanced-match-options">
                                <th scope="row"><label
                                            for="keyword-before"><?php esc_attr_e( 'Keyword Before', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="keyword-before" maxlength="255" size="30"
                                           name="keyword_before"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'Use this option to match occurrences preceded by a specific string.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                            <!-- Keyword After -->
                            <tr class="advanced-match-options">
                                <th scope="row"><label
                                            for="keyword-after"><?php esc_html_e( 'Keyword After', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="keyword-after" maxlength="255" size="30"
                                           name="keyword_after"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'Use this option to match occurrences followed by a specific string.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                            <!-- Limit -->
                            <tr class="advanced-match-options">
                                <th scope="row"><label
                                            for="limit"><?php esc_html_e( 'Limit', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <input value="<?php echo intval( get_option( $this->shared->get( 'slug' ) . "_defaults_limit" ),
										10 ); ?>" type="text" id="limit" maxlength="7" size="30" name="limit"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'With this option you can determine the maximum number of tooltips generates from the defined keyword.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                            <!-- Priority -->
                            <tr class="advanced-match-options">
                                <th scope="row"><label
                                            for="priority"><?php esc_html_e( 'Priority', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <input value="<?php echo intval( get_option( $this->shared->get( 'slug' ) . "_defaults_priority" ),
										10 ); ?>" type="text" id="priority" maxlength="7" size="30" name="priority"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'The priority value determines the order used to apply the tooltips on the post.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                        </table>

                        <!-- submit button -->
                        <div class="daext-form-action">
                            <input class="button" type="submit"
                                   value="<?php esc_attr_e( 'Add Tooltip', 'automatic-tooltips' ); ?>">
                        </div>

						<?php endif; ?>

                    </div>

            </form>

        </div>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e( 'Delete the tooltip?', 'automatic-tooltips' ); ?>"
     class="daext-display-none">
    <p><?php esc_html_e( 'This tooltip will be permanently deleted and cannot be recovered. Are you sure?', 'automatic-tooltips' ); ?></p>
</div>
