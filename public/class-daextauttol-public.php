<?php

/*
 * This class should be used to work with the public side of wordpress.
 */

class Daextauttol_Public {

	//general class properties
	protected static $instance = null;
	private $shared = null;

	private function __construct() {

		//assign an instance of the plugin info
		$this->shared = Daextauttol_Shared::get_instance();

		/*
		 * Add the tooltips on the content if the test mode option is not activated or if the current user has the
		 * 'manage_options' capability.
		 */
		if (
			intval( get_option( $this->shared->get( 'slug' ) . '_advanced_enable_test_mode' ), 10 ) === 0 or
			current_user_can( 'manage_options' )
		) {
			add_filter( 'the_content', array( $this->shared, 'add_tooltips' ),
				intval( get_option( $this->shared->get( 'slug' ) . '_advanced_filter_priority' ), 10 ) );
		}

		/**
		 * Register specific meta fields to the Rest API
		 */
		add_action( 'init', array( $this, 'rest_api_register_meta' ) );

		/*
		 * Add custom routes to the Rest API
		 */
		add_action( 'rest_api_init', array( $this, 'rest_api_register_route' ) );

		//Load public css
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}

	/*
	 * Creates an instance of this class.
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	//Load public css
	public function enqueue_styles() {

		//Enqueue the main stylesheet
		wp_enqueue_style( $this->shared->get( 'slug' ) . '-general',
			$this->shared->get( 'url' ) . 'public/assets/css/general.css', array(), $this->shared->get( 'ver' ) );

		//Enqueue the custom CSS file based on the plugin options
		$upload_dir_data = wp_upload_dir();
		wp_enqueue_style( $this->shared->get( 'slug' ) . '-custom',
			$upload_dir_data['baseurl'] . '/daextauttol_uploads/custom-' . get_current_blog_id() . '.css', array(),
			$this->shared->get( 'ver' ) );

	}

	/*
	 * Register specific meta fields to the Rest API
	 */
	function rest_api_register_meta() {

		register_meta( 'post', '_daextauttol_enable_tooltips', array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return true;
			}
		) );

	}

	/*
	 * Add custom routes to the Rest API
	 */
	function rest_api_register_route() {

		//Add the GET 'automatic-tooltips/v1/options' endpoint to the Rest API
		register_rest_route(
			'automatic-tooltips/v1', '/options', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'rest_api_daext_automatic_tooltips_read_options_callback' ),
				'permission_callback' => '__return_true'
			)
		);

	}

	/*
	 * Callback for the GET 'automatic-tooltips/v1/options' endpoint of the Rest API
	 */
	function rest_api_daext_automatic_tooltips_read_options_callback( $data ) {

		//Check the capability
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error(
				'rest_read_error',
				esc_html__( 'Sorry, you are not allowed to view the Automatic Tooltips options.', 'automatic-tooltips' ),
				array( 'status' => 403 )
			);
		}

		//Generate the response
		$response = [];
		foreach ( $this->shared->get( 'options' ) as $key => $value ) {
			$response[ $key ] = get_option( $key );
		}

		//Prepare the response
		$response = new WP_REST_Response( $response );

		return $response;

	}

}