<?php

add_shortcode( 'code', 'maven_code' );
/**
 * Add a block of code
 *
 * @since 1.0
 */
function maven_code( $atts, $content = null ) {

	return '<pre>'.$content.'</pre>';
}





add_shortcode( 'two_col', 'maven_two_col' );
/**
 * Add a two column block.
 *
 * @since 1.0
 */
function maven_two_col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => '',
		'style' => '',
		'span' => ''
	), $atts ) );
	
	// Check for nested shortcode
	$content = maven_parse_shortcode_content( $content );
	
	$span = ( $span != '' ) ? ' maven-two-col-'.$span : '';
	
	return '<div style="'.$style.'" class="maven-col maven-two-col '.$class.$span.'">'.$content.'</div>';
}




add_shortcode( 'three_col', 'maven_three_col' );
/**
 * Add a three column block.
 *
 * @since 1.0
 */
function maven_three_col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => '',
		'style' => '',
		'span' => ''
	), $atts ) );
	
	// Check for nested shortcode
	$content = maven_parse_shortcode_content( $content );
	
	$span = ( $span != '' ) ? ' maven-three-col-'.$span : '';
	
	return '<div style="'.$style.'" class="maven-col maven-three-col '.$class.$span.'">'.$content.'</div>';
}




add_shortcode( 'four_col', 'maven_four_col' );
/**
 * Add a four column block.
 *
 * @since 1.0
 */
function maven_four_col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => '',
		'style' => '',
		'span' => ''
	), $atts ) );
	
	// Check for nested shortcode
	$content = maven_parse_shortcode_content( $content );
	
	$span = ( $span != '' ) ? ' maven-four-col-'.$span : '';
	
	return '<div style="'.$style.'" class="maven-col maven-four-col '.$class.$span.'">'.$content.'</div>';
}




add_shortcode( 'five_col', 'maven_five_col' );
/**
 * Add a five column block.
 *
 * @since 1.0
 */
function maven_five_col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => '',
		'style' => '',
		'span' => ''
	), $atts ) );
	
	// Check for nested shortcode
	$content = maven_parse_shortcode_content( $content );
	
	$span = ( $span != '' ) ? ' maven-five-col-'.$span : '';
	
	return '<div style="'.$style.'" class="maven-col maven-five-col '.$class.$span.'">'.$content.'</div>';
}




add_shortcode( 'six_col', 'maven_six_col' );
/**
 * Add a six column block.
 *
 * @since 1.0
 */
function maven_six_col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => '',
		'style' => '',
		'span' => ''
	), $atts ) );
	
	// Check for nested shortcode
	$content = maven_parse_shortcode_content( $content );
	
	$span = ( $span != '' ) ? ' maven-six-col-'.$span : '';
	
	return '<div style="'.$style.'" class="maven-col maven-six-col '.$class.$span.'">'.$content.'</div>';
}




add_shortcode( 'youtube', 'maven_youtube_shortcode' );
/**
 * Add a youtube shortcode.
 *
 * @since 1.0
 */
function maven_youtube_shortcode( $atts, $content = null ) {
	$defaults = shortcode_atts( array(
		'id' => '',
		'width' => '560',
		'height' => ''
	), $atts );

	return get_m4c_youtube( $defaults );	
}




add_shortcode( 'vimeo', 'maven_vimeo_shortcode' );
/**
 * Add a vimeo shortcode.
 *
 * @since 1.0
 */
function maven_vimeo_shortcode( $atts, $content = null ) {
	$defaults = shortcode_atts( array(
		'id' => '',
		'width' => '560',
		'height' => ''
	), $atts );

	return get_m4c_vimeo( $defaults );	
}




add_shortcode( 'button', 'maven_button_shortcode' );
/**
 * Add a button shortcode.
 *
 * @since 1.0
 */
function maven_button_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'text' => 'Button',
		'link' => '#',
		'target' => '_self',
		'type' => '',
		'size' => '',
		'icon' => '',
		'icon_white' => false,
		'icon_right' => false
	), $atts) );
	
	$type = ( $type != '' ) ? ' btn-'.$type : '';
	$size = ( $size != '' ) ? ' btn-'.$size : '';
	$white = ( $icon_white ) ? ' icon-white' : '';
	$icon = ( $icon != '' ) ? '<i class="icon-'.$icon.$white.'"></i>' : '';
	
	if( $icon_right ) {
		return '<a class="btn'.$type.$size.'" href="'.$link.'" target="'.$target.'">'.$text.' '.$icon.'</a>';
	} else {
		return '<a class="btn'.$type.$size.'" href="'.$link.'" target="'.$target.'">'.$icon.' '.$text.'</a>';
	}
}




add_shortcode( 'alert', 'maven_alert_shortcode' );
/**
 * Add an alert shortcode.
 *
 * @since 1.0
 */
function maven_alert_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'heading' => '',
		'text' => '',
		'type' => '',
		'close' => false
	), $atts) );
	
	$type = ( $type != '' ) ? ' alert-'.$type : '';
	$heading = ( $heading != '' ) ? '<h4 class="alert-heading">'.$heading.'</h4>' : '';
	$close = ( $close ) ? '<a class="close" data-dismiss="alert" href="#">×</a>' : '';
	
	if( $content ) {
		// Check for nested shortcode
		$content = maven_parse_shortcode_content( $content );
		return '<div class="alert alert-block'.$type.'">'.$close.$heading.$content.'</div>';
	} else {
		return '<div class="alert'.$type.'">'.$close.$text.'</div>';
	}
}




add_shortcode( 'tabs_container', 'maven_tabs_container_shortcode' );
/**
 * Add a tabs_container shortcode.
 *
 * @since 1.0
 */
function maven_tabs_container_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'position' => ''
	), $atts) );
	
	$position = ( $position != '' ) ? ' tabs-'.$position : '';

	return '<div class="tabbable'.$position.'">'.maven_parse_shortcode_content( $content ).'</div>';
}




add_shortcode( 'tabs', 'maven_tabs_shortcode' );
/**
 * Add a tabs shortcode.
 *
 * @since 1.0
 */
function maven_tabs_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'tabs',
	), $atts) );
	
	return '<ul class="nav nav-'.$type.'">'.maven_parse_shortcode_content( $content ).'</ul>';
}




add_shortcode( 'tab', 'maven_tab_shortcode' );
/**
 * Add a tabs shortcode.
 *
 * @since 1.0
 */
function maven_tab_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'text' => 'Tab',
		'id' => '',
		'active' => false
	), $atts) );
	
	$active = ( $active ) ? ' class="active"' : '';
	
	return '<li'.$active.'><a href="#'.$id.'" data-toggle="tab">'.$text.'</a></li>';
}




add_shortcode( 'tabs_content', 'maven_tabs_content_shortcode' );
/**
 * Add a tabs shortcode.
 *
 * @since 1.0
 */
function maven_tabs_content_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'text' => ''
	), $atts) );
	
	return '<div class="tab-content">'.maven_parse_shortcode_content( $content ).'</div>';
}




add_shortcode( 'tab_content', 'maven_tab_content_shortcode' );
/**
 * Add a tabs shortcode.
 *
 * @since 1.0
 */
function maven_tab_content_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'active' => false
	), $atts) );
	
	$active = ( $active ) ? ' active' : '';
	
	return '<div class="tab-pane'.$active.'" id="'.$id.'">'.maven_parse_shortcode_content( $content ).'</div>';
}




add_shortcode( 'accordion', 'maven_accordion_shortcode' );
/**
 * Add a tabs shortcode.
 *
 * @since 1.0
 */
function maven_accordion_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'group' => ''
	), $atts) );

	return '<div class="accordion" id="'.$group.'">'.maven_parse_shortcode_content( $content ).'</div>';
}




add_shortcode( 'accordion_group', 'maven_accordion_group_shortcode' );
/**
 * Add a tabs shortcode.
 *
 * @since 1.0
 */
function maven_accordion_group_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'group' => '',
		'heading' => 'Toggle',
		'active' => false
	), $atts) );
	
	$active = ( $active ) ? ' in' : '';

	$html = '<div class="accordion-group">';
	$html .= '<div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$group.'" href="#'.$id.'">'.$heading.'</a></div>';
	$html .= '<div id="'.$id.'" class="accordion-body collapse'.$active.'"><div class="accordion-inner">'.maven_parse_shortcode_content( $content ).'</div></div>';
	$html .= '</div>';
	
	return $html;
}







/*-----------------------------------------------------------------------------------*/
/*	Parse Shortcode content
/*-----------------------------------------------------------------------------------*/
function maven_parse_shortcode_content( $content ) {

	/* Parse nested shortcodes and add formatting. */
	$content = trim( wpautop(do_shortcode($content)) );
	
	/* Remove '</p>' from the start of the string. */
	if ( substr( $content, 0, 4 ) == '</p>' )
	    $content = substr( $content, 4 );
	
	/* Remove '<p>' from the end of the string. */
	if ( substr( $content, -3, 3 ) == '<p>' )
	    $content = substr( $content, 0, -3 );
	
	/* Remove any instances of '<p></p>'. */
	$pattern = "/<p[^>]*><\\/p[^>]*>/";
	$content = preg_replace( $pattern, '', $content ); 
	
	return apply_filters( 'maven_parse_shortcode_content', $content );
}