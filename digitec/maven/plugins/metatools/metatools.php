<?php
/*
Plugin Name: MetaTools
Description: Add ******************************
Version: 1.0
Author: Metaphor Creations
Author URI: http://www.metaphorcreations.com
License: GPL2
*/

/*  
Copyright 2012 Metaphor Creations  (email : joe@metaphorcreations.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/




if( ! function_exists('metatools_admin_scripts') ) {
	
	
	/** Define Constants */
	define ( 'METATOOLS_VERSION', '1.0' );
	
	define ( 'METATOOLS_DIR', MAVEN_PLUGINS_DIR.'/metatools/' );
	define ( 'METATOOLS_IMAGES_DIR', METATOOLS_DIR.'images' );
	define ( 'METATOOLS_JS_DIR', METATOOLS_DIR.'js' );
	define ( 'METATOOLS_CSS_DIR', METATOOLS_DIR.'css' );
	define ( 'METATOOLS_LIBS_DIR', METATOOLS_DIR.'libs' );
	define ( 'METATOOLS_MEDIAELEMENT_DIR', METATOOLS_LIBS_DIR.'/mediaelement' );
	define ( 'METATOOLS_TIMTHUMB_DIR', METATOOLS_LIBS_DIR.'/timthumb' );
	
	define ( 'METATOOLS_URL', MAVEN_PLUGINS_URL.'/metatools' );
	define ( 'METATOOLS_IMAGES_URL', METATOOLS_URL.'/images' );
	define ( 'METATOOLS_JS_URL', METATOOLS_URL.'/js' );
	define ( 'METATOOLS_CSS_URL', METATOOLS_URL.'/css' );
	define ( 'METATOOLS_LIBS_URL', METATOOLS_URL.'/libs' );
	define ( 'METATOOLS_MEDIAELEMENT_URL', METATOOLS_LIBS_URL.'/mediaelement' );
	define ( 'METATOOLS_TIMTHUMB_URL', METATOOLS_LIBS_URL.'/timthumb' );
	
	
	
	
	add_action( 'admin_enqueue_scripts', 'metatools_admin_scripts' );
	/**
	 * Conditionally enqueues the scripts used in the admin.
	 *
	 * @since 1.0
	 */
	function metatools_admin_scripts( $hook_suffix ) {
	
		// Add MediaElement Player JS
		wp_register_script( 'mediaelement-and-player', METATOOLS_MEDIAELEMENT_URL.'/mediaelement-and-player.min.js', array( 'jquery' ), METATOOLS_VERSION, true );
		wp_enqueue_script( 'mediaelement-and-player' );
		
		// Add MediaElement Player CSS
		wp_register_style( 'mediaelementplayer', METATOOLS_MEDIAELEMENT_URL.'/mediaelementplayer.min.css', false, METATOOLS_VERSION );
		wp_enqueue_style( 'mediaelementplayer' );
	
		// Add the metatools admin script
		wp_register_script( 'metatools-admin', METATOOLS_JS_URL.'/metatools-admin.js', array( 'jquery' ), METATOOLS_VERSION );
		wp_enqueue_script( 'metatools-admin' );
		
		// Add the metatools styles
		wp_register_style( 'metatools', METATOOLS_CSS_URL.'/metatools.css', false, METATOOLS_VERSION );
		wp_enqueue_style( 'metatools' );
	}
	
	
	
	/** Load Files */
	if ( is_admin() ) {
		require_once( METATOOLS_DIR.'metatools-media-admin.php' );
		require_once( METATOOLS_DIR.'metatools-options.php' );
	}
	
	require_once( METATOOLS_DIR.'metatools-general.php' );
	require_once( METATOOLS_DIR.'metatools-media.php' );
}