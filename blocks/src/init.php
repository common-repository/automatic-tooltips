<?php

//Prevent direct access to this file
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * Enqueue the Gutenberg block assets for the backend.
 *
 * This function should be used for:
 *
 * - Hooks into editor only
 * - For main block JS
 * - For editor only block CSS overrides
 */
function daextauttol_editor_assets() {

	$shared = daextauttol_Shared::get_instance();

	//Do not enqueue the sidebar files if the user doesn't have the proper capability
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	//Do not enqueue the sidebar files if this post type doesn't support the meta data
	if ( ! post_type_supports( get_post_type(), 'custom-fields' ) ) {
		return;
	}

	//Styles -----------------------------------------------------------------------------------------------------------
	wp_enqueue_style(
		'dagp-editor-css',
		$shared->get( 'url' ) . 'blocks/dist/editor.build.css',
		array( 'wp-edit-blocks' ),//Dependency to include the CSS after it.
		filemtime( $shared->get( 'dir' ) . 'blocks/dist/editor.build.css' )
	);

	//Scripts ----------------------------------------------------------------------------------------------------------
	wp_enqueue_script(
		'daextauttol-editor-js', // Handle.
		$shared->get( 'url' ) . 'blocks/dist/blocks.build.js', //We register the block here.
		array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),
		filemtime( $shared->get( 'dir' ) . 'blocks/dist/blocks.build.js' ),
		true //Enqueue the script in the footer.
	);

}

add_action( 'enqueue_block_editor_assets', 'daextauttol_editor_assets' );