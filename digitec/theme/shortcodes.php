<?php
/**
 * Theme specific shortcodes
 *
 * Create the shortcodes that can be
 * used throughout the site
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Create a block title - @since 1.0
add_shortcode( 'block_title', 'digitec_block_title' );

// Create an info block - @since 1.0
add_shortcode( 'info_block', 'digitec_info_block' );

// Create content blocks - @since 1.0
add_shortcode( 'content_blocks', 'digitec_content_blocks' );

// Create a post slider - @since 1.0
add_shortcode( 'post_slider', 'digitec_post_slider' );

// Create a post block - @since 1.0
add_shortcode( 'post_block', 'digitec_post_block' );




/**
 * Create a block title
 *
 * @since 1.0
 */
function digitec_block_title( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title_left' => '',
		'title_right' => '',
		'link' => false,
		'target' => '_self',
		'style' => ''
	), $atts ) );
	
	$link = sanitize_url($link);
	
	$html = '<div class="digi-block-title clearfix" style="'.$style.'"><p class="clearfix">';
	if( $link ) {
		$html .= '<a href="'.$link.'" target="'.sanitize_text_field($target).'">';
	}
	if( $title_left != '' ) {
		$html .= $title_left;
	}
	if( $title_right != '') {
		$html .= '<span>'.$title_right.'</span>';
	}
	if( $link ) {
		$html .= '</a>';
	}
	$html .= '</p></div>';
	
	return $html;
}

/**
 * Create an info block
 *
 * @since 1.0
 */
function digitec_info_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title_left' => '',
		'title_right' => '',
		'link' => false,
		'target' => '_self',
		'style' => ''
	), $atts ) );
	
	$link = sanitize_url($link);
	
	$html = '<table class="digi-info-block" style="'.$style.'"><tr>';
	$html .= '<td class="digi-info-title">';
	$html .= '<span class="digi-info-circle"></span>';
	$html .= '<p>';
	if( $link ) {
		$html .= '<a href="'.$link.'" target="'.sanitize_text_field($target).'">';
	}
	if( $title_left != '' ) {
		$html .= '<span>'.$title_left.'</span>';
	}
	if( $title_right != '') {
		$html .= $title_right;
	}
	if( $link ) {
		$html .= '</a>';
	}
	$html .= '</p></td>';
	if( $content ) {
		$html .= '<td class="digi-info-content">';
		$html .= maven_parse_shortcode_content( $content );
		$html .= '</td>';
	}
	$html .= '</tr></table>';
	
	return $html;
}

/**
 * Create content blocks
 *
 * @since 1.0
 */
function digitec_content_blocks( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'border' => ''
	), $atts ) );
	
	// If there's a post with the supplied ID
	if( get_post($id) ) {
		
		$title = get_post_meta( $id, '_digitec_contentblock_title', true );
		$title_position = get_post_meta( $id, '_digitec_contentblock_title_position', true );
		$content_1 = get_post_meta( $id, '_digitec_contentblock_1', true );
		$content_2 = get_post_meta( $id, '_digitec_contentblock_2', true );
		$content_3 = get_post_meta( $id, '_digitec_contentblock_3', true );
		$content_4 = get_post_meta( $id, '_digitec_contentblock_4', true );
		
		$html = '';
		$border = ( $border != '' ) ? ' border-'.sanitize_text_field($border) : '';
		$html .= '<div class="content-block-container'.$border.'">';
		$html .= '<div class="wrapper">';
		
		if( $title ) {
			if( $title_position == 'above' ) {
				$html .= '<div class="content-blocks four-col clearfix">';
				$html .= '<div class="widget-area"><h3 class="widget-title">'.get_the_title($id).'</h3></div>';
				$html .= '</div>';
			}
		}
		
		$html .= '<div class="content-blocks four-col clearfix">';
		$html .= '<div class="widget-area">';
		if( $title ) {
			if( $title_position != 'above' ) {
				$html .= '<h3 class="widget-title">'.get_the_title($id).'</h3>';
			}
		}
		$html .= maven_parse_shortcode_content($content_1);
		$html .= '</div>';
		$html .= '<div class="widget-area">'.maven_parse_shortcode_content($content_2).'</div>';
		$html .= '<div class="widget-area">'.maven_parse_shortcode_content($content_3).'</div>';
		$html .= '<div class="widget-area">'.maven_parse_shortcode_content($content_4).'</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		
		return $html;
	}
}

/**
 * Create a post slider
 *
 * @since 1.0
 */
function digitec_post_slider( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'post',
		'title' => __( 'Blog Posts', 'digitec' ),
		'orderby' => 'rand',
		'order' => 'DESC',
		'limit' => '-1',
		'border' => ''
	), $atts ) );
	
	$args = array(
		'post_type'=> $type,
		'orderby' => $orderby,
		'order' => $order,
		'posts_per_page' => $limit,
		'post__not_in' => array( get_the_ID() )
	);
	
	// Save the original query & create a new one
	global $wp_query;
	$original_query = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query( $args );
	
	$html = '';
	$border = ( $border != '' ) ? ' border-'.sanitize_text_field($border) : '';

	if ( $wp_query->have_posts() ) :
	
	$html .= '<div class="post-slider-container'.$border.'">';
	$html .= '<div class="wrapper">';
	$html .= '<div class="post-slider '.$type.'-post-slider">';
	$html .= '<div class="post-slider-header clearfix">';
	if( $title != '' ) {
		$html .= '<h3 class="post-slider-title">'.$title.'</h3>';
	}
	$html .= '<div class="post-slider-navigation clearfix">';

	$html .= '<h3 class="assistive-text">'.__( 'Post navigation', 'digitec' ).'</h3>';
	$html .= '<span class="nav-previous-container">';
	$html .= '<span class="nav-previous"><a href="#" class="digibutton disabled"><i class="icon-arrow-left icon-arrow"><span></span></i></a></span>';
	$html .= '</span>';
			
	$html .= '<span class="nav-next-container">';
	$html .= '<span class="nav-next"><a href="#" class="digibutton"><i class="icon-arrow-right icon-arrow"><span></span></i></a></span>';
	$html .= '</span>';

	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="post-slider-content-container">';
	$html .= '<div class="post-slider-content">';
	
	/* Start the Loop */
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
	
		ob_start();
		maven_loop( $type.'_block' );
		$html .= ob_get_clean();

	endwhile;
	
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	else :
	endif;

	$wp_query = null;
	$wp_query = $original_query;
	wp_reset_postdata();

	return $html;
}

/**
 * Create a post block
 *
 * @since 1.0
 */
function digitec_post_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
	
	global $post;
	$original_post = $post;
	$post = null;
	$post = get_post( $id );
	
	$post_type = get_post_type();
      
	ob_start();
	maven_loop( $post_type.'_block' );
	$html = ob_get_clean();

	$post = null;
	$post = $original_post;

	return $html;
}
