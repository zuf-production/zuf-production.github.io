<?php
/**
 * Project specific theme code
 *
 * The code that specifically deals with
 * projects goes here
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Add the parent title to the top of projects - @since 1.0
add_action( 'maven_before_project_primary_secondary', 'digitec_project_parent_title', 5 );

// Modify the entry title - @since 1.0
add_action( 'maven_project_entry_title', 'digitec_project_entry_title' );

// Add page content to the top of blog pages - @since 1.0
add_action( 'maven_before_project_primary_secondary', 'digitec_project_navigation' );

// Set the project archive featured images - @since 1.0
add_action( 'maven_before_project_entry_header', 'digitec_before_project_entry_header' );

// Add the featured image - @since 1.0
add_action( 'maven_after_project_entry_title', 'digitec_project_featured_image' );

// Add the project block featured image - @since 1.0
add_action( 'maven_before_project_block_entry_header', 'digitec_before_project_block_entry_header' );

// Add the project block entry title - @since 1.0
add_action( 'maven_project_block_entry_title', 'digitec_project_block_entry_title' );




/**
 * Add the parent title to the top of projects
 *
 * @since 1.0
 */
function digitec_project_parent_title() {
	
	if( is_single() ) {
		$portfolio_pages = get_pages(array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_portfolio.php'
		));
		if( ! empty($portfolio_pages) ) {
			$portfolio_id = intval($portfolio_pages[0]->ID);
			echo '<div class="entry-header clearfix">';						
			echo '<h1 class="entry-title">'.get_the_title($portfolio_id).'</h1>	';
			$options = get_option( 'maven_general_options' );
			if( !isset($options['search_field']) ) {
				get_search_form();
			}						
			echo '</div>';
		}
	}
}

/**
 * Modify the entry title
 *
 * @since 1.0
 */
function digitec_project_entry_title() {
	if( is_single() ) {
		echo '<h1 class="entry-title">'.get_the_title().'<span class="digitec-project-count"></span></h1>';
	} else {
		echo '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
	}
}

/**
 * Add page content to the top of blog pages
 *
 * @since 1.0
 */
function digitec_project_navigation() {
	
	if( is_single() ) {
	
		// Get the button labels
		$options = get_option( 'maven_general_options' );
		if( $options ) {
			$home = ( isset($options['project_single_home']) ) ? sanitize_text_field( $options['project_single_home'] ) : __( 'Work home', 'digitec' );
			$prev = ( isset($options['project_single_prev']) ) ? sanitize_text_field( $options['project_single_prev'] ) : __( 'Prev work', 'digitec' );
			$next = ( isset($options['project_single_next']) ) ? sanitize_text_field( $options['project_single_next'] ) : __( 'Next work', 'digitec' );
		} else {
			$home = __( 'Work home', 'digitec' );
			$prev = __( 'Prev work', 'digitec' );
			$next = __( 'Next work', 'digitec' );
		}
	
		$portfolio_pages = get_pages( array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_portfolio.php'
		));
		if( !empty($portfolio_pages) ) {
			$portfolio_id = intval($portfolio_pages[0]->ID);
		}
		
		// Get the previous post
		$prev_post = get_previous_post();
		if( empty( $prev_post ) ) {
			$p = get_posts( array(
		    'post_type' => 'project',
		    'numberposts' => 1,
		    'order' => 'DESC'
			));
			$prev_post = $p[0];
		}
		
		// Get the previous post
		$next_post = get_next_post();
		if( empty( $next_post ) ) {
			$p = get_posts( array(
		    'post_type' => 'project',
		    'numberposts' => 1,
		    'order' => 'ASC'
			));
			$next_post = $p[0];
		}

		if ( !empty($prev_post) || !empty($next_post) ) {
		?>
		<nav id="single-nav-top" class="single-nav clearfix">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'digitec' ); ?></h3>	
			
			<span class="nav-previous-container">
			<?php if ( !empty( $next_post ) ) : ?>
				<span class="nav-previous"><a href="<?php echo get_permalink($next_post->ID); ?>" class="digibutton"><i class="icon-arrow-left icon-arrow"><span></span></i><?php echo $prev; ?></a></span>
			<?php else : ?>
				<span class="nav-previous"><span class="digibutton"><i class="icon-arrow-left icon-arrow"><span></span></i><?php echo $prev; ?></span></span>
			<?php endif; ?>
			</span><!-- .nav-previous-container -->
			
			<span class="nav-next-container">
			<?php if ( !empty( $prev_post ) ) : ?>
				<span class="nav-next"><a href="<?php echo get_permalink($prev_post->ID); ?>" class="digibutton"><?php echo $next; ?><i class="icon-arrow-right icon-arrow"><span></span></i></a></span>
			<?php else : ?>	
				<span class="nav-next"><span class="digibutton"><?php echo $next; ?><i class="icon-arrow-right icon-arrow"><span></span></i></span></span>
			<?php endif; ?>
			</span><!-- .nav-next-container -->
			
			<?php
			if( ! empty($portfolio_pages) ) { ?>
				<span class="nav-home-container">
					<span class="nav-home"><a href="<?php echo get_permalink($portfolio_id); ?>" class="digibutton"><?php echo $home; ?><i class="icon-arrow-up icon-arrow"><span></span></i></a></span>
				</span><!-- .nav-next-container -->
				<?php
			} 
			?>
		</nav><!-- #nav-single -->
		<?php
		}
	}
}

/**
 * Set the project archive featured images
 *
 * @since 1.0
 */
function digitec_before_project_entry_header() {
	if( !is_single() ) {
		$image = get_the_post_thumbnail();
		if( !$image ) {
			$att_ids = get_post_meta( get_the_ID(), '_maven_attachments', true );
			if( is_array($att_ids) ) {
				$image = get_m4c_attachment_image( $att_ids[0], 'post-thumbnail' );
			}
		}
		echo '<a class="hover-anim post-thumbnail-link" href="'.get_permalink().'">'.$image.'<span class="digitec-plus-graphic"></span></a>';
	}
}

/**
 * Add the featured image
 *
 * @since 1.0
 */
function digitec_project_featured_image() {
	if( is_single() ) {
		
		$att_ids = get_post_meta( get_the_ID(), '_maven_attachments', true );
		
		if( is_array($att_ids) ) {
		
			echo '<div class="featured-image project-slider hover-anim">';
			foreach( $att_ids as $i => $att_id ) {
			
				$attachment = get_post( $att_id );
				$mime = get_post_mime_type( $att_id );
				$image = '';
				$path = '';
				
				switch ( $mime ) {
					case 'image/jpeg':
					case 'image/png':
						$imagea_array = wp_get_attachment_image_src( $att_id, 'main-image' );
						$image = $imagea_array[0];
						break;
					
					case 'audio/mpeg':
						// Get the poster image
						$image_id = get_post_meta( $att_id, '_attachment_poster_image', true );
						$default = ( !$image_id || $image_id=='none' ) ? true : false;
						$imagea_array = ( $default ) ? get_m4c_default_audio_image_src( 'main-image' ) : wp_get_attachment_image_src( $image_id, 'main-image' );
						$image = $imagea_array[0];
						$path = $attachment->guid;
						break;
			
					case 'video/mp4':
					case 'video/m4v':
						// Get the poster image
						$image_id = get_post_meta( $att_id, '_attachment_poster_image', true );
						$default = ( !$image_id || $image_id=='none' ) ? true : false;
						$imagea_array = ( $default ) ? get_m4c_default_video_image_src( 'main-image' ) : wp_get_attachment_image_src( $image_id, 'main-image' );
						$image = $imagea_array[0];
						$path = $attachment->guid;
						break;
					
					case 'vimeo':
						// Create a timthumb image
						$path = substr( $attachment->guid, 7 );
						//return get_m4c_timthumb_image( $thumb, $size, $attr );
						break;
					
					case 'youtube':
						// Create a timthumb image
						$path = substr( $attachment->guid, 7 );
						//return get_m4c_timthumb_image( $thumb, $size, $attr );
						break;
					}
					
					echo '<div class="project-slider-data" style="display:none;" mime_type="'.$mime.'" image="'.$image.'" path="'.$path.'"></div>';
					//echo '<input type="hidden" mime_type="'.$mime.'" image="'.$image.'" path="'.$path.'" />';
				}
				
			echo '<div class="project-slider-container"></div>';
			
			if( count($att_ids) > 1 ) {
				echo '<div class="project-slider-controls project-slider-controls-prev hover-anim-target"><a href="#" class="project-slider-prev hover-anim"><span></span></a></div><div class="project-slider-controls project-slider-controls-next hover-anim-target"><a href="#" class="project-slider-next hover-anim"><span></span></a></div>';
			}

			echo '</div>';
			
		} else {
			$image_id = get_post_thumbnail_id();
			if( $image_id ) {
				echo wp_get_attachment_image( $image_id, 'main-image', false, array('class'=>'featured-image') );
			}
		}
	}
}

/**
 * Add the project block featured image
 *
 * @since 1.0
 */
function digitec_before_project_block_entry_header() {
	
	$image = get_the_post_thumbnail();
	if( !$image ) {
		$att_ids = get_post_meta( get_the_ID(), '_maven_attachments', true );
		if( is_array($att_ids) ) {
			$image = get_m4c_attachment_image( $att_ids[0], 'post-thumbnail' );
		}
	}
	if( $image ) {
		echo '<a class="hover-anim post-thumbnail-link" href="'.get_permalink().'">'.$image.'<span class="digitec-plus-graphic"></span></a>';
	}
}

/**
 * Add the project block entry title
 *
 * @since 1.0
 */
function digitec_project_block_entry_title() {
	echo '<h1 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';	
}
