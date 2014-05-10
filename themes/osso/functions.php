<?php

/**
 * General
 ************************************************/
	
	/* Add and/or remove menu items */	
	add_action( 'wp_before_admin_bar_render', 'osso_admin_bar', 0 );

	/* Filter admin bar My Account */
	add_action( 'admin_bar_menu', 'osso_admin_bar_my_account' );

	/* Modify adminmenu */
	add_action( 'admin_menu', 'osso_admin_menu' );

	/* Remove footer text */
	add_filter( 'admin_footer_text', 'osso_admin_footer' );

	/* Remove footer version */
	add_filter( 'update_footer', 'osso_admin_footer', 11);
	
	/* Register and enqueue custom CSS */
	add_action( 'admin_enqueue_scripts', 'osso_resources' );
	add_action( 'wp_enqueue_scripts', 'osso_resources' );
	
	/* Switch stylesheets on login page */
	add_filter( 'style_loader_src', 'osso_switch_stylesheet_src', 10, 2 );
	
	/* Add body class */
	add_filter( 'admin_body_class', 'osso_admin_body_class' );
	
	/* Editor CSS */
	add_filter( 'mce_css', 'osso_editor_css' );
	
	/* Remove default bump */
	add_action( 'get_header', 'osso_remove_default_bump' );

	/* Replace default bump with custom bump */
	add_action( 'wp_head', 'osso_custom_bump', 11 );
	
	/* Modify logo url */
	add_filter( 'login_headerurl', 'osso_login_header_url' );

	/* Modify logo link title */
	add_filter( 'login_headertitle', 'osso_login_header_title' );
	
	/* Load custom CSS at admin_footer so users can override header and mid page css */
	add_action( 'admin_footer', 'osso_custom_css' );

	/* Load custom css on login page */
	add_action( 'login_footer', 'osso_custom_css' );
	

/**
 * Login Page
 ************************************************/

	
/**
 * Add and remove items from admin toolbar.
 *
 * @since 0.1
 */	
function osso_admin_bar() {
	global $wp_admin_bar;

	/* Remove their stuff */
	$wp_admin_bar->remove_menu('wp-logo');
	//$wp_admin_bar->remove_node('updates');
	//$wp_admin_bar->remove_node('comments');
}

/**
 * Customize my account menu item tab in admin bar.
 *
 * @since 0.2
 */

function osso_admin_bar_my_account( $wp_admin_bar ) {
	$user_id      = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url  = get_edit_profile_url( $user_id );

	if ( ! $user_id )
		return;

	$avatar = get_avatar( $user_id, 40 );
	$link_title  = sprintf( __( 'Account', 'dp-dashboard' ) );
	$class  = empty( $avatar ) ? '' : 'with-avatar';

	$wp_admin_bar->add_menu( array(
		'id'        => 'my-account',
		'parent'    => 'top-secondary',
		'title'     => $link_title . $avatar,
		'href'      => $profile_url,
		'meta'      => array(
			'class'     => $class,
			'title'     => __( 'My Account', 'dp-dashboard' ),
		),
	) );
}

/**
 * Modify admin menu.
 *
 * @since 0.1
 */	
function osso_admin_menu() {  
	remove_menu_page( 'separator1' );
	remove_menu_page( 'separator2' );
	remove_menu_page( 'separator-last' );
}

/**
 * Return nothing for footer text and footer version.
 *
 * @since 0.1
 */	
function osso_admin_footer() {
	return '';
}

/**
 * Register/Enqueue CSS and Scripts
 *
 * @since 0.1
 */	
function osso_resources() {

	global $wp_styles;

	/**
	 * Create URI path to css folder
	 */
	$style_uri = DP_DASHBOARD_URI . 'themes/osso/';

	/**
	 * Stylesheet version
	 */
	$style_ver = 'osso.3.7';

	/**
	 * Suffix for minify version
	 */
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	
	$rtl_styles = array(
		'admin-bar',
		'customize-controls',
		'ie',
		'media',
		'media-views',
		'wp-color-picker',
		'wp-admin'
		);

	/**
	 * Register custom stylesheets to replace wordpress styles
	 * with the same handler so wordpress can recognize it.
	 * Just add it back one by one.
	 */

	if ( is_admin() ){ // in admin pages, excluding farbtastic, imgareaselect, and jCrop
	
		/* main stylesheet */
		wp_deregister_style( 'wp-admin' );
		wp_register_style( 'wp-admin', $style_uri . 'wp-admin' . $suffix . '.css', array(), $style_ver, 'all' );

		/* colors stylesheet */
		wp_deregister_style( 'colors' );
		//wp_register_style( 'colors', $style_uri . 'color-fresh' . $suffix . '.css', array('wp-admin', 'buttons'), $style_ver, 'all' );

		/* old media uploader */
		wp_deregister_style( 'media' );
		wp_register_style( 'media', $style_uri . 'media' . $suffix . '.css', array('wp-admin', 'buttons'), $style_ver, 'all' );

		/* thickbox */
		wp_deregister_style( 'thickbox' );
		wp_register_style( 'thickbox', $style_uri . 'thickbox.css', array(), $style_ver, 'all' );

		/* color picker */
		wp_deregister_style( 'wp-color-picker' );
		wp_register_style( 'wp-color-picker', $style_uri . 'color-picker' . $suffix . '.css', array(), $style_ver, 'all' );

		/* admin bar */
		wp_deregister_style( 'admin-bar' );
		wp_register_style( 'admin-bar', $style_uri . 'admin-bar' . $suffix . '.css', array(), $style_ver, 'all' );

		/* jquery ui dialog */
		wp_deregister_style( 'wp-jquery-ui-dialog' );
		wp_register_style( 'wp-jquery-ui-dialog', $style_uri . 'jquery-ui-dialog' . $suffix . '.css', array(), $style_ver, 'all' );

		/* editor */
		wp_deregister_style( 'editor-buttons' );
		wp_register_style( 'editor-buttons', $style_uri . 'editor.css', array(), $style_ver, 'all' );

		/* wp pointers */
		wp_deregister_style( 'wp-pointer' );
		wp_register_style( 'wp-pointer', $style_uri . 'wp-pointer' . $suffix . '.css', array(), $style_ver, 'all' );

		/* new media uploader */
		wp_deregister_style( 'media-views' );
		wp_register_style( 'media-views', $style_uri . 'media-views' . $suffix . '.css', array(), $style_ver, 'all' );

		/* buttons */
		wp_deregister_style( 'buttons' );
		wp_register_style( 'buttons', $style_uri . 'buttons' . $suffix . '.css', array(), $style_ver, 'all' );

		/* remove internet explorer workarounds and hacks */
		wp_deregister_style( 'ie' );

	}
	else { // if not viewing WordPress admin pages
	
		wp_deregister_style( 'admin-bar' );
		wp_register_style( 'admin-bar', $style_uri . 'admin-bar' . $suffix . '.css', array(), $style_ver, 'all' );
	
	}
	
	/* === RTL support === */
	foreach ( $rtl_styles as $rtl_style ) {

		$wp_styles->add_data( $rtl_style, 'rtl', true );

		if ( $suffix ) {
			$wp_styles->add_data( $rtl_style, 'suffix', $suffix );	
		} // end if $suffix

	}// end foreach
	
	/**
	 * Enqueue CSS and Scripts for admin pages
	 */
	 
	if ( is_admin() ) {
	
		$screen = get_current_screen();
		
		if ( $screen->id == 'nav-menus' || $screen->id == 'widgets' ) {
			wp_enqueue_script( 'jquery-ui-tabs' );
		}

		wp_enqueue_style( 'wp-admin' );
		wp_enqueue_style( 'buttons' );

		wp_enqueue_script( 'dp-dashboard-osso-scripts', plugins_url( '/dp-dashboard/themes/osso/js/osso.js' ), array( 'jquery' ), false, true );
		
		/* osso script: localize */
		wp_localize_script( 'dp-dashboard-osso-scripts', 'osso_scripts', array(
				'back_to_top' => __('Back to Top', 'dp-dashboard' ),
				'configure' => __( 'Configure', 'dp-dashboard' ),
				'from' => __( 'From', 'dp-dashboard' ),
				'main_menu' => __( 'Main Menu', 'dp-dashboard' )
			)
		);
		
	} // end if is_admin

}

/**
 * Stylesheets switcher to work around wp_admin_css in wp-login.php template.
 * 
 * @since 0.1.0
 */

function osso_switch_stylesheet_src( $src, $handle ) {

	global $pagenow;

	/**
	 * Create URI path to css folder
	 */
	$style_uri = DP_DASHBOARD_URI . 'themes/osso/';

	/**
	 * Suffix for minify version
	 */
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	
	if( 'wp-login.php' == $pagenow ) {
	
		if( 'wp-admin' == $handle ||
			'buttons' == $handle ||
			'colors-fresh' == $handle ) {

			$src = $style_uri . $handle . $suffix . '.css';
			
		} // end stylesheet handle conditional
		
	} elseif ( 'sites.php' == $pagenow ) {
	
		if( 'install' == $handle ) {

			$src = $style_uri . $handle . $suffix . '.css';
			
		}
	
	}

    return $src;
}

/**
 * Add body class
 * 
 */
function osso_admin_body_class( $classes ) {

	$screen = get_current_screen();
	
	if ( 'themes-network' == $screen->id ) {
		$classes .= 'themes-network';
	}

	return $classes;
}

/**
 * Add Editor Style
 * 
 * @since 0.1.0
 */
function osso_editor_css( $mce_css ) {
	
	/* If active theme doesn't support editor-style then load modified editor style from plugin, otherwise don't interfere */
	if( !current_theme_supports( 'editor-style' ) ) {

		$mce_css .= ', ' . plugins_url( '/dp-dashboard/themes/osso/css/editor-style.css' );

	}

    return $mce_css;
}

/**
 * Remove default user site's top margin adjustment.
 *
 * @since 0.1
 */
function osso_remove_default_bump() {

	remove_action( 'wp_head', '_admin_bar_bump_cb' );

}

/**
 * Adjust user site's top margin for admin bar display.
 *
 * @since 0.1
 */
function osso_custom_bump() {

	/* If admin bar is showing */
	if ( is_admin_bar_showing() ) : ?>

		<style type="text/css" media="screen">
			/* DP Dashboard admin bar margin adjustment */
			html { margin-top: 48px !important; }
			* html body { margin-top: 48px !important; }
		</style>

	<?php endif;
	
}

/**
 * Modify login header url
 *
 * @since 0.1
 */	
function osso_login_header_url( $login_header_url ) {

	if ( is_multisite() ) {
		$login_header_url = network_home_url();
	} else {
		$login_header_url = site_url();
	}
	
	return $login_header_url;
}

/**
 * Modify login header title.
 *
 * @since 0.1
 */	
function osso_login_header_title( $login_header_title ) {

	$login_header_title = __( 'Back to main page', 'dp-dashboard' );

	return $login_header_title;

}

/**
 * Add custom CSS
 * 
 * @since 0.1.0
 */
function osso_custom_css() {
	
	/* Check plugin settings */
	$options = wp_parse_args( get_option( 'dp_dashboard' ), dp_dashboard_default_settings() );
	
	/* if Custom CSS URL is not empty */
	if ( $options['custom_css_url'] ) {

		wp_register_style( 'dp-dashboard-custom', $options['custom_css_url'] );
		
		wp_enqueue_style( 'dp-dashboard-custom' );
	
	}

}

?>