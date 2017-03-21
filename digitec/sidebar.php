<?php
/**
 * The template for displaying the main widget area
 *
 * @package WordPress
 * @subpackage Digitec
 */




global $style_id;
$layout = get_post_meta( $style_id, '_maven_page_layout', true );

if( $layout ) {

	if( $layout != 'full-width' ) {
	
		echo '<div id="secondary" class="widget-area" role="complementary">';
		
		do_action( 'maven_before_sidebar' );
		do_action( 'maven_sidebar' );
		do_action( 'maven_after_sidebar' );
	
		echo '</div>';
	}
}