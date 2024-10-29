<?php

/*
 * This class should be used to include ajax actions.
 */

class Daextauttol_Ajax {

	protected static $instance = null;
	private $shared = null;

	private function __construct() {

		//assign an instance of the plugin info
		$this->shared = Daextauttol_Shared::get_instance();

		//AJAX requests for logged-in users
		add_action( 'wp_ajax_daextauttol_generate_statistics', array( $this, 'generate_statistics' ) );

	}

	/*
	 * Return an istance of this class.
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/*
	 * Generates the data of the "statistic" table.
	 */
	public function generate_statistics() {

		//check the referer
		if ( ! check_ajax_referer( 'daextauttol', 'security', false ) ) {
			esc_html_e( 'Invalid AJAX Request', 'automatic-tooltips' );
			die();
		}

		//check the capability
		if ( ! current_user_can( 'manage_options' ) ) {
			esc_html_e( 'Invalid Capability', 'automatic-tooltips' );
			die();
		}

		/*
		 * Set the custom "Max Execution Time Value" defined in the options if the "Set Max Execution Time" option is
		 * set to "Yes".
		 */
		if ( intval( get_option( $this->shared->get( 'slug' ) . '_analysis_set_max_execution_time' ), 10 ) === 1 ) {
			ini_set( 'max_execution_time',
				intval( get_option( $this->shared->get( 'slug' ) . '_analysis_max_execution_time_value' ), 10 ) );
		}

		/*
		 * Set the custom "Memory Limit Value" ( in megabytes ) defined in the options if the "Set Memory Limit" option
		 * is set to "Yes".
		 */
		if ( intval( get_option( $this->shared->get( 'slug' ) . '_analysis_set_memory_limit' ), 10 ) == 1 ) {
			ini_set( 'memory_limit',
				intval( get_option( $this->shared->get( 'slug' ) . "_analysis_memory_limit_value" ), 10 ) . 'M' );
		}

		//delete all the records in the "statistic" db table
		global $wpdb;
		$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_statistic";
		$result     = $wpdb->query( "TRUNCATE TABLE $table_name" );

		//Get post types
		$post_types_query      = '';
		$analysis_post_types_a = maybe_unserialize( get_option( $this->shared->get( 'slug' ) . '_analysis_post_types' ) );

		//if $post_types_a is not an array fill $post_types_a with the posts available in the website
		if ( ! is_array( $analysis_post_types_a ) ) {
			$analysis_post_types_a = $this->shared->get_post_types_with_ui();
		}

		//Generate the $post_types_query
		if ( is_array( $analysis_post_types_a ) ) {

			foreach ( $analysis_post_types_a as $key => $value ) {

				$post_types_query .= "post_type = '" . $value . "'";
				if ( $key !== ( count( $analysis_post_types_a ) - 1 ) ) {
					$post_types_query .= ' OR ';
				}

			}

			$post_types_query = '(' . $post_types_query . ') AND';

		}

		//Generates the data of all the posts and save them in the $statistic_a array.
		global $wpdb;
		$table_name           = $wpdb->prefix . "posts";
		$limit_posts_analysis = intval( get_option( $this->shared->get( 'slug' ) . '_analysis_limit_posts_analysis' ), 10 );
		$safe_sql             = $wpdb->prepare( "SELECT ID, post_title, post_type, post_date, post_content FROM $table_name WHERE $post_types_query post_status = 'publish' ORDER BY post_date DESC LIMIT %d", $limit_posts_analysis );
		$posts_a              = $wpdb->get_results( $safe_sql, ARRAY_A );

		//init $statistic_a
		$statistic_a = array();

		foreach ( $posts_a as $key => $single_post ) {

			//Post Id
			$post_id = $single_post['ID'];

			//Content Length
			$content_length = mb_strlen( trim( $single_post['post_content'] ) );

			//Add the tooltips
			$this->shared->add_tooltips( $single_post['post_content'], false,
				$single_post['post_type'], $post_id );
			$number_of_tooltips = $this->shared->number_of_replacements;

			/*
			 * Save data in the $statistic_a array (the data will be later saved into the statistic db table )
			 */
			$statistic_a[] = array(
				'post_id'            => $post_id,
				'content_length'     => $content_length,
				'number_of_tooltips' => $number_of_tooltips
			);

		}

		/*
		 * Save data into the statistic db table with multiple queries of 100 items each one.
		 *
		 * It's a compromise adopted for the following two reasons:
		 *
		 * 1 - For performance, too many queries slow down the process
		 * 2 - To avoid problem with queries too long
		 */
		$table_name         = $wpdb->prefix . $this->shared->get( 'slug' ) . "_statistic";
		$statistic_a_length = count( $statistic_a );
		$query_groups       = array();
		$query_index        = 0;
		foreach ( $statistic_a as $key => $single_statistic ) {

			$query_index = intval( $key / 100, 10 );

			$query_groups[ $query_index ][] = $wpdb->prepare( "( %d, %d, %d )",
				$single_statistic['post_id'],
				$single_statistic['content_length'],
				$single_statistic['number_of_tooltips']
			);

		}

		/*
		 * Each item in the $query_groups array includes a maximum of 100 assigned records. Here each group creates a
		 * query and the query is executed.
		 */
		$query_start = "INSERT INTO $table_name (post_id, content_length, number_of_tooltips) VALUES ";
		$query_end   = '';

		foreach ( $query_groups as $key => $query_values ) {

			$query_body = '';

			foreach ( $query_values as $single_query_value ) {

				$query_body .= $single_query_value . ',';

			}

			$safe_sql = $query_start . substr( $query_body, 0, mb_strlen( $query_body ) - 1 ) . $query_end;

			//save data into the archive db table
			$wpdb->query( $safe_sql );

		}

		//send output
		echo 'success';
		die();

	}

}