<?php
/**
 * Team specific theme code
 *
 * The code that specifically deals with
 * team members goes here
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Add the parent title to the top of team members - @since 1.0
add_action( 'maven_before_team_primary_secondary', 'digitec_team_parent_title', 5 );

// Add navigation to the top of team member pages - @since 1.0
add_action( 'maven_before_team_primary_secondary', 'digitec_team_navigation' );

// Set the team archive featured images - @since 1.0
add_action( 'maven_before_team_entry_header', 'digitec_before_team_entry_header' );

// Ad the team entry title - @since 1.0
add_action( 'maven_team_entry_title', 'digitec_team_entry_title' );

// Set the team archive featured images - @since 1.0
add_action( 'maven_after_team_entry_title', 'digitec_team_featured_image' );

// Add the team member archive content - @since 1.0
add_action( 'maven_team_archive_content', 'digitec_team_archive_content' );

// Add the team member title - @since 1.0
add_action( 'maven_team_content', 'digitec_team_content' );

// Add the team block featured image - @since 1.0
add_action( 'maven_before_team_block_entry_header', 'digitec_before_team_block_entry_header' );

// Add the team block entry title - @since 1.0
add_action( 'maven_team_block_entry_title', 'digitec_team_block_entry_title' );

// Add the team block entry content - @since 1.0
add_action( 'maven_team_block_archive_content', 'digitec_team_block_archive_content' );

// Add custom content to the sidebar - @since 1.0
add_action( 'maven_before_sidebar', 'digitec_before_sidebar' );

// Clear the archive blocks - @since 1.1.5
add_action( 'maven_after_team', 'digitec_after_team' );




/* Additional functions

* digitec_team_excerpt_more // Add custom excerpt mores - @since 1.0
* digitec_team_excerpt_length // Add custom excerpt lengths - @since 1.0
* digitec_team_post_excerpt_length // Add custom excerpt lengths - @since 1.0

*/




/**
 * Add the parent title to the top of team members
 *
 * @since 1.0
 */
function digitec_team_parent_title() {
	
	if( is_single() ) {
		$team_pages = get_pages(array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_team.php'
		));
		if( ! empty($team_pages) ) {
			$team_id = intval($team_pages[0]->ID);
			echo '<div class="entry-header clearfix">';						
			echo '<h1 class="entry-title">'.get_the_title($team_id).'</h1>	';
			$options = get_option( 'maven_general_options' );
			if( !isset($options['search_field']) ) {
				get_search_form();
			}						
			echo '</div>';
		}
	}
}

/**
 * Add navigation to the top of team member pages
 *
 * @since 1.0
 */
function digitec_team_navigation() {
	
	if( is_single() ) {
	
		// Get the button labels
		$options = get_option( 'maven_general_options' );
		if( $options ) {
			$home = ( isset($options['team_single_home']) ) ? sanitize_text_field( $options['team_single_home'] ) : __( 'Team home', 'digitec' );
			$prev = ( isset($options['team_single_prev']) ) ? sanitize_text_field( $options['team_single_prev'] ) : __( 'Prev member', 'digitec' );
			$next = ( isset($options['team_single_next']) ) ? sanitize_text_field( $options['team_single_next'] ) : __( 'Next member', 'digitec' );
		} else {
			$home = __( 'Team home', 'digitec' );
			$prev = __( 'Prev member', 'digitec' );
			$next = __( 'Next member', 'digitec' );
		}
	
		$team_pages = get_pages( array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_team.php'
		));
		if( ! empty($team_pages) ) {
			$team_id = intval($team_pages[0]->ID);
		}

		// Get the previous post
		$prev_post = get_previous_post();
		if( empty( $prev_post ) ) {
			$p = get_posts( array(
		    'post_type' => 'team',
		    'numberposts' => 1,
		    'order' => 'DESC'
			));
			$prev_post = $p[0];
		}
		
		// Get the previous post
		$next_post = get_next_post();
		if( empty( $next_post ) ) {
			$p = get_posts( array(
		    'post_type' => 'team',
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
			if( ! empty($team_pages) ) { ?>
				<span class="nav-home-container">
					<span class="nav-home"><a href="<?php echo get_permalink($team_id); ?>" class="digibutton"><?php echo $home; ?><i class="icon-arrow-up icon-arrow"><span></span></i></a></span>
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
 * Set the team archive featured images
 *
 * @since 1.0
 */
function digitec_before_team_entry_header() {
	if( !is_single() ) {
		$image = get_the_post_thumbnail();
		echo '<a class="hover-anim team-thumbnail-link" href="'.get_permalink().'">'.$image.'<span class="digitec-plus-graphic"></span></a>';
	}
}

/**
 * Ad the team entry title
 *
 * @since 1.0
 */
function digitec_team_entry_title() {
	if( is_single() ) {
		echo '<h1 class="entry-title">'.get_the_title().'</h1>';
	} else {
		
		$twitter = esc_url( get_post_meta(get_the_ID(), '_digitec_member_twitter', true) );
		$facebook = esc_url( get_post_meta(get_the_ID(), '_digitec_member_facebook', true) );
		$google = esc_url( get_post_meta(get_the_ID(), '_digitec_member_google', true) );
		$linkedin = esc_url( get_post_meta(get_the_ID(), '_digitec_member_linkedin', true) );
		$target = get_post_meta( get_the_ID(), '_digitec_member_link_target', true ) ? ' target="_blank"' : '';

		echo '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
		
		// Add Social Info
		if( $twitter != '' || $facebook != '' || $google != '' || $linkedin != '' ) {
			echo '<div class="team-member-social-info">';
			if( $twitter != '' ) {
				echo '<a class="twitter-link-small social-link-small hover-anim" href="'.$twitter.'"'.$target.'><span></span></a>';
			}
			if( $facebook != '' ) {
				echo '<a class="facebook-link-small social-link-small hover-anim" href="'.$facebook.'"'.$target.'><span></span></a>';
			}
			if( $google != '' ) {
				echo '<a class="google-link-small social-link-small hover-anim" href="'.$google.'"'.$target.'><span></span></a>';
			}
			if( $linkedin != '' ) {
				echo '<a class="linkedin-link-small social-link-small hover-anim" href="'.$linkedin.'"'.$target.'><span></span></a>';
			}
			echo '</div>';
		}
	}
}

/**
 * Set the team archive featured images
 *
 * @since 1.0
 */
function digitec_team_featured_image() {
	$image_id = get_post_thumbnail_id();
	if( $image_id && is_single() ) {
		echo wp_get_attachment_image( $image_id, 'main-image', false, array('class'=>'featured-image') );
	}
}

/**
 * Add the team member archive content
 *
 * @since 1.0
 */
function digitec_team_archive_content() {

	$title = sanitize_text_field( get_post_meta(get_the_ID(), '_digitec_member_title', true) );

	echo '<h3 class="member-title">'.$title.'</h3>';
	echo '<p>'.get_maven_excerpt( 120 ).'</p>';
	echo '<a class="readmore digilink" href="'.get_permalink().'">'.__( ' Read more', 'digitec' ).'</a>';
}

/**
 * Add the team member title
 *
 * @since 1.0
 */
function digitec_team_content() {
	$title = sanitize_text_field( get_post_meta(get_the_ID(), '_digitec_member_title', true) );
	echo '<h3 class="member-title">'.$title.'</h3>';
}

/**
 * Add the team block featured image
 *
 * @since 1.0
 */
function digitec_before_team_block_entry_header() {
	
	$image = get_the_post_thumbnail();
	if( !$image ) {
		$att_ids = get_post_meta( get_the_ID(), '_maven_attachments', true );
		if( is_array($att_ids) ) {
			$image = get_m4c_attachment_image( $att_ids[0], 'post-thumbnail' );
		}
	}
	if( $image ) {
		echo '<a class="hover-anim team-thumbnail-link" href="'.get_permalink().'">'.$image.'<span class="digitec-plus-graphic"></span></a>';
	}
}

/**
 * Add the team block entry title
 *
 * @since 1.0
 */
function digitec_team_block_entry_title() {
	echo '<h1 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';
}

/**
 * Add the team block entry content
 *
 * @since 1.0
 */
function digitec_team_block_archive_content() {
	$title = sanitize_text_field( get_post_meta(get_the_ID(), '_digitec_member_title', true) );	
	echo '<h3 class="member-title">'.$title.'</h3>';
}

/**
 * Add custom content to the sidebar
 *
 * @since 1.1.5
 */
function digitec_before_sidebar() {

	// If this is a team member page
	if( get_post_type() == 'team' && ! is_search() ) {
		
		$title = sanitize_text_field( get_post_meta(get_the_ID(), '_digitec_member_widget_title', true) );
		$email = is_email( get_post_meta(get_the_ID(), '_digitec_member_email', true) );
		$url = esc_url( get_post_meta(get_the_ID(), '_digitec_member_url', true) );
		$telephone = sanitize_text_field( get_post_meta(get_the_ID(), '_digitec_member_telephone', true) );
		$fax = sanitize_text_field( get_post_meta(get_the_ID(), '_digitec_member_fax', true) );
		$twitter = esc_url( get_post_meta(get_the_ID(), '_digitec_member_twitter', true) );
		$facebook = esc_url( get_post_meta(get_the_ID(), '_digitec_member_facebook', true) );
		$google = esc_url( get_post_meta(get_the_ID(), '_digitec_member_google', true) );
		$linkedin = esc_url( get_post_meta(get_the_ID(), '_digitec_member_linkedin', true) );
		$author = get_post_meta(get_the_ID(), '_digitec_member_author', true);
		$target = get_post_meta( get_the_ID(), '_digitec_member_link_target', true ) ? ' target="_blank"' : '';
		
		
		echo '<aside id="team-member-connect" class="widget widget_team_member_connect">';
		
		if( $title != '' ) {
			echo '<h3 class="widget-title">'.$title.'</h3>';
		}
		
		// Add Personal Info
		if( $email || $telephone != '' || $fax != '' ) {
			echo '<div class="team-member-personal-info">';
			if( $email ) {
				$prefix = 'Email:';
				$email = '<a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a>';
				printf( __( '<p class="%4$s"><span class="%1$s">%2$s</span> %3$s</p>', 'digitec' ), 'entry-utility-prep inline-heading', $prefix, $email, 'entry-utility-email' );
			}
			if( $url ) {
				$prefix = 'Url:';
				$url = '<a href="'.$url.'"'.$target.'>'.$url.'</a>';
				printf( __( '<p class="%4$s"><span class="%1$s">%2$s</span> %3$s</p>', 'digitec' ), 'entry-utility-prep inline-heading', $prefix, $url, 'entry-utility-url' );
			}
			if( $telephone != '' ) {
				$prefix = 'Tel:';
				printf( __( '<p><span class="%1$s">%2$s</span> %3$s</p>', 'digitec' ), 'entry-utility-prep inline-heading', $prefix, $telephone );
			}
			if( $fax != '' ) {
				$prefix = 'Fax:';
				printf( __( '<p><span class="%1$s">%2$s</span> %3$s</p>', 'digitec' ), 'entry-utility-prep inline-heading', $prefix, $fax );
			}
			echo '</div>';
		}
		
		// Add Social Info
		if( $twitter != '' || $facebook != '' || $google != '' || $linkedin != '' ) {
			echo '<div class="team-member-social-info clearfix">';
			echo '<h4 class="widget-sub-title">'.__( 'Social profiles', 'digitec' ).'</h4>';
			if( $twitter != '' ) {
				echo '<a class="twitter-link social-link hover-anim" href="'.$twitter.'"'.$target.'><span></span></a>';
			}
			if( $facebook != '' ) {
				echo '<a class="facebook-link social-link hover-anim" href="'.$facebook.'"'.$target.'><span></span></a>';
			}
			if( $google != '' ) {
				echo '<a class="google-link social-link hover-anim" href="'.$google.'"'.$target.'><span></span></a>';
			}
			if( $linkedin != '' ) {
				echo '<a class="linkedin-link social-link hover-anim" href="'.$linkedin.'"'.$target.'><span></span></a>';
			}
			echo '</div>';
		}

		// Add Blog Posts
		if( $author != 'None' ) {
			
			// Find the author's latest blog posts
			$args = array(
				'post_type'=> 'post',
				'author_name' => $author,
				'posts_per_page' => 3
			);
			
			// Save the original query & create a new one
			global $wp_query;
			$original_query = $wp_query;
			$wp_query = null;
			$wp_query = new WP_Query();
			$wp_query->query( $args );

			if ( $wp_query->have_posts() ) :

				echo '<div class="team-member-blog-posts">';
				echo '<h4 class="widget-sub-title">'.__( 'Blog posts', 'digitec' ).'</h4>';
	
				/* Start the Loop */
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					echo '<div class="team-member-post-preview">';
					echo '<a href="'.get_permalink().'" class="team-member-post-preview-title">'.get_the_title().'</a>';
					echo '<p>'.get_maven_excerpt( 72 ).'</p>';
					echo '<a class="readmore digilink" href="'.get_permalink().'">'.__( ' Read more', 'digitec' ).'</a>';
					echo '</div>';
				
				endwhile;
				
			else :
			endif;

			$wp_query = null;
			$wp_query = $original_query;
			wp_reset_postdata();

			echo '</div>';
		}
		
		echo '</aside>';
	}
}




/**
 * Clear the archive blocks
 *
 * @since 1.1.5
 */
function digitec_after_team() {
	if( !is_single() ) {
		global $wp_query;

		$curr = $wp_query->current_post+1;
		if($curr%4==0) {
			echo '<div class="clear"></div>';
		}
	}
}




/**
 * Add custom excerpt mores
 *
 * @since 1.0
 */
function digitec_team_excerpt_more( $more ) {
    return '';
}

/**
 * Add custom excerpt lengths
 *
 * @since 1.0
 */
function digitec_team_excerpt_length( $length ) {
    return 13;
}
function digitec_team_post_excerpt_length( $length ) {
    return 10;
}
