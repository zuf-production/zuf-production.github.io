<?php
/**
 * Maven framework setup
 *
 * Sets up the framework and includes scripts that
 * contain function and use actions and filters to create the site.
 *
 * @package WordPress
 * @subpackage Maven
 */




// Activates default framework features - @since 1.0
add_action( 'maven_init', 'maven_theme_support', 5 );

// Define framework constants - @since 1.0
add_action( 'maven_init', 'maven_constants' );

// Load the framework files and features - @since 1.0
add_action( 'maven_init', 'maven_load_framework' );




/**
 * Activates default framework features
 *
 * @since 1.0
 */
function maven_theme_support() {

	add_theme_support( 'editor-style' );
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'layout-styles' );
	add_theme_support( 'branding-styles' );
	add_theme_support( 'background-styles' );
	add_theme_support( 'additional-styles' );
	add_theme_support( 'theme-options' );
	add_theme_support( 'general-theme-options' );
	add_theme_support( 'style-theme-options' );
	add_theme_support( 'sidebar-theme-options' );
	add_theme_support( 'social-theme-options' );
	add_theme_support( 'modernizr' );
}

/**
 * Define framework constants
 *
 * @since 1.0
 */
function maven_constants() {

	if ( WP_DEBUG ) {
		define ( 'MAVEN_FRAMEWORK_VERSION', '1.1.1-'.time() );
	} else {
		define ( 'MAVEN_FRAMEWORK_VERSION', '1.1.1' );
	}
	define ( 'MAVEN_SHORTNAME', '_maven_' );

	// Directory constants
	define( 'PARENT_DIR', get_template_directory() );
	define( 'THEME_DIR', PARENT_DIR.'/theme' );
	define( 'CHILD_DIR', get_stylesheet_directory() );
	define( 'MAVEN_IMAGES_DIR', PARENT_DIR.'/images' );
	define( 'MAVEN_DIR', PARENT_DIR.'/maven' );
	define( 'MAVEN_ADMIN_DIR', MAVEN_DIR.'/admin' );
	define( 'MAVEN_ADMIN_IMAGES_DIR', MAVEN_DIR.'/admin/images' );
	define( 'MAVEN_JS_DIR', MAVEN_DIR.'/js' );
	define( 'MAVEN_CSS_DIR', MAVEN_DIR.'/css' );
	define( 'MAVEN_FUNCTIONS_DIR', MAVEN_DIR.'/functions' );
	define( 'MAVEN_SHORTCODES_DIR', MAVEN_DIR.'/shortcodes' );
	define( 'MAVEN_STRUCTURE_DIR', MAVEN_DIR.'/structure' );
	define( 'MAVEN_LANGUAGES_DIR', MAVEN_DIR.'/languages' );
	define( 'MAVEN_PLUGINS_DIR', MAVEN_DIR.'/plugins' );
	define( 'MAVEN_LIBRARIES_DIR', MAVEN_DIR.'/libraries' );
	define( 'MAVEN_BOOTSTRAP_DIR', MAVEN_LIBRARIES_DIR.'/bootstrap' );
	define( 'MAVEN_TIMTHUMB_DIR', MAVEN_LIBRARIES_DIR.'/timthumb' );

	// URL constants
	define( 'PARENT_URL', get_template_directory_uri() );
	define( 'THEME_URL', PARENT_URL.'/theme' );
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	define( 'MAVEN_IMAGES_URL', PARENT_URL.'/images' );
	define( 'MAVEN_URL', PARENT_URL.'/maven' );
	define( 'MAVEN_ADMIN_URL', MAVEN_URL.'/admin' );
	define( 'MAVEN_ADMIN_IMAGES_URL', MAVEN_URL.'/admin/images' );
	define( 'MAVEN_JS_URL', MAVEN_URL.'/js' );
	define( 'MAVEN_CSS_URL', MAVEN_URL.'/css' );
	define( 'MAVEN_FUNCTIONS_URL', MAVEN_URL.'/functions' );
	define( 'MAVEN_SHORTCODES_URL', MAVEN_URL.'/shortcodes' );
	define( 'MAVEN_STRUCTURE_URL', MAVEN_URL.'/structure' );
	define( 'MAVEN_LANGUAGES_URL', MAVEN_URL.'/languages' );
	define( 'MAVEN_PLUGINS_URL', MAVEN_URL.'/plugins' );
	define( 'MAVEN_LIBRARIES_URL', MAVEN_URL.'/libraries' );
	define( 'MAVEN_BOOTSTRAP_URL', MAVEN_LIBRARIES_URL.'/bootstrap' );
	define( 'MAVEN_TIMTHUMB_URL', MAVEN_LIBRARIES_URL.'/timthumb/timthumb.php' );
}

/**
 * Load the framework files and features
 *
 * @since 1.0
 */
function maven_load_framework() {

	// Load plugins
	if( !function_exists('m4c_duplicate_post') ) {
		require_once( MAVEN_PLUGINS_DIR.'/post-duplicator/m4c-postduplicator.php' );
	}
	require_once( MAVEN_PLUGINS_DIR.'/metatools/metatools.php' );

	// Load the main loop structures
	require_once( MAVEN_DIR.'/maven.php' );

	// Load functions
	require_once( MAVEN_FUNCTIONS_DIR.'/general.php' );
	require_once( MAVEN_FUNCTIONS_DIR.'/menus.php' );
	require_once( MAVEN_FUNCTIONS_DIR.'/posts.php' );
	require_once( MAVEN_FUNCTIONS_DIR.'/posttypes.php' );
	require_once( MAVEN_FUNCTIONS_DIR.'/sidebars.php' );
	require_once( MAVEN_FUNCTIONS_DIR.'/styles.php' );

	// Shortcodes
	require_once( MAVEN_SHORTCODES_DIR.'/general.php' );

	// Load structure
	require_once( MAVEN_STRUCTURE_DIR.'/header.php' );
	require_once( MAVEN_STRUCTURE_DIR.'/footer.php' );
	require_once( MAVEN_STRUCTURE_DIR.'/post.php' );
	require_once( MAVEN_STRUCTURE_DIR.'/comments.php' );
	require_once( MAVEN_STRUCTURE_DIR.'/sidebar.php' );

	// Load admin
	if ( is_admin() ) :

		// Load Metaboxer
		if( !function_exists('metaboxer_container') ) {
			require_once( MAVEN_DIR.'/metaboxer/metaboxer.php' );
			require_once( MAVEN_DIR.'/metaboxer/metaboxer-class.php' );
			add_action( 'admin_enqueue_scripts', 'maven_metaboxer_scripts' );
		}

		require_once( MAVEN_ADMIN_DIR.'/editor.php' );
		require_once( MAVEN_ADMIN_DIR.'/general.php' );
		if( current_theme_supports('project-postype') ) {
			require_once( MAVEN_ADMIN_DIR.'/projects.php' );
		}
		require_once( MAVEN_ADMIN_DIR.'/styles.php' );
		require_once( MAVEN_ADMIN_DIR.'/theme-settings.php' );
	endif;

	// Load Javascript
	require_once( MAVEN_JS_DIR.'/load-scripts.php' );

	/** Load CSS */
	require_once( MAVEN_CSS_DIR.'/load-styles.php' );
}




/**
 * Load the metaboxer scripts
 *
 * @since 1.3
 */
function maven_metaboxer_scripts() {

	// Load the style sheet
	wp_register_style( 'metaboxer', MAVEN_URL.'/metaboxer/metaboxer.css', array( 'colors', 'thickbox', 'farbtastic' ), MAVEN_FRAMEWORK_VERSION );
	wp_enqueue_style( 'metaboxer' );

	// Load the jQuery
	wp_register_script( 'metaboxer', MAVEN_URL.'/metaboxer/metaboxer.js', array('jquery','media-upload','thickbox','jquery-ui-core','jquery-ui-sortable','jquery-ui-datepicker', 'jquery-ui-slider', 'farbtastic'), MAVEN_FRAMEWORK_VERSION, true );
	wp_enqueue_script( 'metaboxer' );
}




do_action( 'maven_init' );
