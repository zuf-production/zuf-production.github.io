<?php
/**
 * General theme code
 *
 * Put all the code here that doesn't specifically fit
 * in any other file
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Add custom post types - @since 1.0
add_filter( 'maven_custom_posttypes', 'digitec_custom_posttypes' );

// Modify the custom post type array creation - @since 1.0
add_filter( 'maven_post_types', 'digitec_post_types', 0 );

// Modify the featured image size - @since 1.0
add_filter( 'maven_featured_image', 'digitec_featured_image_filter' );

// Filter the pagination args - @since 1.0
add_filter( 'maven_pagination_args', 'digitec_pagination_args' );
add_filter( 'maven_comment_pagination_args', 'digitec_pagination_args' );

// Filter the pagination output - @since 1.0
add_filter( 'maven_pagination', 'digitec_pagination' );
add_filter( 'maven_comment_pagination', 'digitec_comment_pagination' );

// Filter the link pages args - @since 1.0
add_filter( 'maven_link_pages_args', 'digitec_link_pages_args' );

// Modify the number of posts per page - @since 1.0
add_filter( 'pre_option_posts_per_page', 'digitec_posts_per_page' );

// Modify the archive loop args - @since 1.0
add_filter( 'maven_archive_loop_args', 'digitec_archive_loop_args' );

// Filter the readmore link - @since 1.0
add_filter( 'maven_readmore_link', 'digitec_readmore_link' );

// Filter the viewpost link - @since 1.0
add_filter( 'maven_viewpost_link', 'digitec_viewpost_link' );

// Add styles to the editor - @since 1.0
add_filter( 'tiny_mce_before_init', 'digitec_wysiwyg_styles' );

// Modify the ContactForm 7 loader url - @since 1.0
add_filter( 'wpcf7_ajax_loader', 'digitec_wpcf7_ajax_loader' );




// Enqueue the scripts used on the front-end of the site - @since 1.1
add_action( 'wp_enqueue_scripts', 'digitec_load_scripts' );

// Add scripts to the footer - @since 1.0
add_action( 'wp_footer', 'digitec_footer_scripts', 5 );

// Remove default actions - @since 1.0
add_action( 'pre_get_posts', 'digitec_remove_default_post_actions', 11 );

// Add the header section - @since 1.0
add_action( 'maven_header', 'digitec_do_header' );

// Add the header image - @since 1.0
add_action( 'maven_after_header', 'digitec_after_header' );

// Add page titles - @since 1.0
add_action( 'maven_before_page_primary_secondary', 'digitec_page_titles', 5 );
add_action( 'maven_before_post_primary_secondary', 'digitec_page_titles', 5 );
add_action( 'maven_before_project_primary_secondary', 'digitec_page_titles', 5 );
add_action( 'maven_before_team_primary_secondary', 'digitec_page_titles', 5 );

// Re-arrange the featured image - @since 1.0
add_action( 'maven_after_post_entry_title', 'digitec_featured_image', 5 );
add_action( 'maven_after_page_entry_title', 'digitec_featured_image', 5 );
add_action( 'maven_after_search_entry_title', 'digitec_featured_image', 5 );

// Add the footer - @since 1.0
add_action( 'maven_footer', 'digitec_footer' );




/* Additional functions

* add_image_size // Add image sizes - @since 1.0
* digitec_comment // Output the comments list - @since 1.0

*/




/**
 * Add custom post types
 *
 * @since 1.0
 */
function digitec_custom_posttypes( $posttypes ) {
	
	/**
	 * Creates a team post type.
	 *
	 * @since 1.0
	 */
	$team_labels = array(
		'name' => __( 'Team Members', 'digitec' ),
		'singular_name' =>  __( 'Team Member', 'digitec' ),
		'add_new' =>  __( 'Add New', 'digitec' ),
		'add_new_item' =>  __( 'Add New Team Member', 'digitec' ),
		'edit_item' =>  __( 'Edit Team Member', 'digitec' ),
		'new_item' =>  __( 'New Team Member', 'digitec' ),
		'view_item' =>  __( 'View Team Member', 'digitec' ),
		'search_items' =>  __( 'Search Team Members', 'digitec' ),
		'not_found' =>  __( 'No Team Members Found', 'digitec' ),
		'not_found_in_trash' =>  __( 'No Team Members Found In Trash', 'digitec' ),
		'parent_item_colon' => '',
		'menu_name' =>  __( 'Team', 'digitec' )
	);
	
	// Get the custom post slug
	$options = get_option( 'maven_general_options' );
	$slug = ( $options ) ? sanitize_text_field( $options['team_slug'] ) : 'project';

	// Create the arguments
	$team_args = array(
		'labels' => $team_labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
		'show_in_nav_menus' => true,
		'rewrite' => array( 'slug' => $slug )
	);

	/**
	 * Creates a content block post type.
	 *
	 * @since 1.0
	 */
	$contentblock_labels = array(
		'name' => __( 'Content Blocks', 'digitec' ),
		'singular_name' => __( 'Content Block', 'digitec' ),
		'add_new' => __( 'Add New', 'digitec' ),
		'add_new_item' => __( 'Add New Content Block', 'digitec' ),
		'edit_item' => __( 'Edit Content Block', 'digitec' ),
		'new_item' => __( 'New Content Block', 'digitec' ),
		'view_item' => __( 'View Content Block', 'digitec' ),
		'search_items' => __( 'Search Content Blocks', 'digitec' ),
		'not_found' => __( 'No Content Blocks Found', 'digitec' ),
		'not_found_in_trash' => __( 'No Content Blocks Found In Trash', 'digitec' ),
		'parent_item_colon' => '',
		'menu_name' => __( 'Content Blocks', 'digitec' )
	);

	// Create the arguments
	$contentblock_args = array(
		'labels' => $contentblock_labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'supports' => array( 'title' ),
		'show_in_nav_menus' => false
	);

	/**
	 * Creates a slider post type.
	 *
	 * @since 1.0
	 */
	$sliderblock_labels = array(
		'name' =>  __( 'Slider Blocks', 'digitec' ),
		'singular_name' =>  __( 'Slider Block', 'digitec' ),
		'add_new' =>  __( 'Add New', 'digitec' ),
		'add_new_item' =>  __( 'Add New Slider Block', 'digitec' ),
		'edit_item' =>  __( 'Edit Slider Block', 'digitec' ),
		'new_item' =>  __( 'New Slider Block', 'digitec' ),
		'view_item' =>  __( 'View Slider Block', 'digitec' ),
		'search_items' =>  __( 'Search Slider Blocks', 'digitec' ),
		'not_found' =>  __( 'No Slider Blocks Found', 'digitec' ),
		'not_found_in_trash' =>  __( 'No Slider Blocks Found In Trash', 'digitec' ),
		'parent_item_colon' => '',
		'menu_name' =>  __( 'Slider Blocks', 'digitec' )
	);

	// Create the arguments
	$sliderblock_args = array(
		'labels' => $sliderblock_labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'show_in_nav_menus' => false
	);
	
	// Add the post type
	$posttypes['team'] = $team_args;
	$posttypes['contentblock'] = $contentblock_args;
	$posttypes['sliderblock'] = $sliderblock_args;
	
	// Return the post types
	return $posttypes;
}

/**
 * Modify the custom post type array creation
 *
 * @since 1.0
 */
function digitec_post_types( $post_types ) {
	
	// Remove post types
	unset( $post_types['attachment'] );
	unset( $post_types['contentblock'] );
	unset( $post_types['sliderblock'] );

	return $post_types;
}

/**
 * Modify the featured image size
 *
 * @since 1.0
 */
function digitec_featured_image_filter( $size ) {

	if( is_search() ) {
		if( maven_sidebar() ) {
		
		} else {
			$size = 'search-image';
		}
	}	
	return $size;
}

/**
 * Set the pagination args
 *
 * @since 1.0
 */
function digitec_pagination_args( $args ) {

	$args['prev_text'] = __( 'Prev', 'digitec' );
	$args['next_text'] = __( 'Next', 'digitec' );
	
	return $args;
}

/**
 * Filter the pagination output
 *
 * @since 1.0
 */
function digitec_pagination( $links ) {
	return '<span class="paginate-heading">'.__( 'Pages', 'digitec' ).'</span> '.$links;
}

function digitec_comment_pagination( $links ) {
	return '<span class="paginate-heading">'.__( 'Comments', 'digitec' ).'</span> '.$links;
}

/**
 * Filter the link pages args
 *
 * @since 1.0
 */
function digitec_link_pages_args( $args ) {

	$args['before'] = '<span class="paginate-heading">'.__( 'Page' , 'digitec' ).'</span>';
	$args['previouspagelink'] = __( 'Prev', 'digitec' );
	$args['nextpagelink'] = __( 'Next', 'digitec' );

	return $args;
}

/**
 * Modify the number of posts per page
 *
 * @since 1.0
 */
function digitec_posts_per_page() {
	
	global $wp_query;
	if ( is_search() ) {
    return 10;
	} else {
		$all_options = wp_load_alloptions();
		return $all_options["posts_per_page"];
	}
}

/**
 * Modify the archive loop args
 *
 * @since 1.0
 */
function digitec_archive_loop_args( $args ) {
	
	if( is_page_template('pgtemp_team.php') ) {
		$args['posts_per_page'] = 8;
		//$args['orderby'] = 'menu_order';
		//$args['order'] = 'ASC';
	} elseif( is_page_template('pgtemp_portfolio.php') ) {
		$args['posts_per_page'] = 12;
		//$args['orderby'] = 'menu_order';
		//$args['order'] = 'ASC';
	}

	return $args;
}

/**
 * Filter the readmore link
 *
 * @since 1.0
 */
function digitec_readmore_link( $readmore ) {

	$readmore = '<a class="readmore digilink" href="'.get_permalink().'"> '.__( 'Read more', 'digitec' ).'</a>';
	return $readmore;
}

/**
 * Filter the viewpost link
 *
 * @since 1.0
 */
function digitec_viewpost_link( $viewpost ) {

	$viewpost = '<a class="readmore digilink" href="'.get_permalink().'"> '.__( 'View post', 'digitec' ).'</a>';
	return $viewpost;
}

/**
 * Add styles to the editor
 *
 * @since 1.0
 */
function digitec_wysiwyg_styles( $init ) {

	$init['theme_advanced_styles'] = $init['theme_advanced_styles'].',Sub-heading=sub-heading, Inline Heading=inline-heading, Link Underline=link-underline, Image Border=image-border, DigiLink=digilink, DigiLink Alt=digilink-alt, DigiButton=digibutton, DigiButton Arrow=digibutton-arrow, DigiButton Flat=digibutton-flat, DigiButton Flat Arrow=digibutton-flat-arrow';
	
	return $init;
}

/**
 * Modify the ContactForm 7 loader url
 *
 * @since 1.0
 */
function digitec_wpcf7_ajax_loader( $url ) {
	
	return PARENT_URL.'/images/loading.gif';
}




/**
 * Enqueue the scripts used on the front-end of the site
 *
 * @since 1.1
 */
function digitec_load_scripts() {

	$style_options = get_option( 'maven_style_options' );

	if( $style_options['global_style'] != 'default' ) {
		
		// Register the color style
	  wp_register_style( 'style-'.$style_options['global_style'], PARENT_URL.'/css/style-'.$style_options['global_style'].'.css', false, MAVEN_THEME_VERSION );
	  wp_enqueue_style( 'style-'.$style_options['global_style'] );
		
	}

	// Register jquery timers
  wp_register_script( 'jquery-timers', PARENT_URL.'/js/jquery.timers.js', array('jquery'), MAVEN_THEME_VERSION, true );
  
  // Register masonry
  wp_register_script( 'jquery-masonry', PARENT_URL.'/js/jquery.masonry.min.js', array('jquery'), MAVEN_THEME_VERSION, true );
  wp_enqueue_script( 'jquery-masonry' );
  
  // Load custom scripts
  wp_register_script( 'digitec', PARENT_URL.'/js/script.js', array('jquery', 'jquery-timers'), MAVEN_THEME_VERSION, true );
  wp_enqueue_script( 'digitec' );
  
  $general_options = get_option('maven_general_options');
  
  $project_width = 680;
  $project_height = 382;
  $highlight_color = '00FFFF';
  wp_localize_script( 'digitec', 'digitec_vars', array(
			'is_front_page' => is_front_page(),
			'post_type' => get_post_type(),
			'project_width' => $project_width,
			'project_height' => $project_height,
			'highlight_color' => $highlight_color,
			'slider_timer' => isset($general_options['featured_slider_timer']),
			'slider_timer_speed' => floatval($general_options['featured_slider_timer_speed']),
			'global_style' => $style_options['global_style']
		)
	);
}

/**
 * Add scripts to the footer
 *
 * @since 1.1.1
 */
function digitec_footer_scripts() {
	
	// Add masonry to the seach page
	if( is_search() ) {
	?>
	<script>
	jQuery( function(){
		jQuery( '.digitec-search-container' ).masonry({
		  itemSelector : '.digitec-search-block',
		  columnWidth : 480
		});	
	});
	</script>
	<?	
	}
	?>
	<script>
	jQuery( function(){
	
		// Main menu
		jQuery('.main-menu-container').find('.sub-menu').each( function(index) {
		
			var width = 0;
			var outer_width = 0;
			jQuery(this).children('li').each( function(index) {
				var w = jQuery(this).children('a').width();
				var outer_w = jQuery(this).children('a').outerWidth();
				if( w > width ) {
					width = w;
					outer_width = outer_w;
				}
			});
			jQuery(this).children('li').children('a').width(width);
			jQuery(this).width(outer_width);
			jQuery(this).children('li').children('ul').css('marginLeft', outer_width+'px');
			
		});	
	});
	</script>
	<?php
}

/**
 * Remove default actions
 *
 * @since 1.0
 */
function digitec_remove_default_post_actions() {
	
	// Remove the default header
	remove_action( 'maven_header', 'maven_do_header' );
	
	// Remove the default archive loop
	remove_action( 'maven_search_archive_loop', 'maven_archive_loop' );
	
	// Remove the default top archive navigation
	remove_action( 'maven_before_post_archive_loop', 'maven_top_archive_navigation' );
	remove_action( 'maven_before_project_archive_loop', 'maven_top_archive_navigation' );
	remove_action( 'maven_before_team_archive_loop', 'maven_top_archive_navigation' );
	remove_action( 'maven_before_search_archive_loop', 'maven_top_archive_navigation' );
	
	// Remove default post navigation.
	remove_action( 'maven_before_post', 'maven_top_single_navigation' );
	remove_action( 'maven_before_project', 'maven_top_single_navigation' );
	remove_action( 'maven_before_team', 'maven_top_single_navigation' );
	remove_action( 'maven_after_post', 'maven_bottom_single_navigation' );
	remove_action( 'maven_after_project', 'maven_bottom_single_navigation' );
	remove_action( 'maven_after_team', 'maven_bottom_single_navigation' );

	// Remove the default page title
	remove_action( 'maven_page_entry_title', 'maven_do_entry_title' );
	remove_action( 'maven_team_entry_title', 'maven_do_entry_title' );
	remove_action( 'maven_project_entry_title', 'maven_do_entry_title' );
	
	if( !is_single() ) { 
		remove_action( 'maven_after_project_entry_title', 'maven_entry_meta' );
		remove_action( 'maven_after_team_entry_title', 'maven_entry_meta' );
	}
	
	// Remove the default archive content
	remove_action( 'maven_project_archive_content', 'maven_archive_content' );
	remove_action( 'maven_team_archive_content', 'maven_archive_content' );

	// Remove the default featured image
	remove_action( 'maven_after_post_entry_title', 'maven_featured_image' );
	remove_action( 'maven_after_page_entry_title', 'maven_featured_image' );
	remove_action( 'maven_after_project_entry_title', 'maven_featured_image' );
	remove_action( 'maven_after_team_entry_title', 'maven_featured_image' );
	remove_action( 'maven_after_search_entry_title', 'maven_featured_image' );
	
	// Remove the default footer
	remove_action( 'maven_footer', 'maven_do_footer' );
}

/**
 * Add the header section
 *
 * @since 1.1.4
 */
function digitec_do_header() {
	?>
	<header id="siteHeader" class="clearfix">
		<div class="wrapper">

			<a id="logo" alt="<?php echo get_bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>"><?php maven_header_logo(); ?></a>
			
			<?php
			$args = array(
				'theme_location'		=> 'main-menu',
				'menu'							=> 'main-menu',  
				'menu_class'				=> 'main-menu clearfix',
				'container'					=> 'div',
				'container_class'		=> 'main-menu-container', 
				'fallback_cb'				=> 'main_menu_fallback'
			);
			
			// Add the menu
			wp_nav_menu( $args );
			?>

		</div>
	</header><!-- #siteHeader -->
	<?php
}

/**
 * Add a header image
 *
 * @since 1.0
 */
function digitec_after_header() {

	$featured_slider = sanitize_text_field( get_post_meta( get_the_ID(), '_digitec_featured_slider', true ) );
	if( $featured_slider == '') {

		global $style_id;
		$id = get_post_meta( $style_id, '_maven_style_header_image', true );
		$color =  sanitize_text_field( get_post_meta($style_id, '_maven_style_header_image_bg_color', true) );
		if( $id ) {
		?>
		<div id="header-image" class="clearfix"<?php if($color){ echo 'style="background-color:'.$color.';"'; }?>>
			<div class="wrapper">
				<?php echo wp_get_attachment_image( $id[0], 'header-image' ); ?>
			</div><!-- .wrapper -->
		</div><!-- #header-image -->
		<?php
		}
	} else {
	
		// Setup a featured slider
		$slider_blocks = explode( ',', $featured_slider );
		
		if( is_array($slider_blocks) ) {
		
			echo '<div class="header-image featured-slider">';
			
			$buttons = '';
			foreach( $slider_blocks as $i => $post_id ) {
				
				// Make sure there is actually a post
				$p = get_post( trim($post_id) );
				if( $p ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$imagea_array = wp_get_attachment_image_src( $image_id, 'slider-image' ); 
					$image = $imagea_array[0];
					$buttons .= '<a href="#featured-'.$i.'"></a>';
					echo '<div class="featured-slider-data" style="display:none;" id="featured-'.$i.'" image="'.$image.'">'.apply_filters( 'the_content', $p->post_content ).'</div>';
				}
			}
			
			// Add the container and buttons
			echo '<div class="featured-slider-container hover-anim">';	
			if( count($slider_blocks) > 1 ) {
				echo '<div class="featured-slider-controls featured-slider-controls-prev hover-anim-target"><a href="#" class="featured-slider-prev hover-anim"><span></span></a></div><div class="featured-slider-controls featured-slider-controls-next hover-anim-target"><a href="#" class="featured-slider-next hover-anim"><span></span></a></div>';
			}		
			echo '</div>';
			if( count($slider_blocks) > 1 ) {
				echo '<div class="featured-slider-buttons"><p class="clearfix">'.$buttons.'</p></div>';
			}
			echo '</div>';
			
		}
	}
}

/**
 * Add page titles
 *
 * @since 1.0
 */
function digitec_page_titles() {
	
	if( get_post_type() == 'page' ) {
		echo '<div class="entry-header clearfix">';						
		echo '<h1 class="entry-title">'.get_the_title().'</h1>	';
		$options = get_option( 'maven_general_options' );
		if( !isset($options['search_field']) ) {
			get_search_form();
		}						
		echo '</div>';
	}
}

/**
 * Add the featured image.
 *
 * @since 1.0
 */
function digitec_featured_image() {

	$size = ( get_m4c_image_size('featured-image') ) ? 'featured-image' : 'medium';
	$size = apply_filters( 'maven_featured_image', $size );
	
	$image = get_the_post_thumbnail( get_the_ID(), $size, array('class'=>'featured-image') );
	
	if( !$image ) {
		$att_ids = get_post_meta( get_the_ID(), '_maven_attachments', true );
		if( is_array($att_ids) ) {
			$image = get_m4c_attachment_image( $att_ids[0], $size, false, array('class'=>'featured-image') );
		}
	}
	if( $image ) {
		if( is_page() || is_single() ) {
			echo $image;
		} else {
			echo '<a class="hover-anim featured-image-link" href="'.get_permalink().'">'.$image.'<span class="digitec-plus-graphic"></span></a>';
		}
	}
}

/**
 * Add the footer.
 *
 * @since 1.0
 */
function digitec_footer() {
	$options = get_option( 'maven_general_options' );

	if( isset($options['footer_text_left']) ) {
		echo '<div id="footer-text-left">'.wpautop( stripslashes($options['footer_text_left']) ).'</div>';
	}
	if( isset($options['footer_text_right']) ) {
		echo '<div id="footer-text-right">'.wpautop( stripslashes($options['footer_text_right']) ).'</div>';
	}
}




/**
 * Add image sizes.
 *
 * @since 1.0
 */
if ( function_exists( 'add_image_size' ) ) { 

	// Create custom image sizes
	add_image_size( 'featured-image-full', 920, 180, true );
	add_image_size( 'header-image', 960, 150, true );
	add_image_size( 'slider-image', 960, 360, true );
	add_image_size( 'main-image', 680, 382, true );
	add_image_size( 'search-image', 440, 180, true );
}

/**
 * Output the comments list
 *
 * @since 1.0
 */
function digitec_comment( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;
	
	// Get the default avatar
	$default_avatar = get_maven_default_avatar_src( 'avatar' );

	switch ( $comment->comment_type ) :
		case '' : ?>
    
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <table id="comment-<?php comment_ID(); ?>" class="comment-container clearfix">
        	<tr>
	          <td class="comment-avatar">
						<?php echo get_avatar( $comment, 80, $default_avatar ); ?>
            </td><!-- .comment-avatar -->  
            
            <td class="comment-arrow"><span></span></td> 

	        <?php if ( $comment->comment_approved == '0' ) : ?>
	        
	          <td class="comment-data comment-onhold">
	          	<p class="comment-author"><?php echo get_comment_author_link(); ?></p>
	            <p class="comment-awaiting-moderation"><?php _e( '* Your comment is awaiting moderation.', 'digitec' ); ?></p>
              <div class="comment-body"><?php comment_text(); ?></div>
              <p class="comment-date"><?php echo get_comment_date( get_option('date_format') ).' at '.get_comment_date( get_option('time_format') ); ?></p>
            </td><!-- #comment-data -->
                
          <?php else: ?>

	          <td class="comment-data">
							<p class="comment-author"><?php echo get_comment_author_link(); ?></p>
              <div class="comment-body"><?php comment_text(); ?></div>
              <p class="comment-date"><?php echo get_comment_date( get_option('date_format') ).' at '.get_comment_date( get_option('time_format') ); ?></p>
							<?php
							if( comments_open() ) {
								comment_reply_link( array_merge($args, array('depth' => 1, 'max_depth' => 2, 'reply_text' => __( 'Reply', 'digitec' ))) );
							}
							?>
            </td><!-- #comment-data -->
                
					<?php endif; ?>
        	</tr>
        </table><!-- #comment-##  -->

		<?php break;
		
		case 'pingback'  :
		case 'trackback' : ?>
		
    		<li class="post pingback">
					<p class="pingback"><?php _e( 'Pingback:', 'digitec' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'digitec' ), ' ' ); ?></p>
		<?php break;
			
	endswitch;
}
