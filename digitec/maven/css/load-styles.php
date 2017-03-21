<?php
/**
 * Controls the adding of style sheets.
 *
 * @category Maven
 * @package  Scripts-Styles
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 */




add_action( 'wp_enqueue_scripts', 'maven_load_styles' );
/**
 * Add styles to the front end.
 *
 * @since 1.0
 */
function maven_load_styles() {
	
	// Load bootstrap
  wp_register_style( 'bootstrap', MAVEN_BOOTSTRAP_URL.'/css/bootstrap.css', false, MAVEN_FRAMEWORK_VERSION );
  wp_enqueue_style( 'bootstrap' );
  
  // Load the Maven styles
  wp_register_style( 'digitec', MAVEN_CSS_URL.'/style.css', false, MAVEN_FRAMEWORK_VERSION );
  wp_enqueue_style( 'digitec' );
  
  // Load the theme styles last
  wp_register_style( 'theme', PARENT_URL.'/style.css', false, MAVEN_FRAMEWORK_VERSION );
  wp_enqueue_style( 'theme' ); 
}




add_action( 'admin_print_styles', 'maven_styles_css' );
/**
 * Add admin styles.
 *
 * @since 1.0
 */
function maven_styles_css() {
	// Load the styles css
  wp_register_style( 'maven-styles', MAVEN_CSS_URL.'/styles.css', false, MAVEN_FRAMEWORK_VERSION );
  wp_enqueue_style( 'maven-styles' ); 
}