<?php

add_action('admin_init', 'dp_dashboard_admin_setup' );
add_action('admin_menu', 'dp_dashboard_admin_page');

/**
 * @since 0.1.0
 */
function dp_dashboard_admin_setup() {

	/**
	 * Register settings for 'DP Dashboard' screen under 'Settings' page.
	 */
	register_setting(
		'dp_dashboard_settings',
		'dp_dashboard',
		'dp_dashboard_settings_validate'
	);

}

/**
 * @since 0.1.0
 */
function dp_dashboard_admin_page() {

	// Add DP Dashboard menu page under Settings
	add_options_page( __( 'DP Dashboard Settings', 'dp-dashboard'), __( 'DP Dashboard', 'dp-dashboard') , 'manage_options', 'dp_dashboard_settings', 'dp_dashboard_settings_display' );

}

/**
 * @since 0.1.0
 */
function dp_dashboard_settings_display() {

do_action( "dp_dashboard_before_settings_page" ); ?>

<div class="wrap dp-wrap dp-dashboard-wrap">

	<h2><?php _e( 'DP Dashboard Settings', 'dp-dashboard' ); ?></h2>

	<?php do_action( "dp_dashboard_open_settings_page" ); ?>

	<form method="post" action="options.php">

		<?php settings_fields('dp_dashboard_settings'); ?>
		
		<?php

			$options = wp_parse_args( get_option( 'dp_dashboard' ), dp_dashboard_default_settings() );
			
		?>
		
		<div class="clear"></div>

		<table class="form-table dp-dashboard-settings">
			
			<!-- Custom CSS -->
			<tr>
				<th style="width: 20%;"><label for="dp-dashboard-custom-css-url"><?php _e( 'Custom CSS URL:', 'dp-dashboard' ); ?></label></th>
				<td>
				
					<input class="full" id="dp-dashboard-custom-css-url" name="dp_dashboard[custom_css_url]" type="text" value="<?php echo esc_url_raw( $options['custom_css_url'] ); ?>" />
					
					<p class="description"><?php _e( 'Specify the location of your custom css file, e.g. <code>http://yoursite.com/custom.css</code>. It will be used on all admin pages and login page.', 'dp-dashboard' ); ?></p>
				</td>
			</tr>
			
			<?php do_action( "dp_dashboard_settings_page" ); ?>
		
		</table><!-- .form-table -->
		
		<input type="submit" class="button-primary" value="<?php _e( 'Update Settings', 'dp-dashboard' ) ?>" />

	</form>
	
	<?php do_action( "dp_dashboard_close_settings_page" ); ?>

</div><!-- .wrap -->

<?php do_action( "dp_dashboard_after_settings_page" ); }

/**
 * @since 0.1.0
 */
function dp_dashboard_settings_validate( $input ) {

	/* the rest */
	$input['custom_css_url'] = esc_url_raw( $input['custom_css_url'] );

	return $input;
}

?>