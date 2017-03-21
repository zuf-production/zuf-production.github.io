<?php
/**
 * Search specific theme code
 *
 * The code that specifically deals with
 * search results goes here
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Modify the general theme settings - @since 1.0
add_filter( 'maven_general_settings', 'digitec_general_settings' );

// Modify the style theme settings - @since 1.1
add_filter( 'maven_style_settings', 'digitec_style_settings' );

// Modify the social theme settings - @since 1.0
add_filter( 'maven_social_settings', 'digitec_social_settings' );




/**
 * Modify the general theme settings
 *
 * @since 1.0
 */
function digitec_general_settings( $settings ) {
	
	// Remove settings
	$additional_header = $settings['additional_header'];
	$favicon = $settings['favicon'];
	$default_avatar_image = $settings['default_avatar_image'];
	$four04_page = $settings['404_page'];
	$google_analytics = $settings['google_analytics'];
	
	unset( $settings['copyright_text'] );
	unset( $settings['additional_header'] );
	unset( $settings['favicon'] );
	unset( $settings['default_avatar_image'] );
	unset( $settings['404_page'] );
	unset( $settings['google_analytics'] );
	
	// Add new settings
	$settings['team_slug'] = array(
		'title' => __( 'Team Slug', 'digitec' ),
		'type' => 'text',
		'default' => 'team',
		'description' => __( 'Set a custom slug for the team post type. <strong>Update your permalinks after changing!</strong><br/><strong>*Note:</strong> You can not have a page that uses the same slug... this will cause issues!', 'digitec' )
	);
	$settings['featured_slider_header'] = array(
		'title' => '<strong>'.__( 'Featured Slider Settings', 'digitec' ).'</strong>'
	);
	$settings['featured_slider_timer'] = array(
		'title' => __( 'Enable Timer', 'digitec' ),
		'type' => 'checkbox'
	);
	$settings['featured_slider_timer_speed'] = array(
		'title' => __( 'Timer Speed', 'digitec' ),
		'type' => 'text',
		'after' => ' seconds',
		'size' => 5,
		'default' => 7,
		'text_align' => 'right'
	);
	$settings['footer_header'] = array(
		'title' => '<strong>'.__( 'Footer Data', 'digitec' ).'</strong>'
	);	
	$settings['footer_text_left'] = array(
		'title' => __( 'Footer Text Left', 'digitec' ),
		'type' => 'textarea',
		'cols' => '70',
		'default' => 'Copyright � 2012 DigiTec. All Rights Reserved.'
	);
	$settings['footer_text_right'] = array(
		'title' => __( 'Footer Text Right', 'digitec' ),
		'type' => 'textarea',
		'cols' => '70',
		'default' => 'Theme by <a href="http://themeforest.net/user/digitalscience" target="_blank">digitalscience</a> &amp; <a href="http://themeforest.net/user/JoeMC" target="_blank">Metaphor Creations</a>'
	);
	$settings['additional_header'] = $additional_header;
	$settings['favicon'] = $favicon;
	$settings['default_avatar_image'] = $default_avatar_image;
	$settings['404_page'] = $four04_page;
	$settings['google_analytics'] = $google_analytics;

	return $settings;
}

/**
 * Modify the style theme settings
 *
 * @since 1.1
 */
function digitec_style_settings( $settings ) {
	
	// Remove settings
	unset( $settings['search'] );
	unset( $settings['404'] );
	
	// Add new settings
	$settings['global_style'] = array(
		'title' => __( 'Color', 'digitec' ),
		'type' => 'select',
		'options' => array(
			'default' => __( 'Default - Blue', 'digitec' ),
			'yellow' => __( 'Yellow', 'digitec' ),
			'red' => __( 'Red', 'digitec' ),
			'white' => __( 'White', 'digitec' )
		)
	);
	$settings['team'] = array(
		'title' => __( 'Team Style', 'digitec' ),
		'type' => 'select',
		'options' => get_maven_styles(),
		'description' => __( ' Select the default style of team and members pages.', 'digitec' )
	);
	$settings['search'] = array(
		'title' => __( 'Search Style', 'digitec' ),
		'type' => 'select',
		'options' => get_maven_styles(),
		'description' => __( ' Select the default style of search pages.', 'digitec' )
	);

	return $settings;
}

/**
 * Modify the social theme settings
 *
 * @since 1.0
 */
function digitec_social_settings( $settings ) {
	
	// Remove settings
	unset( $settings['twitter_link'] );
	unset( $settings['facebook_link'] );
	unset( $settings['google_link'] );
	unset( $settings['linkedin_link'] );

	return $settings;
}
