<?php
/**
 * This is where we put all the functions that that pertain
 * to the sidebars globally throughout the site.
 *
 * @category Maven
 * @package  Functions
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 **/
 
 
 
 
add_action( 'widgets_init', 'maven_sidebars_init' );
/**
 * Initializes and adds the sidebars
 *
 * @since 1.0
 */
function maven_sidebars_init() {
	
	if ( function_exists('register_sidebar') ) {
	
		$sidebars = get_maven_sidebars();
		if( $sidebars ) {
			foreach( $sidebars as $sidebar ) {
				register_sidebar( array(
					'name' => __( $sidebar, 'digitec' ),
					'id' => sanitize_title_with_dashes( $sidebar ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => '</aside>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				));
			}
		}
	}
}




/**
	* Get an array of the sidebars for select fields
	*/
function get_maven_sidebars( $add='' ) {
	
	$sidebars = array( 'Primary Widget Area' );
	if( current_theme_supports('footer-widgets') ) {
		array_push( $sidebars, 'Footer Widget Area 1', 'Footer Widget Area 2', 'Footer Widget Area 3', 'Footer Widget Area 4' );
	}

	$options = get_option( 'maven_sidebar_options' );
	$user_sidebars = isset( $options['sidebars'] ) ? $options['sidebars'] : false;
	if( $user_sidebars ) {
		$sidebars = array_merge( $sidebars, $user_sidebars );
	}
	
	if( $add != '' ) {
		if( is_array($add) ) {
			$sidebars = array_merge( $add, $sidebars );
		} else {
			array_unshift( $sidebars, $add );
		}		
	}
	
	return $sidebars;
}
