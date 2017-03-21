<?php
/**
 * Put all the editor specific code here
 *
 * @package WordPress
 * @subpackage Maven
 */
 
 
 

// Add custom styles to the wysiwyg editor - @since 1.0
add_filter( 'tiny_mce_before_init', 'maven_wysiwyg_styles' );

// Add extra buttons to the wysiwyg editor - @since 1.0
add_filter( 'mce_buttons', 'maven_wysiwyg_buttons' );




/* Additional functions

* add_editor_style // Add editor styles - @since 1.0

*/




/**
 * Add custom styles to the wysiwyg editor
 *
 * @since 1.0
 */
function maven_wysiwyg_styles( $init ) {

	/**
	* Adds the buttons at the begining.
	* (theme_advanced_buttons2_add adds them at the end)
	*/
	$init['theme_advanced_buttons2_add_before'] = 'styleselect';
	$init['theme_advanced_styles'] = 'Clear=clear';
	return $init;
}

/**
 * Add extra buttons to the wysiwyg editor
 *
 * @since 1.0
 */
function maven_wysiwyg_buttons( $buttons ) {
  $buttons[] = 'hr';
  $buttons[] = 'wp_page';
  return $buttons;
}




/**
 * Add editor styles
 *
 * @since 1.0
 */
if( current_theme_supports('editor-style') ) {
	add_editor_style( 'editor-style.css' );
}

