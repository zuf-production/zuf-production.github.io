<?php
/**
 * This is where we put the options code for the plugin
 *
 * @category Plugins
 * @package  MetaTools
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/plugins/metatools
 **/
 



add_action( 'admin_init', 'm4c_initialize_metatools_settings' );
/**
 * Initializes metatools options.
 *
 * @since 1.0
 */ 
function m4c_initialize_metatools_settings() {
	
	if( current_theme_supports('m4c_default_media_images')  ) {
		
		/* Register the Default Image options */
		add_settings_section(
			'metatools_media_images_settings_section',				// ID used to identify this section and with which to register options
			__('Default Images', 'digitec'),											// Title to be displayed on the administration page
			'metatools_default_images_section_callback',			// Callback used to render the description of the section
			'media'																						// Page on which to add this section of options
		);
		
		// Default audio image
		add_settings_field(	
			'm4c_default_audio_image',										// ID used to identify the field throughout the theme
			__('Default Audio Image', 'digitec'),							// The label to the left of the option interface element
			'm4c_settings_callback',											// The name of the function responsible for rendering the option interface
			'media',																			// The page on which this option will be displayed
			'metatools_media_images_settings_section',		// The name of the section to which this field belongs
			array(
				'id' => 'm4c_default_audio_image',
				'type' => 'image',
				'description' => __('Set the default image to be used for audio attachments', 'digitec')
			)
		);
	
		// Default video image
		add_settings_field(	
			'm4c_default_video_image',										// ID used to identify the field throughout the theme
			__('Default Video Image', 'digitec'),							// The label to the left of the option interface element
			'm4c_settings_callback',											// The name of the function responsible for rendering the option interface
			'media',																			// The page on which this option will be displayed
			'metatools_media_images_settings_section',		// The name of the section to which this field belongs
			array(
				'id' => 'm4c_default_video_image',
				'type' => 'image',
				'description' => __('Set the default image to be used for video attachments', 'digitec')
			)
		);
		
		// Register the fields with WordPress
		register_setting( 'media', 'm4c_default_audio_image' );
		register_setting( 'media', 'm4c_default_video_image' );
	}
	
	/* Register the Media options */
	add_settings_section(
		'metatools_mime_type_settings_section',						// ID used to identify this section and with which to register options
		__('Custom Mime Type Icons', 'digitec'),							// Title to be displayed on the administration page
		'metatools_custom_mime_section_callback',					// Callback used to render the description of the section
		'media'																						// Page on which to add this section of options
	);
	
	// Custom Mime Types
	add_settings_field(	
		'm4c_custom_mime_type_icons',							// ID used to identify the field throughout the theme
		__('Use Custom Icons', 'digitec'),						// The label to the left of the option interface element
		'm4c_settings_callback',									// The name of the function responsible for rendering the option interface
		'media',																	// The page on which this option will be displayed
		'metatools_mime_type_settings_section',		// The name of the section to which this field belongs
		array(
			'id' => 'm4c_custom_mime_type_icons',
			'type' => 'checkbox'
		)
	);
	
	// Register the fields with WordPress
	register_setting( 'media', 'm4c_custom_mime_type_icons' );
}




/**
 * The callback function for the default images settings sections.
 *
 * @since 1.0
 */ 
function metatools_default_images_section_callback() {
	echo '<p>'.__('Set default images to use for uploaded audio & video attachments.', 'digitec').'<br/><small>*'.__('These can be overridden by individual attachments.', 'digitec').'</small></p>';
}




/**
 * The callback function for the custom mime types settings sections.
 *
 * @since 1.0
 */ 
function metatools_custom_mime_section_callback() {
	echo '<p>'.__('Select to use customized mime type icons. Check this option if you want Vimeo & YouTube icons to display.', 'digitec').'</p>';
}




/**
 * The custom field callback.
 * This is used for the theme framework and all other M4C plugins.
 *
 * @since 1.0
 */ 
function m4c_settings_callback( $args ) {
	
	// First, we read the options collection
	if( isset($args['option']) ) {
		$options = get_option( $args['option'] );
		$value = isset( $options[$args['option_id']] ) ? $options[$args['option_id']] : '';
	} else {
		$value = get_option( $args['id'] );
	}	
	if( $value == '' && isset($args['default']) ) {
		$value = $args['default'];
	}
	if( isset($args['type']) ) {
	
		echo '<div class="m4c-field m4c-'.$args['type'].'">';
		
		// Call the function to display the field
		if ( function_exists('metaboxer_'.$args['type']) ) {
			call_user_func( 'metaboxer_'.$args['type'], $args, $value );
		}
		
		echo '<div>';
	}
	
	// Add a descriptions
	if( isset($args['description']) ) {
		echo '<span class="description"><small>'.$args['description'].'</small></span>';
	}
}