<?php
/**
 * This is where we put all the functions that that don't
 * fit with a specific area globally throughout the site.
 *
 * @category Maven
 * @package  Functions
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/themes/maven
 **/
 
 


/**
 * Add image sizes.
 *
 * @since 1.0
 */
if ( function_exists( 'add_image_size' ) ) { 
	
	$thumbnail = apply_filters( 'maven_thumbnail_size', array(200,135,true) );
	$avatar = apply_filters( 'maven_avatar_size', array(80,80,true) );
	$featured_image = apply_filters( 'maven_featured_image_size', array(680,180,true) );

	// Create custom image sizes
	set_post_thumbnail_size( $thumbnail[0],$thumbnail[1],$thumbnail[2] );
	add_image_size( 'avatar', $avatar[0], $avatar[1], $avatar[2] );
	add_image_size( 'featured-image', $featured_image[0], $featured_image[1], $featured_image[2] );
}



add_filter( 'pre_get_posts','maven_search_results' );
/**
 * Set the search to only show posts
 *
 * @since 1.1.1
 */
function maven_search_results( $query ) {
	
	if( !is_admin() ) {
	
		$options = get_option( 'maven_general_options' );
		
		if ($query->is_search) {	
			$search_types = $options['search_results'];
			$post_types = array();
			foreach( $search_types as $pt => $i ) {
				$post_types[] = $pt;
			}
			$query->set( 'post_type', $post_types );
			
			if( isset($options['404_page']) ) {
				$query->set( 'post__not_in', array($options['404_page']) );
			}
		}
	}

	return $query;
}



remove_filter( 'get_the_excerpt', 'wp_trim_excerpt'  );
add_filter( 'get_the_excerpt', 'maven_trim_excerpt'  );
/**
 * Add shortcodes into the excerpt
 *
 * @since 1.0
 */
function maven_trim_excerpt( $text = '' ) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');
                // $text = strip_shortcodes( $text );
		$text = do_shortcode( $text );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]>', $text );
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$excerpt_more = apply_filters( 'excerpt_more', ' '.'&hellip;' );
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
}




add_filter( 'post_class', 'maven_set_post_class' );
/**
 * Add extra classes to the post
 *
 * @since 1.0
 */
function maven_set_post_class( $classes ) {
	
	global $post;
	
	// Get the post type
	$post_type = get_post_type( get_the_ID() );
	
	$general_options = get_option( 'maven_general_options' );
	
	// Add comment classes
	if( $general_options ) {
		if( isset($general_options['allow_comments'][$post_type]) && $post->comment_status=='open' ) {
			$classes[] = 'comments-enabled';
		} else {
			$classes[] = 'comments-disabled';
		}
	}

	return $classes;
}




add_filter( 'body_class', 'maven_set_body_class' );
/**
 * Add extra classes to the body
 *
 * @since 1.0
 */
function maven_set_body_class( $classes ) {

	$style_options = get_option( 'maven_style_options' );

	// Add color classes
	if( $style_options ) {
		if( isset($style_options['global_style']) ) {
			$classes[] = 'theme-color-'.$style_options['global_style'];
		}
	}

	return $classes;
}




/**
 * Get the current layout.
 *
 * @since 1.0
 */
function get_maven_layout() {
	global $style_id;
	return get_post_meta( $style_id, '_maven_page_layout', true );
}




/**
 * Print a loading gif
 *
 * @since 1.0
 */
function maven_loading_gif( $color='light', $style='' ) {
	echo get_maven_loading_gif( $color, $style );
}




/**
 * Return a loading gif
 *
 * @since 1.0
 */
function get_maven_loading_gif( $color='light', $style='' ) {
	if( $color=='light' ) {
		return '<img class="maven-loading-gif" style="'.$style.'" src="'.MAVEN_ADMIN_IMAGES_URL.'/loading.gif" width="16" height="16" />';
	} else {
		return '<img class="maven-loading-gif" style="'.$style.'" src="'.MAVEN_ADMIN_IMAGES_URL.'/loading.gif" width="16" height="16" />';
	}
}




/**
 * Return the default avatar image source.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default theme image.
 *
 * @since 1.0
 */
function get_maven_default_avatar_src( $size ) {

	$options = get_option( 'maven_general_options' );
	$id = ( isset($options['default_avatar_image'][0]) ) ? $options['default_avatar_image'][0] : false;
	
	if( $id ) {	
		$avatar = wp_get_attachment_image_src( $id, $size );
		return $avatar[0];
	} else {
		return '';
	}
}




/**
 * Print the custom header logo
 *
 * @since 1.0
 */
function maven_header_logo( $attr=false ) {

	echo get_maven_header_logo( $attr );
}




/**
 * Return the custom header logo
 *
 * @since 1.0
 */
function get_maven_header_logo( $attr=false ) {

	// Set defaults
	$defaults = array(
		'class' => ''
	);
	$attr = wp_parse_args( $attr, $defaults );

	// Get the source & dimensions
	$arr = get_maven_header_logo_src();
	
	return '<img src="'.$arr[0].'" width="'.$arr[1].'" height="'.$arr[2].'" class="'.$defaults['class'].'" />';
}




/**
 * Return the custom header logo source.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default logo.
 *
 * @since 1.0
 */
function get_maven_header_logo_src() {

	global $style_id;

	// Get the set sidebar
	$logo_id = get_post_meta( $style_id, '_maven_style_header_logo', true );
	if( isset($logo_id[0]) ) {
		$id = ( get_post($logo_id[0]) ) ? $logo_id[0] : false;
	}

	if( isset($id) ) {
		return wp_get_attachment_image_src( $id, 'full' );
	} else {
		$size = getimagesize( MAVEN_IMAGES_URL.'/defaults/default-header-logo.png' );
		return array( MAVEN_IMAGES_URL.'/defaults/default-header-logo.png', $size[0], $size[1] );
	}
}




/**
 * Print the custom footer logo
 *
 * @since 1.0
 */
function maven_footer_logo( $attr=false ) {

	echo get_maven_footer_logo( $attr );
}




/**
 * Return the custom footer logo
 *
 * @since 1.0
 */
function get_maven_footer_logo( $attr=false ) {

	// Set defaults
	$defaults = array(
		'class' => ''
	);
	$attr = wp_parse_args( $attr, $defaults );
	
	// Get the source & dimensions
	$arr = get_maven_footer_logo_src();
	
	return '<img src="'.$arr[0].'" width="'.$arr[1].'" height="'.$arr[2].'" class="'.$defaults['class'].'" />';
}




/**
 * Return the custom footer logo source.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default logo.
 *
 * @since 1.0
 */
function get_maven_footer_logo_src() {

	global $style_id;

	// Get the set sidebar
	$logo_id = get_post_meta( $style_id, '_maven_style_footer_logo', true );
	$id = ( get_post($logo_id[0]) ) ? $logo_id[0] : false;

	if( $id ) {
		return wp_get_attachment_image_src( $id, 'full' );
	} else {
		$size = getimagesize( MAVEN_IMAGES_URL.'/defaults/default-footer-logo.png' );
		return array( MAVEN_IMAGES_URL.'/defaults/default-footer-logo.png', $size[0], $size[1] );
	}
}




/**
 * Single navigation.
 *
 * @since 1.0
 */
function maven_single_nav( $nav_id = 'top' ) {
	
	$prev_post = get_previous_post();
	$next_post = get_next_post();
		
	if ( !empty( $prev_post ) || !empty( $next_post ) ) {
	?>
	<nav id="single-nav-<?php echo $nav_id; ?>" class="single-nav clearfix">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'digitec' ); ?></h3>	
		<?php if ( !empty( $prev_post ) ) : ?>
		<span class="nav-previous-container">
			<span class="nav-previous"><?php previous_post_link( '%link', '<span>%title</span>' ); ?></span>
		</span><!-- .nav-previous-container -->
		<?php endif; ?>
		
		<?php if ( !empty( $next_post ) ) : ?>
		<span class="nav-next-container">
			<span class="nav-next"><?php next_post_link( '%link', '<span>%title</span>' ); ?></span>
		</span><!-- .nav-next-container -->
		<?php endif; ?>		
	</nav><!-- #nav-single -->
	<?php
	}
}




/**
 * Archive navigation.
 *
 * @since 1.0
 */
function maven_content_nav( $nav_id = 'top' ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) {
		?>
		<nav id="content-nav-<?php echo $nav_id; ?>" class="content-nav clearfix">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'digitec' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( 'Older Posts', 'digitec' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer Posts', 'digitec' ) ); ?></div>
		</nav><!-- #nav-above -->
		<?php
	}
}




/**
 * Archive post pagination
 *
 * Moved from projects.php to general.php
 *
 * @since 1.0
 */
function maven_pagination( $nav_id = 'top' ) {
	
	// Get total number of pages
	global $wp_query;
	$total = $wp_query->max_num_pages;

	// If there is more than 1 page, display the links
	if ( $total > 1 )  {
		
		// Get the current page
		if ( !$current_page = get_query_var('paged') ) {
			$current_page = 1;
		}
		
		// Get the user defined page structure
		$structure = get_option( 'permalink_structure' );
		$format = empty( $structure ) ? '&page=%#%' : 'page/%#%/';
		
		// Create the base structure
		$base = get_pagenum_link(1) . '%_%';
		
		// Modify base structure if search or archive page
		if ( is_search() || is_archive() ) {
			$big = 999999999; // need an unlikely integer
			$base = str_replace( $big, '%#%', get_pagenum_link( $big ) );	
		}
	     
		$defaults = array(
			'base' => $base,
			'format' => $format,
			'current' => $current_page,
			'total' => $total,
			'mid_size' => 4,
			'type' => 'list',
			'prev_text' => __( 'previous', 'digitec' ),
			'next_text' => __( 'next', 'digitec' )
		);
		
		// Apply filter & merge with defualts
		$args = apply_filters( 'maven_pagination_args', $defaults );
		$links = apply_filters( 'maven_pagination', paginate_links( $args ) );
		
		// Display the links
		echo '<div id="paginate-container-'.$nav_id.'" class="paginate-container clearfix">'.$links.'</div>';
	}
}




/**
 * Post pagination
 *
 * Moved from projects.php to general.php
 *
 * @since 1.0
 */
function maven_link_pages( $args='' ) {
	
	$defaults = array(
		'before' => '<span class="paginate-heading">'.__( 'Pages' , 'digitec' ).'</span>',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'nextpagelink' => __( 'Next page', 'digitec' ),
		'previouspagelink' => __( 'Previous page', 'digitec' ),
		'pagelink' => '%',
		'echo' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'maven_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {

		$output .= '<div id="page-paginate-container" class="paginate-container clearfix">';
		$output .= $before;
		$output .= '<ul class="page-numbers">';
		
		$i = $page - 1;
		if ( $i ) {
			$output .= '<li class="prev-link">'._wp_link_page($i);
			$output .= $link_before. $previouspagelink . $link_after . '</a></li>';
		}		
					
		for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
			$j = str_replace('%',$i,$pagelink);
			$output .= ' ';
			if ( ($i != $page) || ((!$more) && ($page==1)) ) {
				$output .= '<li>'._wp_link_page($i);
			} else {
				$output .= '<li><span class="current">';
			}
			$output .= $link_before . $j . $link_after;
			if ( ($i != $page) || ((!$more) && ($page==1)) ) {
				$output .= '</a></li>';
			} else {
				$output .= '</span></li>';
			}
		}
		
		$i = $page + 1;
		if ( $i <= $numpages ) {
			$output .= '<li class="next-link">'._wp_link_page($i);
			$output .= $link_before. $nextpagelink . $link_after . '</a></li>';
		}

		$output .= '</ul>';
		//$output .= $after;
		$output .= '</div>';
		
	}

	if ( $echo ) {
		echo $output;
	}

	return $output;
}




/**
 * Sort an array by an array
 *
 * @since 1.0
 */
function sort_array_by_array( $array, $orderArray ) {
	$ordered = array();
	foreach( $orderArray as $key ) {
		if( array_key_exists($key, $array) ) {
			$ordered[$key] = $array[$key];
			unset($array[$key]);
		}
	}
	return $ordered;
}




/**
 * Return a list of pages
 *
 * @since 1.0
 */
function get_maven_page_array( $value=false, $add=false ) {
	$pages = get_pages();
	$page_array = array();
	
	if( $add ) {
		$page_array[] = $add;
	}
  foreach ( $pages as $page ) {
  	if( $value ) {
	  	$page_array[] = array( 'value'=>$page->ID, 'name'=>$page->post_title );
  	} else {
  		$page_array[$page->ID] = $page->post_title;
  	}
  }
  return $page_array;
}




/**
 * Return the global options post types
 *
 * @since 1.0
 */
function get_maven_global_options_post_types( $supports=false, $keys=false ) {

	$post_types = get_post_types( array('public'=>true),'objects' ); 
	$maven_post_types = array();
	foreach ($post_types as $post_type ) {
		$labels = $post_type->labels;
		$maven_post_types[$post_type->name] = $labels->name;
	}
	
	// Remove page styles
	unset( $maven_post_types['maven_styles'] );
	
	if( is_search() ) {
		$maven_post_types['search'] = 'Search';
	}

	// Filter the post types
	$maven_post_types = apply_filters( 'maven_post_types', $maven_post_types );
	
	// Filter post types by taxonomy
	if( $supports ) {
		$taxonomy = get_taxonomy( $supports );
		if( $taxonomy ) {
			$taxomony_supports = $taxonomy->object_type;
			foreach( $maven_post_types as $i => $post_type ) {
				
				// Check if the post type has a specific taxonomy
				if( ! in_array($i, $taxomony_supports) ) {
					
					// If not, reemove the post type
					unset( $maven_post_types[$i] );
				}
			}
		}
	}
	
	// If returning just the keys
	if( $keys ) {
		foreach( $maven_post_types as $i => $post_type ) {
			$maven_post_types[$i] = $i;
		}
	}

	return $maven_post_types;
}




/**
 * Echo the appropriate attachment image
 *
 * @since 1.0
 */
function maven_project_featured_image( $post_id=false, $size, $icon=false, $attr=false ) {

	echo get_maven_project_featured_image( $post_id, $size, $icon, $attr );
}



/**
 * Get a project featured image.
 *
 * @since 1.0
 */
function get_maven_project_featured_image( $post_id=false, $size, $icon=false, $attr=false ) {
	
	// Check for featured image first
	$image_id = get_post_thumbnail_id();
	if( !$image_id ) {
	
		// Get the first attachment image
		$attachments = get_post_meta( get_the_ID(), '_maven_attachments', true );
		$image_id = $attachments[0];
	}
	return get_m4c_attachment_image( $image_id, $size, $icon, $attr );	
}




/**
 * Set a maximum excerpt length
 *
 * @since 1.0
 */
function maven_excerpt( $charlength = 200 ) {
	echo get_maven_excerpt( $charlength );
}
function get_maven_excerpt( $charlength = 200 ) {
	$excerpt = get_the_excerpt();
	$charlength++;
	
	$output = '';
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$output .= mb_substr( $subex, 0, $excut );
		} else {
			$output .= $subex;
		}
		$output .= '&hellip;';
	} else {
		$output .= $excerpt;
	}
	return $output;
}



/**
 * Print custom excerpts
 *
 * @since 1.0
 */
function maven_excerpt_combo( $length_callback=false, $more_callback=false ) {
  echo get_maven_excerpt_combo( $length_callback, $more_callback);
}




/**
 * Return custom excerpts
 *
 * @since 1.0
 */
function get_maven_excerpt_combo( $length_callback=false, $more_callback=false ) {
  global $post;
  if( $length_callback ) {
    if( function_exists( $length_callback ) ){
      add_filter( 'excerpt_length', $length_callback );
    }
  }
  if( $length_callback ) {
    if( function_exists( $more_callback ) ){
      add_filter( 'excerpt_more', $more_callback );
    }
  }
  $output = get_the_excerpt();
  $output = apply_filters( 'wptexturize', $output );
  $output = apply_filters( 'convert_chars', $output );
  $output = '<p>'.$output.'</p>';
  return $output;
}
