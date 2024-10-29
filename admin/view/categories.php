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
$data['s'] = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash($_GET['s']) ) : null;

//Form data
if ( ! is_null( $data['update_id'] ) or ! is_null( $data['form_submitted'] ) ) {

	$data['name']        = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : null;
	$data['description'] = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : null;

	//Validation -------------------------------------------------------------------------------------------------------

	//validation on "name"
	if ( mb_strlen( trim( $data['name'] ) ) === 0 or mb_strlen( trim( $data['name'] ) ) > 100 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Name" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

	//validation on "description"
	if ( mb_strlen( trim( $data['description'] ) ) === 0 or mb_strlen( trim( $data['description'] ) ) > 255 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Description" field.', 'automatic-tooltips' ),
			'class'   => 'error'
		];
		$invalid_data           = true;
	}

}
//update ---------------------------------------------------------------
if ( ! is_null( $data['update_id'] ) and ! isset( $invalid_data ) ) {

	//Update

	$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
	$safe_sql   = $wpdb->prepare( "UPDATE $table_name SET 
            name = %s,
            description = %s
            WHERE category_id = %d",
		$data['name'],
		$data['description'],
		$data['update_id'] );

	$query_result = $wpdb->query( $safe_sql );

	if ( $query_result !== false ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The category has been successfully updated.', 'automatic-tooltips' ),
			'class'   => 'updated'
		];
	}

} else {

	//add ------------------------------------------------------------------
	if ( ! is_null( $data['form_submitted'] ) and ! isset( $invalid_data ) ) {


		$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
		$safe_sql   = $wpdb->prepare( "INSERT INTO $table_name SET 
            name = %s,
            description = %s",
			$data['name'],
			$data['description']
		);

		$query_result = $wpdb->query( $safe_sql );

		if ( $query_result !== false ) {
			$dismissible_notice_a[] = [
				'message' => __( 'The category has been successfully added.', 'automatic-tooltips' ),
				'class'   => 'updated'
			];
		}

	}

}

//delete a category
if ( ! is_null( $data['delete_id'] ) ) {

	//prevent deletion if the category is associated with a tooltip
	if ( $this->shared->category_is_used( $data['delete_id'] ) ) {

		$dismissible_notice_a[] = [
			'message' => __( "This category is associated with one or more tooltips and can't be deleted.", 'automatic-tooltips' ),
			'class'   => 'updated'
		];

	} else {

		$table_name   = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
		$safe_sql     = $wpdb->prepare( "DELETE FROM $table_name WHERE category_id = %d ", $data['delete_id'] );
		$query_result = $wpdb->query( $safe_sql );

		if ( $query_result !== false ) {
			$dismissible_notice_a[] = [
				'message' => __( "The category has been successfully deleted.", 'automatic-tooltips' ),
				'class'   => 'updated'
			];
		}

	}

}

//clone the category
if ( ! is_null( $data['clone_id'] ) ) {

	//clone the category
	$table_name     = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
	$query_result_1 = $wpdb->query( "CREATE TEMPORARY TABLE daextauttol_temporary_table SELECT * FROM $table_name WHERE category_id = " . $data['clone_id'] );
	$query_result_2 = $wpdb->query( "UPDATE daextauttol_temporary_table SET category_id = NULL" );
	$query_result_3 = $wpdb->query( "INSERT INTO $table_name SELECT * FROM daextauttol_temporary_table" );
	$query_result_4 = $wpdb->query( "DROP TEMPORARY TABLE IF EXISTS daextauttol_temporary_table" );

	if ( $query_result_1 !== false and
	     $query_result_2 !== false and
	     $query_result_3 !== false and
	     $query_result_4 !== false ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The category has been successfully duplicated.', 'automatic-tooltips' ),
			'class'   => 'updated'
		];
	}

}

//get the category data
if ( ! is_null( $data['edit_id'] ) ) {
	$table_name   = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
	$safe_sql     = $wpdb->prepare( "SELECT * FROM $table_name WHERE category_id = %d ", $data['edit_id'] );
	$category_obj = $wpdb->get_row( $safe_sql );
}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_html_e( 'Automatic Tooltips - Categories', 'automatic-tooltips' ); ?></h2>

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daextauttol-categories">

            <p><?php esc_html_e( 'Perform your Search', 'automatic-tooltips' ); ?></p>

            <input type="text" name="s"
                   value="<?php echo esc_attr( $data['s'] ); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="">

        </form>

    </div>

    <div id="daext-menu-wrapper">

		<?php $this->dismissible_notice( $dismissible_notice_a ); ?>

        <!-- table -->

		<?php

		$filter = '';

		//create the query part used to filter the results when a search is performed
		if ( ! is_null( $data['s'] ) ) {

			if ( mb_strlen( trim( $data['s'] ) ) > 0 ) {

				$search_string = $data['s'];

				$filter = $wpdb->prepare( 'WHERE (name LIKE %s OR description LIKE %s)',
					'%' . $search_string . '%',
					'%' . $search_string . '%' );

			}

		}

		//retrieve the total number of categories
		$table_name  = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $filter" );

		//Initialize the pagination class
		require_once( $this->shared->get( 'dir' ) . '/admin/inc/class-daextauttol-pagination.php' );
		$pag = new daextauttol_pagination();
		$pag->set_total_items( $total_items );//Set the total number of items
		$pag->set_record_per_page( 10 ); //Set records per page
		$pag->set_target_page( "admin.php?page=" . $this->shared->get( 'slug' ) . "-categories" );//Set target page
		$pag->set_current_page();//set the current page number

		?>

        <!-- Query the database -->
		<?php
		$query_limit = $pag->query_limit();
		$results     = $wpdb->get_results( "SELECT * FROM $table_name $filter ORDER BY category_id DESC $query_limit",
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
                                 title="<?php esc_attr_e( 'The ID of the category.', 'automatic-tooltips' ); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_html_e( 'Name', 'automatic-tooltips' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The name of the category.', 'automatic-tooltips' ); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_html_e( 'Description', 'automatic-tooltips' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The description of the category.', 'automatic-tooltips' ); ?>"></div>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

					<?php foreach ( $results as $result ) : ?>
                        <tr>
                            <td><?php echo intval( $result['category_id'], 10 ); ?></td>
                            <td><?php echo esc_html( stripslashes( $result['name'] ) ); ?></td>
                            <td><?php echo esc_html( stripslashes( $result['description'] ) ); ?></td>
                            <td class="icons-container">
                                <form method="POST"
                                      action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-categories">
                                    <input type="hidden" name="clone_id" value="<?php echo esc_attr($result['category_id']); ?>">
                                    <input class="menu-icon clone help-icon" type="submit" value="">
                                </form>
                                <a class="menu-icon edit"
                                   href="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-categories&edit_id=<?php echo esc_attr( $result['category_id'] ); ?>"></a>
                                <form id="form-delete-<?php echo esc_attr( $result['category_id'] ); ?>" method="POST"
                                      action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-categories">
                                    <input type="hidden" value="<?php echo esc_attr( $result['category_id'] ); ?>"
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

            <form method="POST" action="admin.php?page=<?php echo $this->shared->get( 'slug' ); ?>-categories"
                  autocomplete="off">

                <input type="hidden" value="1" name="form_submitted">

				<?php if ( ! is_null( $data['edit_id'] ) ) : ?>

                <!-- Edit a Category -->

                <div class="daext-form-container">

                    <h3 class="daext-form-title"><?php esc_html_e( 'Edit Category', 'automatic-tooltips' ); ?>
                        &nbsp<?php echo esc_html( $category_obj->category_id ); ?></h3>

                    <table class="daext-form daext-form-table">

                        <input type="hidden" name="update_id"
                               value="<?php echo esc_attr($category_obj->category_id); ?>"/>

                        <!-- Name -->
                        <tr valign="top">
                            <th><label for="title"><?php esc_html_e( 'Name', 'automatic-tooltips' ); ?></label></th>
                            <td>
                                <input value="<?php echo esc_attr( stripslashes( $category_obj->name ) ); ?>"
                                       type="text"
                                       id="name" maxlength="100" size="30" name="name"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The name of the category.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Description -->
                        <tr valign="top">
                            <th><label for="title"><?php esc_html_e( 'Description', 'automatic-tooltips' ); ?></label>
                            </th>
                            <td>
                                <input value="<?php echo esc_attr( stripslashes( $category_obj->description ) ); ?>"
                                       type="text" id="description" maxlength="255" size="30" name="description"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The description of the category.', 'automatic-tooltips' ); ?>"></div>
                            </td>
                        </tr>

                    </table>

                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input class="button" type="submit"
                               value="<?php esc_attr_e( 'Update Category', 'automatic-tooltips' ); ?>">
                        <input id="cancel" class="button" type="submit"
                               value="<?php esc_attr_e( 'Cancel', 'automatic-tooltips' ); ?>">
                    </div>

					<?php else : ?>

                    <!-- Create a Category -->

                    <div class="daext-form-container">

                        <div class="daext-form-title"><?php esc_html_e( 'Create New Category', 'automatic-tooltips' ); ?></div>

                        <table class="daext-form daext-form-table">

                            <!-- Name -->
                            <tr valign="top">
                                <th><label for="title"><?php esc_html_e( 'Name', 'automatic-tooltips' ); ?></label></th>
                                <td>
                                    <input type="text" id="name" maxlength="100" size="30" name="name"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'The name of the category.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                            <!-- Description -->
                            <tr valign="top">
                                <th>
                                    <label for="title"><?php esc_html_e( 'Description', 'automatic-tooltips' ); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="description" maxlength="255" size="30" name="description"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e( 'The description of the category.', 'automatic-tooltips' ); ?>"></div>
                                </td>
                            </tr>

                        </table>

                        <!-- submit button -->
                        <div class="daext-form-action">
                            <input class="button" type="submit"
                                   value="<?php esc_attr_e( 'Add Category', 'automatic-tooltips' ); ?>">
                        </div>

						<?php endif; ?>

                    </div>

            </form>

        </div>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e( 'Delete the category?', 'automatic-tooltips' ); ?>"
     class="daext-display-none">
    <p><?php esc_html_e( 'This category will be permanently deleted and cannot be recovered. Are you sure?', 'automatic-tooltips' ); ?></p>
</div>