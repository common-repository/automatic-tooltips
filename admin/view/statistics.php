<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'automatic-tooltips' ) );
}

?>

<!-- process data -->

<?php

//Sanitization ---------------------------------------------------------------------------------------------

//Preliminary operations -----------------------------------------------------------------------------------------------
global $wpdb;

//Sanitization ---------------------------------------------------------------------------------------------

//Filter and search data
$data['s'] = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : null;

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_html_e( 'Automatic Tooltips - Statistics', 'automatic-tooltips' ); ?></h2>

        <!-- Search Form -->

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daextauttol-statistics">

            <p><?php esc_html_e( 'Perform your Search', 'automatic-tooltips' ); ?></p>

			<?php
			if ( ! is_null( $data['s'] ) ) {
				$search_string = $data['s'];
			} else {
				$search_string = '';
			}

			?>

            <input type="text" name="s" name="s"
                   value="<?php esc_html_e( stripslashes( $search_string ) ); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="">

        </form>

    </div>

    <div id="daext-menu-wrapper" class="daext-clearfix">

        <div class="tooltips-container">

			<?php

			//search
			if ( ! is_null( $data['s'] ) ) {
				$search_string = $data['s'];
				$filter        = $wpdb->prepare( 'WHERE (post_id LIKE %s)', '%' . $search_string . '%' );
			} else {
				$filter = '';
			}

			//sort -------------------------------------------------

			//retrieve the total number of events
			$table_name  = $wpdb->prefix . $this->shared->get( 'slug' ) . "_statistic";
			$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name " . $filter );

			//Initialize the pagination class
			require_once( $this->shared->get( 'dir' ) . '/admin/inc/class-daextauttol-pagination.php' );
			$pag = new daextauttol_pagination();
			$pag->set_total_items( $total_items );//Set the total number of items
			$pag->set_record_per_page( 10 ); //Set records per page
			$pag->set_target_page( "admin.php?page=" . $this->shared->get( 'slug' ) . "-statistics" );//Set target page
			$pag->set_current_page();//set the current page number

			?>

            <!-- Query the database -->
			<?php
			$query_limit = $pag->query_limit();
			$results     = $wpdb->get_results( "SELECT * FROM $table_name " . $filter . " ORDER BY post_id DESC $query_limit ",
				ARRAY_A ); ?>

			<?php if ( count( $results ) > 0 ) : ?>

                <div class="daext-items-container">

                    <table class="daext-items">
                        <thead>
                        <tr>
                            <th>
                                <div><?php esc_html_e( 'Post ID', 'automatic-tooltips' ); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The post, page or custom post type ID.', 'automatic-tooltips' ); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_html_e( 'Post', 'automatic-tooltips' ); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The post, page or custom post type title.', 'automatic-tooltips' ); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_html_e( 'Content Length', 'automatic-tooltips' ); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The length of the raw (with filters not applied) post content.', 'automatic-tooltips' ); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_html_e( 'Number of tooltips', 'automatic-tooltips' ); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The number of tooltips applied on the post.', 'automatic-tooltips' ); ?>"></div>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

						<?php foreach ( $results as $result ) : ?>

                            <tr>
                                <td><?php echo esc_html( $result['post_id'] ); ?></td>
								<?php
								if ( get_post_status( $result['post_id'] ) !== false ) {
									echo '<td><a href="' . get_the_permalink( $result['post_id'] ) . '">' . get_the_title( $result['post_id'] ) . '</a></td>';
								} else {
									echo '<td>' . esc_html__( 'Not Available', 'automatic-tooltips' ) . '</td>';
								}
								?>
                                <td><?php echo esc_html( $result['content_length'] ); ?></td>
                                <td><?php echo esc_html( $result['number_of_tooltips'] ); ?></td>
                                <td class="icons-container">
									<?php if ( get_post_status( $result['post_id'] ) !== false ) : ?>
                                        <a class="menu-icon edit"
                                           href="post.php?post=<?php echo esc_attr( $result['post_id'] ); ?>&action=edit"></a>
									<?php endif; ?>
                                </td>
                            </tr>

						<?php endforeach; ?>

                        </tbody>
                    </table>

                </div>

			<?php else : ?>

				<?php

				if ( mb_strlen( trim( $filter ) ) > 0 ) {
					echo '<p>' . esc_html__( 'There are no results that match your filter criteria.', 'automatic-tooltips' ) . '</p>';
				} else {
					echo '<p>' . esc_html__( 'There are no data at moment, click on the "Generate" button to generate statistics about the tooltips of your blog.', 'automatic-tooltips' ) . '</p>';
				}

				?>

			<?php endif; ?>

            <!-- Display the pagination -->
			<?php if ( $pag->total_items > 0 ) : ?>
                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo esc_html( $pag->total_items ); ?>&nbsp<?php esc_html_e( 'items', 'automatic-tooltips' ); ?></span>
						<?php $pag->show(); ?>
                    </div>
                </div>
			<?php endif; ?>

        </div><!-- #subscribers-container -->

        <div class="sidebar-container">

            <div class="daext-widget">

                <h3 class="daext-widget-title"><?php esc_html_e( 'Tooltips Data', 'automatic-tooltips' ); ?></h3>

                <div class="daext-widget-content">

                    <p><?php esc_html_e( 'This procedure allows you to generate statistics about the tooltips of your blog.', 'automatic-tooltips' ); ?></p>

                </div><!-- .daext-widget-content -->

                <div class="daext-widget-submit">
                    <input id="ajax-request-status" type="hidden" value="inactive">
                    <input class="button" id="update-archive" type="button"
                           value="<?php esc_attr_e( 'Generate', 'automatic-tooltips' ); ?>">
                    <img id="ajax-loader"
                         src="<?php echo esc_url( $this->shared->get( 'url' ) . 'admin/assets/img/ajax-loader.gif' ); ?>">
                </div>

            </div>

        </div>

    </div>

</div>