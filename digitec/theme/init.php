<?php
/**
 * Initialize the theme
 *
 * Add theme support & modify style settings
 *
 * @package WordPress
 * @subpackage Digitec
 */


// Customize the branding styles - @since 1.0
add_filter( 'maven_branding_styles', 'digitec_branding_styles' );




// Add theme support - @since 1.1
add_action( 'maven_init', 'digitec_theme_support', 6 );




/* Define theme constants

* MAVEN_THEME_NAME - @since 1.0.1
* MAVEN_THEME_VERSION - @since 1.1

*/




/**
 * Customize the branding styles
 *
 * @since 1.0
 */
function digitec_branding_styles( $styles ) {

	// Remove settings
	unset( $styles['footer_logo'] );
	unset( $styles['tagline_color'] );
	unset( $styles['copyright_color'] );

	$styles['header_image'] = array(
		'id' => MAVEN_SHORTNAME.'style_header_image',
		'type' => 'image',
		'name' => __( 'Header Image', 'digitec' ),
		'description' => __( 'Upload an image to use for the header image.', 'digitec' ),
		'button' => __( 'Add Image', 'digitec' ),
		'size' => 'full'
	);

	$styles['header_image_bg_color'] = array(
		'id' => MAVEN_SHORTNAME.'style_header_image_bg_color',
		'type' => 'farbtastic',
		'name' => __( 'Header Image Background Color', 'digitec' ),
		'description' => __( 'Select a background color that spans the full with of the site.', 'digitec' ),
		'default' => '#000000'
	);

	$order = array('header_logo','header_image','header_image_bg_color','tagline_color','copyright_color');
	$styles = sort_array_by_array( $styles, $order );

	return $styles;
}




/**
 * Add theme support
 *
 * @since 1.1
 */
function digitec_theme_support() {
	add_theme_support( 'project-postype' );
	//add_theme_support( 'digitec' );
	add_theme_support( 'footer-widgets' );
	add_theme_support( 'additional-content' );
	add_theme_support( 'custom-widget' );

	// Remove theme support
	remove_theme_support( 'background-styles' );
}




/**
 * Define theme constants
 *
 * @since 1.1.7
 */
define ( 'MAVEN_THEME_NAME', 'DigiTec' );
if ( WP_DEBUG ) {
	define ( 'MAVEN_THEME_VERSION', '1.1.7-'.time() );
} else {
	define ( 'MAVEN_THEME_VERSION', '1.1.7' );
}

