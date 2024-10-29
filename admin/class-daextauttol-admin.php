<?php

/*
 * This class should be used to work with the administrative side of WordPress.
 */

class Daextauttol_Admin {

	private $menu_options = null;

	protected static $instance = null;
	private $shared = null;

	private $screen_id_statistics = null;
	private $screen_id_tooltips = null;
	private $screen_id_categories = null;
	private $screen_id_help = null;
	private $screen_id_options = null;

	private function __construct() {

		//assign an instance of the plugin info
		$this->shared = Daextauttol_Shared::get_instance();

		//Load admin stylesheets and JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		//Add the admin menu
		add_action( 'admin_menu', array( $this, 'me_add_admin_menu' ) );

		//Load the options API registrations and callbacks
		add_action( 'admin_init', array( $this, 'op_register_options' ) );

		//Add the meta box
		add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );

		//Save the meta box
		add_action( 'save_post', array( $this, 'save_meta_box' ) );

		//this hook is triggered during the creation of a new blog
		add_action( 'wpmu_new_blog', array( $this, 'new_blog_create_options_and_tables' ), 10, 6 );

		//this hook is triggered during the deletion of a blog
		add_action( 'delete_blog', array( $this, 'delete_blog_delete_options_and_tables' ), 10, 1 );

		//Require and instantiate the class used to register the menu options
		require_once( $this->shared->get( 'dir' ) . 'admin/inc/class-daextauttol-menu-options.php' );
		$this->menu_options = new Daextauttol_Menu_Options( $this->shared );

	}

	/*
	 * return an instance of this class
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/*
	 * Enqueue admin specific styles.
	 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();

		//Menu Statistics
		if ( $screen->id == $this->screen_id_statistics ) {

			//Framework Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu',
				$this->shared->get( 'url' ) . 'admin/assets/css/framework/menu.css', array(), $this->shared->get( 'ver' ) );

			//Statistics Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-statistics',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-statistics.css', array(), $this->shared->get( 'ver' ) );

			//jQuery UI Tooltip
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-tooltip.css', array(),
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get( 'ver' ) );

		}

		//Menu Tooltips
		if ( $screen->id == $this->screen_id_tooltips ) {

			//Framework Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu',
				$this->shared->get( 'url' ) . 'admin/assets/css/framework/menu.css', array(), $this->shared->get( 'ver' ) );

			//Tooltips Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-tooltips',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-tooltips.css', array(), $this->shared->get( 'ver' ) );

			//jQuery UI Dialog
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-dialog',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-dialog-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
				$this->shared->get( 'ver' ) );

			//jQuery UI Tooltip
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-tooltip.css', array(),
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get( 'ver' ) );

		}

		//Menu Categories
		if ( $screen->id == $this->screen_id_categories ) {

			//Framework Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu',
				$this->shared->get( 'url' ) . 'admin/assets/css/framework/menu.css', array(), $this->shared->get( 'ver' ) );

			//Categories Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-categories',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-categories.css', array(), $this->shared->get( 'ver' ) );

			//jQuery UI Dialog
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-dialog',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-dialog-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
				$this->shared->get( 'ver' ) );

			//jQuery UI Tooltip
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-tooltip.css', array(),
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get( 'ver' ) );

		}

		//Menu Help
		if ( $screen->id == $this->screen_id_help ) {

			//Pro Version Menu
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-help',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-help.css', array(), $this->shared->get( 'ver' ) );

		}

		//Menu Options
		if ( $screen->id == $this->screen_id_options ) {

			//Color picker
			wp_enqueue_style( 'wp-color-picker' );

			//Framework Options
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-options',
				$this->shared->get( 'url' ) . 'admin/assets/css/framework/options.css', array(),
				$this->shared->get( 'ver' ) );

			//jQuery UI Tooltip
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-tooltip.css', array(),
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-chosen-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get( 'ver' ) );

		}

	}

	/*
	 * Enqueue admin-specific JavaScript.
	 */
	public function enqueue_admin_scripts() {

		$wp_localize_script_data = array(
			'deleteText'         => esc_html__( 'Delete', 'automatic-tooltips' ),
			'cancelText'         => esc_html__( 'Cancel', 'automatic-tooltips' ),
			'chooseAnOptionText' => esc_html__( 'Choose an Option ...', 'automatic-tooltips' ),
		);

		$screen = get_current_screen();

		//Menu Statistics
		if ( $screen->id == $this->screen_id_statistics ) {

			//Statistics Menu
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-statistics',
				$this->shared->get( 'url' ) . 'admin/assets/js/menu-statistics.js', 'jquery', $this->shared->get( 'ver' ) );

			//Store the JavaScript parameters in the window.DAEXTULMA_PARAMETERS object
			$initialization_script = 'window.DAEXTAUTTOL_PHPDATA = {';
			$initialization_script .= 'ajaxUrl: "' . admin_url( 'admin-ajax.php' ) . '",';
			$initialization_script .= 'nonce: "' . wp_create_nonce( "daextauttol" ) . '",';
			$initialization_script .= 'adminUrl: "' . get_admin_url() . '",';
			$initialization_script .= '};';

			//Add the inline script with the PHP data
			wp_add_inline_script( $this->shared->get( 'slug' ) . '-menu-statistics', $initialization_script, 'before' );

			//jQuery UI Tooltip
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/chosen-init.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_localize_script( $this->shared->get( 'slug' ) . '-chosen-init', 'objectL10n', $wp_localize_script_data );

		}

		//Menu Tooltips
		if ( $screen->id == $this->screen_id_tooltips ) {

			//Tooltips Menu
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-tooltips',
				$this->shared->get( 'url' ) . 'admin/assets/js/menu-tooltips.js', array( 'jquery', 'jquery-ui-dialog' ),
				$this->shared->get( 'ver' ) );
			wp_localize_script( $this->shared->get( 'slug' ) . '-menu-tooltips', 'objectL10n', $wp_localize_script_data );

			//jQuery UI Tooltip
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/chosen-init.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_localize_script( $this->shared->get( 'slug' ) . '-chosen-init', 'objectL10n', $wp_localize_script_data );

		}

		//Menu Categories
		if ( $screen->id == $this->screen_id_categories ) {

			//Categories Menu
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-categories',
				$this->shared->get( 'url' ) . 'admin/assets/js/menu-categories.js', array(
					'jquery',
					'jquery-ui-dialog'
				),
				$this->shared->get( 'ver' ) );
			wp_localize_script( $this->shared->get( 'slug' ) . '-menu-categories', 'objectL10n', $wp_localize_script_data );

			//jQuery UI Tooltip
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/chosen-init.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_localize_script( $this->shared->get( 'slug' ) . '-chosen-init', 'objectL10n', $wp_localize_script_data );

		}

		//Menu Options
		if ( $screen->id == $this->screen_id_options ) {

			//Color Picker Initialization
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-wp-color-picker-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/wp-color-picker-init.js',
				array( 'jquery', 'wp-color-picker' ), false, true );

			//jQuery UI Tooltip
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
				$this->shared->get( 'ver' ) );

			//Chosen
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen',
				$this->shared->get( 'url' ) . 'admin/assets/inc/chosen/chosen-min.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-chosen-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/chosen-init.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );
			wp_localize_script( $this->shared->get( 'slug' ) . '-chosen-init', 'objectL10n', $wp_localize_script_data );

		}

	}

	/*
	 * plugin activation
	 */
	static public function ac_activate( $networkwide ) {

		/*
		 * delete options and tables for all the sites in the network
		 */
		if ( function_exists( 'is_multisite' ) and is_multisite() ) {

			/*
			 * if this is a "Network Activation" create the options and tables
			 * for each blog
			 */
			if ( $networkwide ) {

				//get the current blog id
				global $wpdb;
				$current_blog = $wpdb->blogid;

				//create an array with all the blog ids
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

				//iterate through all the blogs
				foreach ( $blogids as $blog_id ) {

					//swith to the iterated blog
					switch_to_blog( $blog_id );

					//create options and tables for the iterated blog
					self::ac_initialize_options();
					self::ac_create_database_tables();
					self::ac_initialize_custom_css();

				}

				//switch to the current blog
				switch_to_blog( $current_blog );

			} else {

				/*
				 * if this is not a "Network Activation" create options and
				 * tables only for the current blog
				 */
				self::ac_initialize_options();
				self::ac_create_database_tables();
				self::ac_initialize_custom_css();

			}

		} else {

			/*
			 * if this is not a multisite installation create options and
			 * tables only for the current blog
			 */
			self::ac_initialize_options();
			self::ac_create_database_tables();
			self::ac_initialize_custom_css();

		}

	}

	//create the options and tables for the newly created blog
	public function new_blog_create_options_and_tables( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

		global $wpdb;

		/*
		 * if the plugin is "Network Active" create the options and tables for
		 * this new blog
		 */
		if ( is_plugin_active_for_network( 'automatic-tooltips/init.php' ) ) {

			//get the id of the current blog
			$current_blog = $wpdb->blogid;

			//switch to the blog that is being activated
			switch_to_blog( $blog_id );

			//create options and database tables for the new blog
			$this->ac_initialize_options();
			$this->ac_create_database_tables();
			$this->ac_initialize_custom_css();

			//switch to the current blog
			switch_to_blog( $current_blog );

		}

	}

	//delete options and tables for the deleted blog
	public function delete_blog_delete_options_and_tables( $blog_id ) {

		global $wpdb;

		//get the id of the current blog
		$current_blog = $wpdb->blogid;

		//switch to the blog that is being activated
		switch_to_blog( $blog_id );

		//create options and database tables for the new blog
		$this->un_delete_options();
		$this->un_delete_database_tables();

		//switch to the current blog
		switch_to_blog( $current_blog );

	}

	/*
	 * initialize plugin options
	 */
	static public function ac_initialize_options() {

		//assign an instance of Daextauttol_Shared
		$shared = Daextauttol_Shared::get_instance();

		foreach ( $shared->get( 'options' ) as $key => $value ) {
			add_option( $key, $value );
		}

	}

	/*
	 * Create the plugin database tables.
	 */
	static public function ac_create_database_tables() {

		global $wpdb;

		//Get the database character collate that will be appended at the end of each query
		$charset_collate = $wpdb->get_charset_collate();

		//check database version and create the database
		if ( intval( get_option( 'daextauttol_database_version' ), 10 ) < 1 ) {

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			//create *prefix*_statistic
			$table_name = $wpdb->prefix . "daextauttol_statistic";
			$sql        = "CREATE TABLE $table_name (
                statistic_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                post_id BIGINT UNSIGNED,
                content_length BIGINT UNSIGNED,
                number_of_tooltips BIGINT UNSIGNED
            ) $charset_collate";
			dbDelta( $sql );

			//create *prefix*_tooltip
			$table_name = $wpdb->prefix . "daextauttol_tooltip";
			$sql        = "CREATE TABLE $table_name (
                tooltip_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                category_id BIGINT UNSIGNED,
                keyword TEXT,
                text TEXT,
                case_sensitive_search TINYINT UNSIGNED,
                `limit` INT UNSIGNED,
                priority INT UNSIGNED,
                left_boundary SMALLINT UNSIGNED,
                right_boundary SMALLINT UNSIGNED,
                keyword_before TEXT,
                keyword_after TEXT,
                post_types TEXT,
                categories TEXT,
                tags TEXT
            ) $charset_collate";
			dbDelta( $sql );

			//create *prefix*_category
			$table_name = $wpdb->prefix . "daextauttol_category";
			$sql        = "CREATE TABLE $table_name (
                category_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name TEXT,
                description TEXT
            ) $charset_collate";
			dbDelta( $sql );

			//Update database version
			update_option( 'daextauttol_database_version', "1" );

		}

	}

	/*
	 * Plugin delete.
	 */
	static public function un_delete() {

		/*
		 * Delete options and tables for all the sites in the network.
		 */
		if ( function_exists( 'is_multisite' ) and is_multisite() ) {

			//get the current blog id
			global $wpdb;
			$current_blog = $wpdb->blogid;

			//create an array with all the blog ids
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

			//iterate through all the blogs
			foreach ( $blogids as $blog_id ) {

				//switch to the iterated blog
				switch_to_blog( $blog_id );

				//create options and tables for the iterated blog
				Daextauttol_Admin::un_delete_options();
				Daextauttol_Admin::un_delete_database_tables();

			}

			//switch to the current blog
			switch_to_blog( $current_blog );

		} else {

			/*
			 * If this is not a multisite installation delete options and tables only for the current blog.
			 */
			Daextauttol_Admin::un_delete_options();
			Daextauttol_Admin::un_delete_database_tables();

		}

	}

	/*
	 * Delete plugin options.
	 */
	static public function un_delete_options() {

		//assign an instance of Daextauttol_Shared
		$shared = Daextauttol_Shared::get_instance();

		foreach ( $shared->get( 'options' ) as $key => $value ) {
			delete_option( $key );
		}

	}

	/*
	 * Delete plugin database tables.
	 */
	static public function un_delete_database_tables() {

		//assign an instance of Daextauttol_Shared
		$shared = Daextauttol_Shared::get_instance();

		global $wpdb;

		$table_name = $wpdb->prefix . $shared->get( 'slug' ) . "_statistic";
		$sql        = "DROP TABLE $table_name";
		$wpdb->query( $sql );

		$table_name = $wpdb->prefix . $shared->get( 'slug' ) . "_tooltip";
		$sql        = "DROP TABLE $table_name";
		$wpdb->query( $sql );

		$table_name = $wpdb->prefix . $shared->get( 'slug' ) . "_category";
		$sql        = "DROP TABLE $table_name";
		$wpdb->query( $sql );

	}

	/*
	 * Register the admin menu.
	 */
	public function me_add_admin_menu() {

		add_menu_page(
			esc_html__( 'AT', 'automatic-tooltips' ),
			esc_html__( 'Tooltips', 'automatic-tooltips' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-tooltips',
			array( $this, 'me_display_menu_tooltips' ),
			'dashicons-testimonial'
		);

		$this->screen_id_tooltips = add_submenu_page(
			$this->shared->get( 'slug' ) . '-tooltips',
			esc_html__( 'AT - Tooltips', 'automatic-tooltips' ),
			esc_html__( 'Tooltips', 'automatic-tooltips' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-tooltips',
			array( $this, 'me_display_menu_tooltips' )
		);

		$this->screen_id_categories = add_submenu_page(
			$this->shared->get( 'slug' ) . '-tooltips',
			esc_html__( 'AT - Categories', 'automatic-tooltips' ),
			esc_html__( 'Categories', 'automatic-tooltips' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-categories',
			array( $this, 'me_display_menu_categories' )
		);

		$this->screen_id_statistics = add_submenu_page(
			$this->shared->get( 'slug' ) . '-tooltips',
			esc_html__( 'AT - Statistics', 'automatic-tooltips' ),
			esc_html__( 'Statistics', 'automatic-tooltips' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-statistics',
			array( $this, 'me_display_menu_statistics' )
		);

		$this->screen_id_help = add_submenu_page(
			$this->shared->get( 'slug' ) . '-tooltips',
			esc_html__( 'AT - Help', 'automatic-tooltips' ),
			esc_html__( 'Help', 'automatic-tooltips' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-help',
			array( $this, 'me_display_menu_help' )
		);

		$this->screen_id_options = add_submenu_page(
			$this->shared->get( 'slug' ) . '-tooltips',
			esc_html__( 'AT - Options', 'automatic-tooltips' ),
			esc_html__( 'Options', 'automatic-tooltips' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-options',
			array( $this, 'me_display_menu_options' )
		);

	}

	/*
	 * includes the statistics view
	 */
	public function me_display_menu_statistics() {
		include_once( 'view/statistics.php' );
	}

	/*
	 * includes the tooltips view
	 */
	public function me_display_menu_tooltips() {
		include_once( 'view/tooltips.php' );
	}

	/*
	 * includes the categories view
	 */
	public function me_display_menu_categories() {
		include_once( 'view/categories.php' );
	}

	/*
     * includes the help view
     */
	public function me_display_menu_help() {
		include_once( 'view/help.php' );
	}

	/*
	 * includes the options view
	 */
	public function me_display_menu_options() {
		include_once( 'view/options.php' );
	}

	/*
	 * register options
	 */
	public function op_register_options() {

		$this->menu_options->register_options();

	}

	//meta box ---------------------------------------------------------------------------------------------------------
	public function create_meta_box() {

		if ( current_user_can( 'manage_options' ) ) {

			add_meta_box( 'daextauttol-automatic-tooltips',
				esc_html__( 'Automatic Tooltips', 'automatic-tooltips' ),
				array( $this, 'automatic_tooltips_meta_box_callback' ),
				null,
				'normal',
				'high',

				/*
				 * Reference:
				 *
				 * https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
				 */
				array(

					/*
					 * It's not confirmed that this meta box works in the block editor.
					 */
					'__block_editor_compatible_meta_box' => false,

					/*
					 * This meta box should only be loaded in the classic editor interface, and the block editor
					 * should not display it.
					 */
					'__back_compat_meta_box'             => true

				) );

		}

	}

	public function automatic_tooltips_meta_box_callback( $post ) {

		$enable_tooltips = get_post_meta( $post->ID, '_daextauttol_enable_tooltips', true );

		//if the $enable_tooltips is empty use the Enable Tooltips option as a default value
		if ( mb_strlen( trim( $enable_tooltips ) ) === 0 ) {
			$enable_tooltips = get_option( $this->shared->get( 'slug' ) . '_advanced_enable_tooltips' );
		}

		?>

        <table class="form-table table-automatic-tooltips">
            <tbody>

            <tr>
                <th scope="row"><label><?php esc_html_e( 'Enable Tooltips:', 'automatic-tooltips' ); ?></label></th>
                <td>
                    <select id="daextauttol-enable-tooltips" name="daextauttol_enable_tooltips">
                        <option <?php selected( intval( $enable_tooltips, 10 ), 0 ); ?>
                                value="0"><?php esc_html_e( 'No', 'automatic-tooltips' ); ?></option>
                        <option <?php selected( intval( $enable_tooltips, 10 ), 1 ); ?>
                                value="1"><?php esc_html_e( 'Yes', 'automatic-tooltips' ); ?></option>
                    </select>
                </td>
            </tr>

            </tbody>
        </table>

		<?php

		//Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'daextauttol_nonce' );

	}

	//Save the Automatic Tooltips Options meta data
	public function save_meta_box( $post_id ) {

		//Security Verifications Start ---------------------------------------------------------------------------------

		//Verify if this is an auto save routine. Don't do anything if our form has not been submitted.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		/*
		 * Verify if this came from the our screen and with proper authorization, because save_post can be triggered at
		 * other times/
		 */
		if ( ! isset( $_POST['daextauttol_nonce'] ) || ! wp_verify_nonce( $_POST['daextauttol_nonce'], plugin_basename( __FILE__ ) ) ) {
			return;
		}

		//Verify the capability
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		//Security Verifications End -----------------------------------------------------------------------------------

		//Save the "Enable Tooltips"
		update_post_meta( $post_id, '_daextauttol_enable_tooltips', intval( $_POST['daextauttol_enable_tooltips'], 10 ) );

	}

	/*
     * Generate the custom.css file based on the values of the options and write them down in the custom.css file.
     */
	static public function write_custom_css() {

		//turn on output buffering
		ob_start();

		//Background color
		echo ".daextauttol-tooltip::before, .daextauttol-tooltip::after{ --tooltip-color: " . esc_attr( get_option( "daextauttol_style_tooltip_background_color" ) ) . " !important;}";

		//Tooltip Font Color
		echo ".daextauttol-tooltip::before{ color: " . esc_attr( get_option( "daextauttol_style_tooltip_font_color" ) ) . " !important;}";

		//Tooltip Line Height
		echo ".daextauttol-tooltip::before{ line-height: " . intval( get_option( "daextauttol_style_tooltip_font_line_height" ), 10 ) . "px !important;}";

		//Tooltip Horizontal Padding
		echo ".daextauttol-tooltip::before{ padding-left: " . intval( get_option( "daextauttol_style_tooltip_horizontal_padding" ), 10 ) . "px !important;}";
		echo ".daextauttol-tooltip::before{ padding-right: " . intval( get_option( "daextauttol_style_tooltip_horizontal_padding" ), 10 ) . "px !important;}";

		//Tooltip Vertical Padding
		echo ".daextauttol-tooltip::before{ padding-top: " . intval( get_option( "daextauttol_style_tooltip_vertical_padding" ), 10 ) . "px !important;}";
		echo ".daextauttol-tooltip::before{ padding-bottom: " . intval( get_option( "daextauttol_style_tooltip_vertical_padding" ), 10 ) . "px !important;}";

		//Tooltip Border Radius
		echo ".daextauttol-tooltip::before{ border-radius: " . intval( get_option( "daextauttol_style_tooltip_border_radius" ), 10 ) . "px !important;}";

		//Tooltip Max Width
		echo ".daextauttol-tooltip::before{ max-width: " . intval( get_option( "daextauttol_style_tooltip_max_width" ), 10 ) . "px !important;}";

		//Tooltip Text Alignment
		echo ".daextauttol-tooltip::before{ text-align: " . esc_attr( get_option( "daextauttol_style_tooltip_text_alignment" ) ) . " !important;}";

		//Tooltip Drop Shadow
		if ( intval( get_option( "daextauttol_style_tooltip_drop_shadow" ), 10 ) === 1 ) {
			echo ".daextauttol-tooltip::before{ box-shadow: 0 2px 6px rgb(0 0 0 / 12%) !important;}";
		}

		//Tooltip Animation
		if ( intval( get_option( "daextauttol_style_tooltip_animation" ), 10 ) === 1 ) {
			echo ".daextauttol-tooltip::before, .daextauttol-tooltip::after{ transition: " . intval( get_option( "daextauttol_style_tooltip_animation_transition_duration" ), 10 ) . "ms transform !important;}";
		}

		//Tooltip Arrow Size
		echo ".daextauttol-tooltip::before, .daextauttol-tooltip::after{ --arrow-size: " . intval( get_option( "daextauttol_style_tooltip_arrow_size" ), 10 ) . "px !important;}";

		//Keyword Background Color
		echo ".daextauttol-tooltip{ background: " . esc_attr( get_option( "daextauttol_style_keyword_background_color" ) ) . " !important;}";

		//Tooltip Keyword Color
		echo ".daextauttol-tooltip{ color: " . esc_attr( get_option( "daextauttol_style_keyword_font_color" ) ) . " !important;}";

		//Tooltip Font Family
		echo '.daextauttol-tooltip{font-family: ' . htmlspecialchars( get_option( "daextauttol_style_keyword_font_family" ),
				ENT_COMPAT ) . ' !important; }';

		//Tooltip Font Weight
		echo ".daextauttol-tooltip{ font-weight: " . esc_attr( get_option( "daextauttol_style_tooltip_font_weight" ) ) . " !important;}";

		//Tooltip Font Size
		echo ".daextauttol-tooltip{ font-size: " . esc_attr( get_option( "daextauttol_style_keyword_font_size" ) ) . "px !important;}";

		//Keyword Font Weight
		echo ".daextauttol-tooltip{ font-weight: " . esc_attr( get_option( "daextauttol_style_keyword_font_weight" ) ) . " !important;}";

		//Tooltip Keyword Decoration
		echo ".daextauttol-tooltip{ text-decoration: " . esc_attr( get_option( "daextauttol_style_keyword_decoration" ) ) . " !important;}";

		//Tooltip Font Size
		echo ".daextauttol-tooltip::before{ font-size: " . esc_attr( get_option( "daextauttol_style_tooltip_font_size" ) ) . "px !important;}";

		//Tooltip Font Family
		echo '.daextauttol-tooltip::before{font-family: ' . htmlspecialchars( get_option( "daextauttol_style_tooltip_font_family" ),
				ENT_COMPAT ) . ' !important; }';

		$custom_css_string = ob_get_clean();

		//Get the upload directory path and the file path
		$upload_dir_path  = self::get_plugin_upload_path();
		$upload_file_path = self::get_plugin_upload_path() . 'custom-' . get_current_blog_id() . '.css';

		//If the plugin upload directory doesn't exists create it
		if ( ! is_dir( $upload_dir_path ) ) {
			mkdir( $upload_dir_path );
		}

		//Write the custom css file
		return @file_put_contents( $upload_file_path,
			$custom_css_string, LOCK_EX );

	}

	/*
     * Create the custom-[blog_id].css file.
     */
	static public function ac_initialize_custom_css() {

		/*
		 * Write the custom-[blog_id].css file or die if the file can't be created or modified.
		 */
		if ( self::write_custom_css() === false ) {
			die( "The plugin can't write files in the upload directory." );
		}

	}

	/**
	 * Get the plugin upload path.
	 *
	 * @return string The plugin upload path
	 */
	static public function get_plugin_upload_path() {

		$upload_path = WP_CONTENT_DIR . '/uploads/daextauttol_uploads/';

		return $upload_path;

	}

	/**
	 * Echo all the dismissible notices based on the values of the $notices array.
	 *
	 * @param $notices
	 */
	public function dismissible_notice( $notices ) {

		foreach ( $notices as $notice ) {
			echo '<div class="' . esc_attr( $notice['class'] ) . ' settings-error notice is-dismissible below-h2"><p>' . esc_html( $notice['message'] ) . '</p></div>';
		}

	}

}