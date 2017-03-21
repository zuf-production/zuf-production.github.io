<?php
/**
 * Post specific theme code
 *
 * The code that specifically deals with
 * post goes here
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Add the parent title to the top of posts - @since 1.0
add_action( 'maven_before_post_primary_secondary', 'digitec_post_parent_title', 5 );

// Add navigation to the top of blog pages - @since 1.0
add_action( 'maven_before_post_primary_secondary', 'digitec_post_navigation' );

// Add the post title to post blocks - @since 1.0
add_action( 'maven_post_block_entry_title', 'digitec_post_block_entry_title' );

// Add the post content to post blocks - @since 1.0
add_action( 'maven_post_block_archive_content', 'digitec_post_block_archive_content' );

// Reposition the archive title - @since 1.0
remove_action( 'maven_before_post_archive_loop', 'maven_archive_title' );
add_action( 'maven_before_post_primary_secondary', 'maven_archive_title' );




/**
 * Add the parent title to the top of posts
 *
 * @since 1.0
 */
function digitec_post_parent_title() {
	
	if( is_single() || is_archive() ) {
		$blog_pages = get_pages(array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_blog.php'
		));
		if( ! empty($blog_pages) ) {
			$blog_id = intval($blog_pages[0]->ID);
			echo '<div class="entry-header clearfix">';						
			echo '<h1 class="entry-title">'.get_the_title($blog_id).'</h1>	';
			$options = get_option( 'maven_general_options' );
			if( !isset($options['search_field']) ) {
				get_search_form();
			}						
			echo '</div>';
		}
	}
}

/**
 * Add navigation to the top of blog pages
 *
 * @since 1.0
 */
function digitec_post_navigation() {
	
	// If this is a blog page
	if( is_single() ) {
	
		// Get the button labels
		$options = get_option( 'maven_general_options' );
		if( $options ) {
			$home = ( isset($options['post_single_home']) ) ? sanitize_text_field( $options['post_single_home'] ) : __( 'Blog home', 'digitec' );
			$prev = ( isset($options['post_single_prev']) ) ? sanitize_text_field( $options['post_single_prev'] ) : __( 'Prev post', 'digitec' );
			$next = ( isset($options['post_single_next']) ) ? sanitize_text_field( $options['post_single_next'] ) : __( 'Next post', 'digitec' );
		} else {
			$home = __( 'Blog home', 'digitec' );
			$prev = __( 'Prev post', 'digitec' );
			$next = __( 'Next post', 'digitec' );
		}
	
		$blog_pages = get_pages( array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_blog.php'
		));
		if( ! empty($blog_pages) ) {
			$blog_id = intval($blog_pages[0]->ID);
		}
		
		// Get the previous post
		$prev_post = get_previous_post();
		if( empty( $prev_post ) ) {
			$p = get_posts( array(
		    'post_type' => 'post',
		    'numberposts' => 1,
		    'order' => 'DESC'
			));
			$prev_post = $p[0];
		}
		
		// Get the previous post
		$next_post = get_next_post();
		if( empty( $next_post ) ) {
			$p = get_posts( array(
		    'post_type' => 'post',
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
			if( ! empty($blog_pages) ) { ?>
				<span class="nav-home-container">
					<span class="nav-home"><a href="<?php echo get_permalink($blog_id); ?>" class="digibutton"><?php echo $home; ?><i class="icon-arrow-up icon-arrow"><span></span></i></a></span>
				</span><!-- .nav-next-container -->
				<?php
			} 
			?>
			
		</nav><!-- #nav-single -->
		<?php
		}
	} elseif( is_archive() ) {
	
		$blog_pages = get_pages(array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'pgtemp_blog.php'
		));
		if( ! empty($blog_pages) ) {
			$blog_id = intval($blog_pages[0]->ID);
			?>
			<span class="nav-home-container">
				<span class="nav-home"><a href="<?php echo get_permalink($blog_id); ?>" class="digibutton"><?php _e( 'Blog home', 'digitec' ); ?><i class="icon-arrow-up icon-arrow"><span></span></i></a></span>
			</span><!-- .nav-next-container -->
			<?php
		}
	}
}

/**
 * Add the post title to post blocks
 *
 * @since 1.0
 */
function digitec_post_block_entry_title() {
	echo '<p class="entry-date">'.get_the_time('d').'<br/>'.get_the_time('M').'</p>';
	echo '<h1 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';	
}

/**
 * Add the post content to post blocks
 *
 * @since 1.0
 */
function digitec_post_block_archive_content() {

	global $post;

	$trim_length = 180;
	$excerpt = rtrim( substr($post->post_content, 0, $trim_length) ).' &hellip;';	
	echo '<div class="entry-content clearfix">';		
	echo '<p>'.$excerpt.'</p>';
	echo '<a href="'.get_permalink($post->ID).'" class="digilink">'.__( 'Read more', 'digitec' ).'</a>';
	echo '</div>';
}
