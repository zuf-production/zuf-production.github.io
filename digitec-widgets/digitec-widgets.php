<?php
/*
Plugin Name: Digitec Widgets
Description: Custom widgets that come included with the Digitec theme.
Version: 1.3
Author: Digital Science
Author URI: http://www.digitalscience.za.org/
License: ThemeForest Licensing Terms
License URI:	http://themeforest.net/wiki/support/legal-terms/licensing-terms/
*/


/**Define Widget Constants */
if ( WP_DEBUG ) {
	define ( 'DIGITEC_WIDGETS_VERSION', '1.3-'.time() );
} else {
	define ( 'DIGITEC_WIDGETS_VERSION', '1.3' );
}
define ( 'DIGITEC_WIDGETS_DIR', plugin_dir_path(__FILE__) );
define ( 'DIGITEC_WIDGETS_URL', plugins_url().'/digitec-widgets' );

/* Register scripts - @since 1.0 */
add_action( 'wp_enqueue_scripts', 'digitec_widgets_load_scripts' );

/**
 * Register scripts
 *
 * @since 1.0
 */
function digitec_widgets_load_scripts(){

	// Load the global widgets stylesheet
	wp_register_style( 'digitec-widget-styles', DIGITEC_WIDGETS_URL.'/digitec-widgets-style.css', false, DIGITEC_WIDGETS_VERSION );
  wp_enqueue_style( 'digitec-widget-styles' );
}

/**
 * Convert hyperlink text
 *
 * @since 1.0
 */
function digitec_convert_hyperlink( $string ) {

	$string = preg_replace( '/(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i',  '<a href="\\1">\\1</a>', $string );
	$string = preg_replace( '/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2">\\2</a>', $string ); 
	return $string;
}

/**
 * Convert twitter links
 *
 * @since 1.0
 */
function digitec_convert_twitter_links( $string ) {

	$string = digitec_convert_hyperlink( $string );
	$string = preg_replace("/[@]+([A-Za-z0-9-_]+)/", "<a href=\"http://twitter.com/\\1\" target=\"_blank\">\\0</a>", $string ); 
	$string = preg_replace("/[#]+([A-Za-z0-9-_]+)/", "<a href=\"http://twitter.com/search?q=%23\\1\" target=\"_blank\">\\0</a>", $string );

  return $string;
}

/** Load Functions */
require_once( DIGITEC_WIDGETS_DIR.'digitec-posts.php' );
require_once( DIGITEC_WIDGETS_DIR.'digitec-twitter.php' );
require_once( DIGITEC_WIDGETS_DIR.'digitec-social.php' );
require_once( DIGITEC_WIDGETS_DIR.'digitec-contact.php' );




/************************************
* Software Update Code
*************************************/
define ( 'DIGITEC_WIDGETS_SL_STORE_URL', 'http://metaphorcreations.com' );
define ( 'DIGITEC_WIDGETS_SL_ITEM_NAME', 'Digitec Widgets' );
define ( 'DIGITEC_WIDGETS_SL_LICENSE_KEY', '0422de0580f2581b3de13a00f4781476' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater( DIGITEC_WIDGETS_SL_STORE_URL, __FILE__, array( 
		'version' 	=> '1.3', 				// current version number
		'license' 	=> DIGITEC_WIDGETS_SL_LICENSE_KEY, 		// license key (used get_option above to retrieve from DB)
		'item_name' => DIGITEC_WIDGETS_SL_ITEM_NAME, 	// name of this plugin
		'author' 	=> 'Metaphor Creations'  // author of this plugin
	)
);

// activate the license
function digitec_widgets_activate_license() {
	
	if( !get_option('digitec_widgets_license_key') ) {

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> DIGITEC_WIDGETS_SL_LICENSE_KEY, 
			'item_name' => urlencode( DIGITEC_WIDGETS_SL_ITEM_NAME ) // the name of our product in EDD
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, DIGITEC_WIDGETS_SL_STORE_URL ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;
			
		// Set the license option
		add_option( 'digitec_widgets_license_key', DIGITEC_WIDGETS_SL_LICENSE_KEY );

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"
		if( get_option('digitec_widgets_license_status') ) {
			update_option( 'digitec_widgets_license_status', $license_data->license );
		} else {
			add_option( 'digitec_widgets_license_status', $license_data->license );	
		}
	}
}
add_action('admin_init', 'digitec_widgets_activate_license');
