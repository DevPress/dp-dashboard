<?php

/* Filter admin color option */
add_filter( 'get_user_option_admin_color', 'dp_dashboard_admin_color_scheme' );

/* Add a note about admin color schemes. */
add_action( 'admin_color_scheme_picker', 'dp_dashboard_admin_color_scheme_notice' );

/**
 * Regardless of user preference, set admin color scheme to "fresh".
 *
 * @since 0.1
 */
function dp_dashboard_admin_color_scheme( $result ) {
    return 'fresh';
}

/*
 * Add a note about admin color schemes.
 *
 * @since 0.1
 */
function dp_dashboard_admin_color_scheme_notice( ) {
    echo '<p class="description"><strong>' . __( 'The admin color scheme option has been locked. You cannot change this option.','dp-dashboard') . '</strong></p>';
}

/**
 * Set default settings.
 *
 * @since 0.1.0
 */
function dp_dashboard_default_settings() {

	$defaults = array(
		'custom_css_url' => '',
	);
	
	return $defaults;
	
}

?>