<?php

/*
Plugin Name: Automatic Tooltips
Description: Automatically generates tooltips in your posts, pages, and custom post types.
Version: 1.09
Author: DAEXT
Author URI: https://daext.com
Text Domain: automatic-tooltips
*/

//Prevent direct access to this file
if ( ! defined( 'WPINC' ) ) {
	die();
}

//Class shared across public and admin
require_once( plugin_dir_path( __FILE__ ) . 'shared/class-daextauttol-shared.php' );

//Public
require_once( plugin_dir_path( __FILE__ ) . 'public/class-daextauttol-public.php' );
add_action( 'plugins_loaded', array( 'Daextauttol_Public', 'get_instance' ) );

//Perform the Gutenberg related activities only if Gutenberg is present
if ( function_exists( 'register_block_type' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'blocks/src/init.php' );
}

//Admin
if ( is_admin() ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-daextauttol-admin.php' );

	// If this is not an AJAX request, create a new singleton instance of the admin class.
	if(! defined( 'DOING_AJAX' ) || ! DOING_AJAX ){
		add_action( 'plugins_loaded', array( 'Daextauttol_Admin', 'get_instance' ) );
	}

	// Activate the plugin using only the class static methods.
	register_activation_hook( __FILE__, array( 'Daextauttol_Admin', 'ac_activate' ) );

}

//Ajax
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

	//Admin
	require_once( plugin_dir_path( __FILE__ ) . 'class-daextauttol-ajax.php' );
	add_action( 'plugins_loaded', array( 'Daextauttol_Ajax', 'get_instance' ) );

}