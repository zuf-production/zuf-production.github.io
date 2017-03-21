<?php
/**
 * This is where we put all the functions that that pertain
 * to the page styles post type globally throughout the site.
 *
 * @category Maven
 * @package  Functions
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 **/




add_action( 'wp_head', 'maven_set_style_post' );
/**
 * Find and set the style post
 *
 * @since 1.1.1
 */
function maven_set_style_post(){

	global $style_id;
 	
 	// Get the style for the page
	$id = get_post_meta( get_the_ID(), '_maven_style_select', true );
	if( $id == '' ) {
		$id = false;
	}
	
	// Get the default options
	$options = get_option( 'maven_style_options' );
	
	// Get the post type
	$post_type = get_post_type( get_the_ID() );
	if( is_search() ) {
		$post_type = 'search';
	}
	
	// If no style is set, but there are defaults set.
	if( !$id && isset($options[$post_type]) ) {
		$id = $options[$post_type];

	// If a style is set
	} elseif( $id && isset($options[$post_type]) ) {
		if( $id == '* Use Default' ) {
			$id = $options[$post_type];
		}
		
	// Else, get the first page style
	} elseif( !$id ) {
		$args = array(
	    'numberposts'     => 1,
	    'post_type'       => 'maven_styles'
    );
    $style_array = get_posts( $args );
		if( $style_array ) {
			$id = $style_array[0]->ID;
		}
	}
	
	// Set the style post
	if( $id ) {
		$style_id = $id;
	}
}




add_filter( 'body_class','maven_set_body_style_class' );
/**
 * Add a style class to the body.
 *
 * @since 1.0
 */
function maven_set_body_style_class( $classes ) {

	global $style_id;
	
	// If a page style is set add more body classes.
	if( $style_id ) {
		$classes[] = 'style-'.sanitize_title_with_dashes( get_the_title($style_id) );
		
		$layout = get_maven_layout();
		$classes[] = $layout;
		
		if( $layout != 'full-width' ) {
			$classes[] = 'sidebar';
		}
	}
	
	return $classes;
}
 
  
 
 
add_action( 'wp_head', 'maven_set_style_css' );
/**
 * Set the style post css.
 *
 * @since 1.0
 */
function maven_set_style_css() {
	
	global $style_id;

	if( $style_id ) {
		
		// Extract the custom fields
		$customs = get_post_custom( $style_id );
		$styles = array();
		foreach( $customs as $key => $value ) {
			$styles[$key] = maybe_unserialize( $value[0] );
		}
		extract( $styles );
		?>
		
		<style>
		<?php
		// Add background styles
		if( current_theme_supports('background-styles') ) {
			if( isset($_maven_style_bg_image[0]) ) {
				$bg_image = wp_get_attachment_image_src( $_maven_style_bg_image[0], 'full' );
				$bg_image = $bg_image[0];
			} else {
				$bg_image = $_maven_style_bg_pattern;
				$bg_image = ( $bg_image != 'none' ) ? $bg_image : false;
			}	
			$bg_style = ( $_maven_style_bg_type != 'fullscreen' ) ? $_maven_style_bg_type : false;	
		?>
			body { background: <?php echo $_maven_style_bg_color; ?> <?php if( $bg_image ) { ?>url(<?php echo $bg_image; ?>)<?php } ?> <?php if( $bg_style ) { echo $bg_style; } ?> <?php echo $_maven_style_bg_position; ?>; }
		<?php } ?>
		
		<?php
		// Add branding styles
		if( current_theme_supports('branding-styles') ) { ?>
			<?php if( isset($_maven_style_tagline_color) ) {?>#tagline { color: <?php echo $_maven_style_tagline_color; ?>; }<?php } ?>
			<?php if( isset($_maven_style_copyright_color) ) {?>#copyright p, #copyright a { color: <?php echo $_maven_style_copyright_color; ?>; }<?php } ?>
		<?php } ?>
		
		<?php
		// Add additional styles
		if( current_theme_supports('additional-styles') ) { ?>
			<?php echo ( isset($_maven_style_custom_css) ) ? $_maven_style_custom_css : false; ?>
		<?php } ?>
		</style>
		<?php
	}
}




/**
 * Get an array of the style posts for select fields
 *
 * @since 1.0
 */
function get_maven_styles( $add='' ) {
	$style_array = array();
	$style_list = get_posts( array( 'post_type'=>'maven_styles', 'orderby' => 'title', 'order' => 'ASC' ) );
	foreach( $style_list as $pagg ) { 
		$style_array[] = array( 'name'=>$pagg->post_title, 'value'=>$pagg->ID );
	}
	if( $add != '' && $style_array ) {
		array_unshift( $style_array, $add );
	}
	return $style_array;
}




/**
 * Check if there's a sidebar
 *
 * @since 1.0
 */
function maven_sidebar() {

	$sidebar = false;
	$layout = get_maven_layout();

	if( $layout != 'full-width' ) {
		$sidebar = true;
	}

	return $sidebar;
}