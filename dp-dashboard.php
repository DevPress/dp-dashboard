<?php
/**
 * Plugin Name: DP Dashboard
 * Plugin URI: http://devpress.com/plugins/dp-dashboard/
 * Description: A plugin for customizing WordPress admin pages.
 * Version: 3.7
 * Author: Tung Do
 * Author URI: http://devpress.com
 * Text Domain: dp-dashboard
 *
 * @package   dp-dashboard
 * @version   3.7
 * @author    Tung Do <tung@devpress.com>
 * @copyright Copyright (c) 2013, Tung Do
 * @link      http://devpress.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Plugin settings link */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'dp_dashboard_plugin_action_links' );

/**
 * Add a "Settings" link to the plugin action links list.
 *
 */

function dp_dashboard_plugin_action_links( $links ) {

	return array_merge(
		array( 'settings' => '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/options-general.php?page=dp_dashboard_settings">' . __( 'Settings', 'dp-dashboard' ) .'</a>'), $links );

}

class DP_Dashboard {

	/**
	 * PHP5 constructor method.
	 *
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		/* Load the admin files. */
		add_action( 'plugins_loaded', array( &$this, 'admin' ), 3 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 4 );

	}

	/**
	 * Defines constants used by the plugin.
	 *
	 */
	public function constants() {

		/* Set constant URI */
		define( 'DP_DASHBOARD_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Set constant path to the plugin directory. */
		define( 'DP_DASHBOARD_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set the constant path to the admin directory. */
		define( 'DP_DASHBOARD_ADMIN', DP_DASHBOARD_DIR . trailingslashit( 'admin' ) );

		/* Set the constant path to the includes directory. */
		define( 'DP_DASHBOARD_INCLUDES', DP_DASHBOARD_DIR . trailingslashit( 'includes' ) );

		/* Set the constant path to the themes directory. */
		define( 'DP_DASHBOARD_THEMES', DP_DASHBOARD_DIR . trailingslashit( 'themes' ) );

		/* Set the constant path to the external themes directory. */
		define( 'DP_DASHBOARD_THEMES_EXTERNAL', WP_CONTENT_DIR . trailingslashit( '/dp-dashboard-themes' ) );
	}

	/**
	 * Loads the translation files.
	 *
	 */
	public function i18n() {

		/* Load the translation of the plugin. */
		if( is_admin() ) {
			load_plugin_textdomain( 'dp-dashboard', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}

	/**
	 * Loads the admin functions and files.
	 *
	 */
	public function admin() {

		/* Only load files if in the WordPress admin. */
		if ( is_admin() ) {
			require_once( DP_DASHBOARD_ADMIN . 'admin.php' );
		}
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 */
	public function includes() {

		require_once( DP_DASHBOARD_INCLUDES . 'defaults.php' );
		/* include theme functions.php file */
		include_once( DP_DASHBOARD_THEMES . 'osso/functions.php' );

	}

}

new DP_Dashboard();

?>