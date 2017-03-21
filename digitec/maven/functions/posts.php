<?php
/**
 * This is where we put all the functions that that pertain
 * to posts globally throughout the site.
 *
 * @category Maven
 * @package  Functions
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 **/




/**
 * Print a post id.
 *
 * @since 1.0
 */
function maven_post_id() {
	echo get_maven_post_id();
}




/**
 * Return a post id.
 *
 * @since 1.0
 */
function get_maven_post_id() {
	
	$post_id = get_the_ID();
	
	if( $post_id==0 ) {
		if ( isset($_GET['post']) ) {
			$post_id = $_GET['post'];
		}
		if ( isset($_GET['post_ID']) ) {
			$post_id = $_GET['post_ID'];
		}
	}
	return $post_id;
}




/**
 * Add to the number of views for a post
 *
 * @since 1.0
 */
function add_maven_post_views( $post_id='' ) {

	// Get the post id
	$id = ( $post_id == '' ) ? get_maven_post_id() : $post_id;
	
	// Add to the view count
	if( get_post_meta($post_id, $key, $single) ) {
		$views = get_maven_post_views( $id ) + 1;
		update_post_meta( $id, 'maven_post_views', $views );
	} else {
		add_post_meta( $id, 'maven_post_views', 1 );
	}
}




/**
 * Print the number of views for a post
 *
 * @since 1.0
 */
function maven_post_views( $post_id='' ) {
	echo get_maven_post_views( $post_id );
}




/**
 * Return the number of views for a post
 *
 * @since 1.0
 */
function get_maven_post_views( $post_id='' ) {

	// Get the post id
	$id = ( $post_id == '' ) ? get_maven_post_id() : $post_id;
	
	// Return the number of views
	return intval( get_post_meta($id, 'maven_post_views', true) );
}




/**
 * Print a post class including a potential last class
 *
 * @since 1.0
 */
function maven_post_class( $classes='', $post_id=false, $last=false ) {

	global $wp_query;

	// Get the count
	$count = ( $wp_query->current_post )+1;

	// Get the number of the last post
	$total = ( $last ) ? $last : $wp_query->post_count;
	
	// Get classes
	$class = $classes;
	
	// Add last to the last post
	if( $count%$total==0 ) {
		$class .= ' last';
	}
	
	$class = apply_filters( 'maven_post_class', $class );
	
	// Print the classes	
	post_class( $class, $post_id );
}



/**
 * Print a post class including a potential last class
 *
 * @since 1.0
 */
function get_maven_post_class( $classes='', $post_id=false ) {

	$classes = apply_filters( 'maven_post_class', $classes );
	
	// Print the classes	
	$classes = get_post_class( $classes, $post_id );
	
	$html = 'class="';
	foreach( $classes as $class ) {
		$html .= $class.' ';
	}
	$html .= '"';
	
	return $html;
}