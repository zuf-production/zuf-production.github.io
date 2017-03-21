<?php
/**
 * Adds sidebar structures.
 *
 * @category   Maven
 * @package    Structure
 * @subpackage Sidebar
 * @author     MetaphorCreations
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://www.metaphorcreations.com/themes/maven
 */
 
 
 
 
add_action( 'maven_before_sidebar', 'maven_custom_widget_top' );
/**
 * Show a custom widget above the sidebar
 *
 * @since 1.0
 */
function maven_custom_widget_top() {

	$position = get_post_meta( get_the_ID(), '_maven_widget_position', true );
	$enabled = get_post_meta( get_the_ID(), '_maven_widget_enabled', true );
	
	if( $position == 'top' && $enabled ) {
	
		$title = get_post_meta( get_the_ID(), '_maven_widget_title', true );
		$content = get_post_meta( get_the_ID(), '_maven_widget_content', true );
		
		echo '<aside class="widget maven_custom_widget">';
		if( $title != '' ) {
			echo '<h3 class="widget-title">'.$title.'</h3>';
		}
		echo wpautop( $content );
		echo '</aside>';
	}
}




add_action( 'maven_sidebar', 'maven_do_sidebar' );
/**
 * Get and show the appropiate widget area.
 *
 * @since 1.0
 */
function maven_do_sidebar() {

	global $post, $style_id;

	// Get the set sidebar
	$sidebar = get_post_meta( $post->ID, '_maven_page_sidebar', true );

	if( $sidebar == '* Use Style Setting' ) {
		$sidebar = get_post_meta( $style_id, '_maven_page_sidebar', true );
	}
	if( is_search() ) {
		$sidebar = get_post_meta( $style_id, '_maven_page_sidebar', true );
	}
	if( $sidebar != '' && $sidebar != '* None' ) {
		dynamic_sidebar( $sidebar );
	}
}




add_action( 'maven_after_sidebar', 'maven_custom_widget_bottom' );
/**
 * Show a custom widget below the sidebar
 *
 * @since 1.0
 */
function maven_custom_widget_bottom() {

	$position = get_post_meta( get_the_ID(), '_maven_widget_position', true );
	$enabled = get_post_meta( get_the_ID(), '_maven_widget_enabled', true );
	
	if( $position == 'bottom' && $enabled ) {
	
		$title = get_post_meta( get_the_ID(), '_maven_widget_title', true );
		$content = get_post_meta( get_the_ID(), '_maven_widget_content', true );
		
		echo '<aside class="widget maven_custom_widget">';
		if( $title != '' ) {
			echo '<h3 class="widget-title">'.$title.'</h3>';
		}
		echo wpautop( $content );
		echo '</aside>';
	}
}
