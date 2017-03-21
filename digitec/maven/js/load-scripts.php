<?php
/**
 * Controls the adding of scripts to the front-end and admin.
 *
 * @category Maven
 * @package  Scripts-Styles
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 */




add_action( 'wp_enqueue_scripts', 'maven_load_scripts' );
/**
 * Enqueue the scripts used on the front-end of the site.
 *
 * @since 1.0
 */
function maven_load_scripts() {

	/** If a single post or page, threaded comments are enabled, and comments are open */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Load modernizr
	if( current_theme_supports('modernizr') ) {
	  wp_register_script( 'modernizr', MAVEN_JS_URL.'/modernizr-2.5.3.min.js', false, MAVEN_FRAMEWORK_VERSION );
	  wp_enqueue_script( 'modernizr' );
  }
  
  // Load jquery easing
  wp_register_script( 'jquery-easing', MAVEN_JS_URL.'/jquery.easing.js', array('jquery'), MAVEN_FRAMEWORK_VERSION, true );
  wp_enqueue_script( 'jquery-easing' );
  
  // Load bootstrap
  if( current_theme_supports('bootstrap-js') ) {
	  wp_register_script( 'bootstrap', MAVEN_BOOTSTRAP_URL.'/js/bootstrap.min.js', false, MAVEN_FRAMEWORK_VERSION, true );
	  wp_enqueue_script( 'bootstrap' );
  }
  
  // Load Twitter Platform
  wp_register_script( 'twitter', 'http://platform.twitter.com/widgets.js', false, MAVEN_FRAMEWORK_VERSION, true );
  wp_enqueue_script( 'twitter' );
}




add_action( 'admin_enqueue_scripts', 'maven_load_admin_scripts' );
/**
 * Conditionally enqueues the scripts used in the admin.
 *
 * @since 1.0
 */
function maven_load_admin_scripts( $hook_suffix ) {

	if( $hook_suffix == 'post.php' || $hook_suffix == 'post-new.php' ) {
		// Add styles script
		wp_register_script( 'maven-styles', MAVEN_JS_URL.'/styles.js', false, MAVEN_FRAMEWORK_VERSION );
		wp_enqueue_script( 'maven-styles' );
	}
}

