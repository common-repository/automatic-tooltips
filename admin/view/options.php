<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient capabilities to access this page.', 'automatic-tooltips' ) );
}

//Sanitization -------------------------------------------------------------------------------------------------
$data['settings_updated'] = isset( $_GET['settings-updated'] ) ? sanitize_key( $_GET['settings-updated'], 10 ) : null;
$data['active_tab']       = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'style_options';

?>

<div class="wrap">

    <h2><?php esc_html_e( 'Automatic Tooltips - Options', 'automatic-tooltips' ); ?></h2>

	<?php

	//settings errors
	if ( ! is_null( $data['settings_updated'] ) and $data['settings_updated'] == 'true' ) {

		if ( $this->write_custom_css() === false ) {
			?>
            <div id="setting-error-settings_updated" class="error settings-error notice is-dismissible below-h2">
                <p>
                    <strong><?php esc_html_e( "The plugin can't write files in the upload directory.", 'automatic-tooltips' ); ?></strong>
                </p>
                <button type="button" class="notice-dismiss"><span
                            class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'automatic-tooltips' ); ?></span>
                </button>
            </div>
			<?php
		}

		//Settings errors
		settings_errors();

	}

	?>

    <div id="daext-options-wrapper">

        <div class="nav-tab-wrapper">
            <a href="?page=daextauttol-options&tab=style_options"
               class="nav-tab <?php echo $data['active_tab'] == 'style_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Style', 'automatic-tooltips' ); ?></a>
            <a href="?page=daextauttol-options&tab=defaults_options"
               class="nav-tab <?php echo $data['active_tab'] == 'defaults_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Defaults', 'automatic-tooltips' ); ?></a>
            <a href="?page=daextauttol-options&tab=analysis_options"
               class="nav-tab <?php echo $data['active_tab'] == 'analysis_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Analysis', 'automatic-tooltips' ); ?></a>
            <a href="?page=daextauttol-options&tab=advanced_options"
               class="nav-tab <?php echo $data['active_tab'] == 'advanced_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Advanced', 'automatic-tooltips' ); ?></a>
        </div>

        <form method="post" action="options.php" autocomplete="off">

			<?php

			if ( $data['active_tab'] == 'style_options' ) {

				settings_fields( $this->shared->get( 'slug' ) . '_style_options' );
				do_settings_sections( $this->shared->get( 'slug' ) . '_style_options' );

			}

			if ( $data['active_tab'] == 'defaults_options' ) {

				settings_fields( $this->shared->get( 'slug' ) . '_defaults_options' );
				do_settings_sections( $this->shared->get( 'slug' ) . '_defaults_options' );

			}

			if ( $data['active_tab'] == 'analysis_options' ) {

				settings_fields( $this->shared->get( 'slug' ) . '_analysis_options' );
				do_settings_sections( $this->shared->get( 'slug' ) . '_analysis_options' );

			}

			if ( $data['active_tab'] == 'advanced_options' ) {

				settings_fields( $this->shared->get( 'slug' ) . '_advanced_options' );
				do_settings_sections( $this->shared->get( 'slug' ) . '_advanced_options' );

			}

			?>

            <div class="daext-options-action">
                <input type="submit" name="submit" id="submit" class="button"
                       value="<?php esc_attr_e( 'Save Changes', 'automatic-tooltips' ); ?>">
            </div>

        </form>

    </div>

</div>