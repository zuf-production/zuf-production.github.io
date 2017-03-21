<?php
/**
 * This is where we put all the functions that that pertain
 * to menus globally throughout the site.
 *
 * @category Maven
 * @package  Functions
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 **/
 
 
 
 
/**
 * Add a main menu fallback
 *
 * @since 1.0
 */
function main_menu_fallback() {
	wp_page_menu( 'menu_class=main-menu-container' );
}
 
 
 
 
add_filter( 'wp_nav_menu', 'maven_add_last_menu_class' );	
/**
 * Add a 'last-menu-item' to nav manus
 *
 * @since 1.0
 */
function maven_add_last_menu_class( $strHTML ) {

	$intPos = strripos( $strHTML, 'menu-item' );	
	printf( "%slast-menu-item %s", substr( $strHTML, 0, $intPos ), substr( $strHTML, $intPos, strlen( $strHTML ) ) );
}




add_filter( 'wp_page_menu', 'maven_add_last_page_class' );
/**
 * Add a 'last-page-item' to page menus
 *
 * @since 1.0
 */
function maven_add_last_page_class( $strHTML ) {
	
	$intPos = strripos( $strHTML, 'page-item' );	
	printf( "%slast-page-item %s", substr( $strHTML, 0, $intPos ), substr( $strHTML, $intPos, strlen( $strHTML ) ) );
}