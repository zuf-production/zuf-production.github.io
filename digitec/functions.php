<?php
/**
 * DigiTec functions and definitions
 *
 * Sets up the theme and includes scripts that use
 * actions and filters to create the site.
 *
 * @package WordPress
 * @subpackage DigiTec
 */

// Initialize the theme
require_once( dirname( __FILE__ ).'/theme/init.php' );

// Initialize the framework
require_once( dirname( __FILE__ ).'/maven/init.php' );

// Include files/scripts
if ( is_admin() ) {
	require_once( THEME_DIR.'/admin.php' );
}
require_once( dirname( __FILE__ ).'/includes/update.php' );
require_once( THEME_DIR.'/general.php' );
require_once( THEME_DIR.'/settings.php' );
require_once( THEME_DIR.'/shortcodes.php' );
require_once( THEME_DIR.'/posts.php' );
require_once( THEME_DIR.'/projects.php' );
require_once( THEME_DIR.'/team.php' );
require_once( THEME_DIR.'/search.php' );



/**
 * After theme setup
 *
 * @since 1.1.7
 */
function digitec_textdomain() {
$loaded = load_theme_textdomain( 'digitec', dirname( __FILE__ ).'/languages' );
}
add_action( 'after_setup_theme', 'digitec_textdomain' );
