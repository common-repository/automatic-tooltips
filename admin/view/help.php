<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'automatic-tooltips' ) );
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_html_e( 'Automatic Tooltips - Help', 'automatic-tooltips' ); ?></h2>

    <div id="daext-menu-wrapper">

        <p><?php esc_html_e( 'Visit the resources below to find your answers or to ask questions directly to the plugin developers.', 'automatic-tooltips' ); ?></p>
        <ul>
            <li><a href="https://daext.com/support/"><?php esc_html_e( 'Support Conditions', 'automatic-tooltips' ); ?>
            </li>
            <li><a href="https://daext.com"><?php esc_html_e( 'Developer Website', 'automatic-tooltips' ); ?></a></li>
            <li>
                <a href="https://wordpress.org/plugins/automatic-tooltips/"><?php esc_html_e( 'WordPress.org Plugin Page', 'automatic-tooltips' ); ?></a>
            </li>
            <li>
                <a href="https://wordpress.org/support/plugin/automatic-tooltips/"><?php esc_html_e( 'WordPress.org Support Forum', 'automatic-tooltips' ); ?></a>
            </li>
        </ul>
        <p>

    </div>

</div>

