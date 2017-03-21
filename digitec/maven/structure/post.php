<?php
/**
 * Adds post structures.
 *
 * @category   Maven
 * @package    Structure
 * @subpackage Header
 * @author     MetaphorCreations
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://www.metaphorcreations.com/themes/maven
 */
 
 
 

add_action( 'pre_get_posts', 'maven_default_post_actions' );
/**
 * Setup the default actions.
 *
 * @since 1.0
 */
function maven_default_post_actions() {
	
	$post_types = get_maven_global_options_post_types( false, true );
	
	$post_types = apply_filters( 'maven_default_post_actions_post_types', $post_types );

	foreach( $post_types as $pt ) {
	
		// Add the archive loop
		add_action( 'maven_'.$pt.'_archive_loop', 'maven_archive_loop' );
		
		// Add the entry title
		add_action( 'maven_'.$pt.'_entry_title', 'maven_do_entry_title' );
		
		// Add the entry meta
		add_action( 'maven_after_'.$pt.'_entry_title', 'maven_entry_meta' );
		
		// Add the featured image
		add_action( 'maven_after_'.$pt.'_entry_title', 'maven_featured_image' );
		
		// Add the content
		add_action( 'maven_'.$pt.'_content', 'maven_content' );
		
		// Add the archive content
		add_action( 'maven_'.$pt.'_archive_content', 'maven_archive_content' );
		
		// Add archive navigation
		add_action( 'maven_before_'.$pt.'_archive_loop', 'maven_top_archive_navigation' );
		add_action( 'maven_after_'.$pt.'_archive_loop', 'maven_bottom_archive_navigation' );
		
		// Add post navigation
		add_action( 'maven_before_'.$pt, 'maven_top_single_navigation' );
		add_action( 'maven_after_'.$pt, 'maven_bottom_single_navigation' );
	
		// Add content pagination
		add_action( 'maven_after_'.$pt.'_content', 'maven_content_pagination' );
		
		if( $pt != 'search' ) {
		
			// Add comment count and social links
			add_action( 'maven_after_'.$pt.'_content_container', 'maven_add_social_links' );
			
			// Add comment forms
			add_action( 'maven_after_'.$pt.'_content_container', 'maven_add_comment_form' );
		}
		
		// Add additional content
		if( current_theme_supports('additional-content') && $pt != 'search' ) {
			
			add_action( 'maven_before_'.$pt.'_primary_secondary', 'maven_additional_content_above_outside' );
			add_action( 'maven_before_'.$pt.'_content_container', 'maven_additional_content_above_inside' );
			add_action( 'maven_after_'.$pt.'_primary_secondary', 'maven_additional_content_below_outside' );
			add_action( 'maven_after_'.$pt.'_content_container', 'maven_additional_content_below_inside', 9 );
		}
	}
}




/**
 * Add the archive loop
 *
 * @since 1.0
 */
function maven_archive_loop( $post_type ) {
	
	global $wp_query;
	
	if ( have_posts() ) :
	
	// Start the Loop
	while ( have_posts() ) : the_post();
		
		// Show the contents via the loop
		maven_loop( $post_type );
		
	endwhile;
	
	else :
	endif;
}

/**
 * Add the entry title
 *
 * @since 1.0
 */
function maven_do_entry_title() {
	if( is_single() || is_page() ) {
		echo '<h1 class="entry-title">'.get_the_title().'</h1>';
	} else {
		echo '<h1 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';
	}
}

/**
 * Add the entry meta
 *
 * @since 1.0
 */
function maven_entry_meta() {
	
	global $post;
	
	$post_type = get_post_type();
	$options = get_option( 'maven_general_options' );
	$show_date = ( isset($options['show_date']) ) ? isset($options['show_date'][$post_type]) : false;
	$show_author = ( isset($options['show_author']) ) ? isset($options['show_author'][$post_type]) : false;
	$show_categories = ( isset($options['show_categories']) ) ? isset($options['show_categories'][$post_type]) : false;
	$show_tags = ( isset($options['show_tags']) ) ? isset($options['show_tags'][$post_type]) : false;
	$show_comments = ( isset($options['allow_comments']) ) ? isset($options['allow_comments'][$post_type]) : false;
	?>
	
	<?php if( $show_date || $show_author || $show_categories || $show_tags ) { ?>
		<p class="entry-meta">
			<?php
			$meta_order = array( 'author', 'date', 'categories', 'tags', 'comments' );
			$meta_order = apply_filters( 'maven_meta_order', $meta_order );
			
			foreach( $meta_order as $meta ) {
				
				switch( $meta ) {
				
					case 'author':
						// Show the author
						if( $show_author ) {
							echo '<span class="entry-author entry-utility">';
							$prefix = 'By: ';
							$prefix = apply_filters( 'maven_author_prefix', $prefix );
							$author_link = get_the_author_link();
							printf( __( '<span class="%1$s">%2$s</span> %3$s', 'digitec' ), 'entry-utility-prep', $prefix, $author_link );
							echo '</span> ';
						}
						break;
					
					case 'date':
						// Show the date
						if( $show_date ) {
							echo '<span class="entry-date  entry-utility">';
							$prefix = 'Date: ';
							$prefix = apply_filters( 'maven_date_prefix', $prefix );
							$date = get_the_time( get_option('date_format') );
							printf( __( '<span class="%1$s">%2$s</span> %3$s', 'digitec' ), 'entry-utility-prep', $prefix, $date );
							echo '</span> ';
						}
						break;

					case 'categories':
						// Show the categories
						if( $show_categories ) {
							$categories_list = get_the_category_list( __( ', ', 'digitec' ) );
							if ( $categories_list ) {
								echo '<span class="entry-cats entry-utility">';
								$prefix = 'Categories:';
								$prefix = apply_filters( 'maven_category_prefix', $prefix );
								printf( __( '<span class="%1$s">%2$s</span> %3$s', 'digitec' ), 'entry-utility-prep', $prefix, $categories_list );
								echo '</span> ';
							}
						}
						break;
						
					case 'tags':
						// Show the tags
						if( $show_tags ) {
							$tags_list = get_the_tag_list( '', __( ', ', 'digitec' ), '' );
							if ( $tags_list ) {
								echo '<span class="entry-tags entry-utility">';
								$prefix = 'Tags: ';
								$prefix = apply_filters( 'maven_tags_prefix', $prefix );
								printf( __( '<span class="%1$s">%2$s</span> %3$s', 'digitec' ), 'entry-utility-prep', $prefix, $tags_list );
								echo '</span> ';
							}
						}
						break;
						
					case 'comments':
						// Show the tags
						if( $show_comments && $post->comment_status=='open' ) {
							echo '<span class="entry-comments entry-utility">';
							$prefix = 'Comments: ';
							$prefix = '<span class="entry-utility-prep">'.apply_filters( 'maven_comments_prefix', $prefix ).'</span>';
							$comments_link = comments_popup_link( $prefix.'0', $prefix.'1', $prefix.'%', 'comments-link', '');
							echo '</span> ';
						}
						break;
				}
			}
			?>
		</p>
		<?php
	}
}

/**
 * Add the featured image.
 *
 * @since 1.0
 */
function maven_featured_image() {

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
			echo '<a href="'.get_permalink().'">'.$image.'</a>';
		}
	}
}

/**
 * Add the content
 *
 * @since 1.0
 */
function maven_content() {
	the_content();
}

/**
 * Add the archive content
 *
 * @since 1.0
 */
function maven_archive_content() {
	$options = get_option( 'maven_general_options' );
	$show_excerpt = ( isset($options['show_excerpt']) ) ? $options['show_excerpt'] : 'excerpt';

	if( $show_excerpt == 'excerpt' ) {
		
		// Show the excerpt
		the_excerpt();
		
		// Add a readmore link
		$readmore = '<a class="readmore" href="'.get_permalink().'"> Read More...</a>';
		$readmore = apply_filters( 'maven_readmore_link', $readmore );
		echo $readmore;
	} else {
	
		// Show the content
		the_content();
		$viewpost = '<a class="readmore" href="'.get_permalink().'"> View Post</a>';
		$viewpost = apply_filters( 'maven_viewpost_link', $viewpost );
		echo $viewpost;
	}
}

/**
 * Add content pagination
 *
 * @since 1.0
 */
function maven_content_pagination() {
	
	if( is_single() ) {
	
		// Display page links
		$args = array(
			'before' => '<div class="page-link"><span>' . __( 'Page:', 'digitec' ) . '</span>',
			'after' => '</div>'
		);
		maven_link_pages( $args );
	}
}

/**
 * Add archive navigation
 *
 * @since 1.0
 */
function maven_top_archive_navigation() {
	$options = get_option( 'maven_general_options' );
	$paginate = ( isset($options['archive_navigation']) ) ? isset($options['archive_navigation']['paginate']) : false;
	$structure = get_option( 'permalink_structure' );	
	if( !empty($structure) && $paginate ) {
		maven_pagination( 'top' );	
	} else {
		maven_content_nav( 'top' );
	}	
}
function maven_bottom_archive_navigation() {
	
	$options = get_option( 'maven_general_options' );
	$paginate = ( isset($options['archive_navigation']) ) ? isset($options['archive_navigation']['paginate']) : false;
	$structure = get_option( 'permalink_structure' );	
	if( !empty($structure) && $paginate ) {
		maven_pagination( 'bottom' );	
	} else {
		maven_content_nav( 'bottom' );
	}
}

/**
 * Add post navigation
 *
 * @since 1.0
 */
function maven_top_single_navigation() {
	if( is_single() ) {
		maven_single_nav( 'top' );
	}
}
function maven_bottom_single_navigation() {
	if( is_single() ) {
		maven_single_nav( 'bottom' );
	}
}

/**
 * Add extra content above
 *
 * @since 1.0
 */
function maven_additional_content_above_outside() {
	$enabled = get_post_meta( get_the_ID(), '_maven_above_content_enabled', true );
	$position = get_post_meta( get_the_ID(), '_maven_above_content_position', true );
	
	if( $enabled && $position == 'outside' ) {
		$content = get_post_meta( get_the_ID(), '_maven_above_content', true );
		if( $content ) {
			$borders = get_post_meta( get_the_ID(), '_maven_above_content_borders', true );
			$class = ( isset($borders['top']) ) ? ' border-top' : '';
			$class .= ( isset($borders['bottom']) ) ? ' border-bottom' : $class;
			echo '<div id="above-primary-secondary" class="'.$class.'">'.wpautop( do_shortcode($content) ).'</div>';
		}
	}
}
function maven_additional_content_above_inside() {
	$enabled = get_post_meta( get_the_ID(), '_maven_above_content_enabled', true );
	$position = get_post_meta( get_the_ID(), '_maven_above_content_position', true );
	
	if( $enabled && $position == 'inside' ) {
		$content = get_post_meta( get_the_ID(), '_maven_above_content', true );
		if( $content ) {
			$borders = get_post_meta( get_the_ID(), '_maven_above_content_borders', true );
			$class = ( isset($borders['top']) ) ? ' border-top' : '';
			$class .= ( isset($borders['bottom']) ) ? ' border-bottom' : $class;
			echo '<div id="above-content" class="'.$class.'">'.wpautop( do_shortcode($content) ).'</div>';
		}
	}
}

/**
 * Add extra content below
 *
 * @since 1.0
 */
function maven_additional_content_below_outside() {
	$enabled = get_post_meta( get_the_ID(), '_maven_below_content_enabled', true );
	$position = get_post_meta( get_the_ID(), '_maven_below_content_position', true );

	if( $enabled && $position == 'outside' ) {
		$content = get_post_meta( get_the_ID(), '_maven_below_content', true );
		if( $content ) {
			$borders = get_post_meta( get_the_ID(), '_maven_below_content_borders', true );
			$class = ( isset($borders['top']) ) ? ' border-top' : '';
			$class .= ( isset($borders['bottom']) ) ? ' border-bottom' : $class;
			echo '<div id="below-primary-secondary" class="'.$class.'">'.wpautop( do_shortcode($content) ).'</div>';
		}
	}
}
function maven_additional_content_below_inside() {
	$enabled = get_post_meta( get_the_ID(), '_maven_below_content_enabled', true );
	$position = get_post_meta( get_the_ID(), '_maven_below_content_position', true );
	
	if( $enabled && $position == 'inside' ) {
		$content = get_post_meta( get_the_ID(), '_maven_below_content', true );
		if( $content ) {
			$borders = get_post_meta( get_the_ID(), '_maven_below_content_borders', true );
			$class = ( isset($borders['top']) ) ? ' border-top' : '';
			$class .= ( isset($borders['bottom']) ) ? ' border-bottom' : $class;
			echo '<div id="below-content" class="'.$class.'">'.wpautop( do_shortcode($content) ).'</div>';
		}
	}
}

/**
 * Add comment count and social links
 *
 * @since 1.0
 */
function maven_add_social_links( $post_type ) {
	
	if( !is_home() ) {
	
		global $post;
		
		// Get the post type
		$post_type = get_post_type( get_the_ID() );
		
		$general_options = get_option( 'maven_general_options' );
		$social_options = get_option( 'maven_social_options' );
		
		if( $general_options || $social_options  ) {
			
			$wrapper_start = false;
	
				// Add a coment count & link
				if( $general_options ) {
					if( isset($general_options['allow_comments'][$post_type]) && $post->comment_status=='open' ) {
						
						$wrapper_start = true;
						echo '<div id="social-links-container" class="clearfix">';
						
						comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post');
					}
				}
				
				// Add Twitter & Facebook share links
				if( $social_options ) {
					if( isset($social_options['twitter_share'][$post_type]) || isset($social_options['facebook_share'][$post_type]) ) {
						
						if( $wrapper_start == false ) {	
							$wrapper_start = true;
							echo '<div id="social-links-container" class="clearfix">';
						}
									
						$url= urlencode( get_permalink() );
		
						echo '<div id="social-share-info">';
							echo '<p class="social-share-title">Share this</p>';
							if( isset($social_options['twitter_share'][$post_type]) ) {
								$prefix = sanitize_text_field($social_options['twitter_share_prefix']);
								if( $prefix != '' ) {
									$prefix .= ' ';
								}
								$text = urlencode($prefix.'"'.get_the_title().'"');
								echo '<a class="twitter-link social-link hover-anim" href="https://twitter.com/intent/tweet?text='.$text.'&amp;url='.$url.'"><span></span></a>';
							}
							if( isset($social_options['facebook_share'][$post_type]) ) {
								$title = urlencode( get_the_title() );
								$summary= urlencode( get_the_excerpt() );
								$image_id = get_post_thumbnail_id();
								$image = wp_get_attachment_image_src( $image_id, 'post-thumbnail' );
								if( !$image ) {
									$att_ids = get_post_meta( get_the_ID(), '_maven_attachments', true );
									if( is_array($att_ids) ) {
										$image = get_m4c_attachment_image_src( $att_ids[0], 'post-thumbnail' );
									}
								}
								if( $image ) {
									$image = urlencode( $image[0] );
								}	
								?>
								<a class="facebook-link social-link hover-anim" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)"><span></span></a>
								<?php
							}
						echo '</div>';
					}
				}
				
			if( $wrapper_start == true ) {
				echo '</div>';
			}
		}
	}
}

/**
 * Add comment forms
 *
 * @since 1.0
 */
function maven_add_comment_form( $post_type ) {
	
	global $post;

	// If this is a page template, make sure the
	// post type is set to page
	if ( is_page_template() ) {
		$post_type = 'page';
	}
	
	$options = get_option( 'maven_general_options' );
	//echo $post_type;
	if( $options ) {
		if( isset($options['allow_comments'][$post_type]) && $post->comment_status=='open' ) {
			?>
			<div id="comment-respond-container">
				<?php 
				do_action( 'maven_before_'.$post_type.'_comments', $post_type );
				comments_template( '', true );
				do_action( 'maven_after_'.$post_type.'_comments', $post_type );
				?>
			</div><!-- .below-post -->
			<?php
		}
	}
}

add_action( 'maven_before_search_archive_loop', 'maven_search_title' );
/**
 * Add an archive title
 *
 * @since 1.0
 */
function maven_search_title() {
	global $wp_query;
	?>
	<header class="page-header">
		<h1 class="page-title">
		<?php printf( __('Results for "%s"', 'digitec'), '<span class="search-title-meta">'.get_search_query().'</span>' ); ?>
		</h1>
	</header>
	<?php
}

add_action( 'maven_before_post_archive_loop', 'maven_archive_title' );
/**
 * Add an archive title
 *
 * @since 1.0
 */
function maven_archive_title() {
	if( is_archive() ) {
		global $wp_query;
		$separator = apply_filters( 'maven_archive_title_separator', ' / ' );
		$separator = '<span class="archive-title-separator">'.$separator.'</span>';
		?>
		<header class="page-header">
			<h1 class="page-title">
			<?php
	    if ( is_day() ) {
		  	printf( __('Daily Archives%1$s%2$s', 'digitec'), $separator, '<span class="archive-title-meta">'.get_the_date().'</span>' );
		  } elseif ( is_month() ) {
	   		printf( __('Monthly Archives%1$s%2$s', 'digitec', 'digitec'), $separator, '<span class="archive-title-meta">'.get_the_date( 'F Y' ).'</span>' );
	    } elseif ( is_year() ) {
	      printf( __('Yearly Archives%1$s%2$s', 'digitec'), $separator, '<span class="archive-title-meta">'.get_the_date( 'Y' ).'</span>' );
	    } elseif ( is_category() ) {
	    	printf( __('Category Archives%1$s%2$s', 'digitec'), $separator, '<span class="archive-title-meta">'.single_cat_title( '', false ).'</span>' );
	    } elseif ( is_tag() ) {
	    	printf( __('Tag Archives%1$s%2$s', 'digitec'), $separator, '<span class="archive-title-meta">'.single_tag_title( '', false ).'</span>' );
	    } elseif ( is_search() ) {
	   		printf( __('Search Results%1$s%2$s', 'digitec'), $separator, '<span class="archive-title-meta">'.get_search_query().'</span>' );
	   	} else {
	   		$args=array(
				  'name' => $wp_query->queried_object->taxonomy
				);
				$output = 'objects'; // or objects
				$taxonomies=get_taxonomies($args,$output); 
				if  ($taxonomies) {
				  foreach ($taxonomies  as $taxonomy ) {
				    $term = $taxonomy->labels->name;
				  }
				}
				if( $term ) {  
		   		printf( __('%1$s Archives%2$s%3$s', 'digitec'), $term, $separator, '<span class="archive-title-meta">'.$wp_query->queried_object->name.'</span>' );
		   	}
	   	}
	   	?>
			</h1>
		</header>
		<?php
	}
}

add_action( 'maven_comments_password', 'maven_do_comments_password' );
/**
 * Echo the password phrase.
 *
 * @since 1.0
 */
function maven_do_comments_password() {
	?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'digitec' ); ?></p>
	<?php
}




add_action( 'maven_comments_loop', 'maven_do_comments_loop' );
/**
 * Print the entry title.
 *
 * @since 1.0
 */
function maven_do_comments_loop() {
	?>
	<div id="commentscontainer">
		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'digitec_comment' ) ); ?>
		</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
			<nav id="comment-nav">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'digitec' ); ?></h1>
			<?php
			// Get the user defined page structure
			$structure = get_option( 'permalink_structure' );
			$format = empty( $structure ) ? '&page=%#%' : 'page/%#%/';
			$args = array(
			'prev_text' => __( 'Prev', 'digitec' ),
			'next_text' => __( 'Next', 'digitec' ),
			'type' => 'list',
			'echo' => false
			);
			
			// Apply filter & merge with defualts
			$args = apply_filters( 'maven_comment_pagination_args', $args );
			echo apply_filters( 'maven_comment_pagination', paginate_comments_links( $args ) );
			?>
			</nav>
		<?php } ?>
	</div>
	<?php
}
