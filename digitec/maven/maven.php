<?php
/**
 * Maven loop setup
 *
 * Sets up the framework loop and actions
 * for archive and single pages
 *
 * @package WordPress
 * @subpackage Maven
 */




/**
 * Setup the basic structure for an archive page
 *
 * @since 1.0
 */
function maven_archive( $post_type='post' ) {
	
	global $wp_query, $s_post;
	$wp_loop = ( is_home() || is_archive() || is_search() ) ? true : false;
	if( is_page_template() ) {
		$wp_loop = false;
	}
	
	get_header();
	do_action( 'maven_before_main' );
	?>
	
	<div id="main" role="main" class="clearfix">
	
		<div class="wrapper clearfix">
	
		<?php do_action( 'maven_before_'.$post_type.'_primary_secondary', $post_type ); ?>

		<div id="primary">
		
			<?php do_action( 'maven_before_'.$post_type.'_content_container', $post_type ); ?>
			
			<div id="content" role="main" class="clearfix">
				
				<?php
				do_action( 'maven_before_'.$post_type.'_archive_query', $post_type );
				
				if( !$wp_loop ) {
					$page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
						'post_type'=> $post_type,
						'paged' => $page,
						'posts_per_page' => get_option('posts_per_page')
					);
					$args = apply_filters( 'maven_archive_loop_args', $args );
					
					// Save the original query & create a new one
					$original_query = $wp_query;
					$wp_query = null;
					$wp_query = new WP_Query();
					$wp_query->query( $args );
				}
		
				do_action( 'maven_before_'.$post_type.'_archive_loop', $post_type );
				
				do_action( 'maven_'.$post_type.'_archive_loop', $post_type );
	
				do_action( 'maven_after_'.$post_type.'_archive_loop', $post_type );
				
				if( !$wp_loop ) {
					$wp_query = null;
					$wp_query = $original_query;
					wp_reset_postdata();
				}
				
				do_action( 'maven_after_'.$post_type.'_archive_query', $post_type );
				?>
		
			</div><!-- #content -->
			
			<?php do_action( 'maven_after_'.$post_type.'_content_container', $post_type ); ?>
			
		</div><!-- #primary -->
		
		<?php get_sidebar(); ?>
		
		<?php do_action( 'maven_after_'.$post_type.'_primary_secondary', $post_type ); ?>
		
		</div><!-- .wrapper -->
	
	</div><!-- #main -->
	
	<?php
	do_action( 'maven_after_main', $post_type );
	get_footer();
} 




/**
 * Print out the content of each archive item
 *
 * @since 1.0
 */
function maven_loop( $post_type='post' ) {

	do_action( 'maven_before_'.$post_type, $post_type );
	
	?><article id="post-<?php the_ID(); ?>" <?php post_class( 'maven-'.$post_type ); ?>><?php
	
		do_action( 'maven_before_'.$post_type.'_wrapper', $post_type );
	
		echo '<div class="wrapper">';
			
			do_action( 'maven_before_'.$post_type.'_entry_header', $post_type );
			
			echo '<div class="entry-header clearfix">';
				
				do_action( 'maven_before_'.$post_type.'_entry_title', $post_type );
				do_action( 'maven_'.$post_type.'_entry_title', $post_type );
				do_action( 'maven_after_'.$post_type.'_entry_title', $post_type );
			
			echo '</div>';
			
			do_action( 'maven_before_'.$post_type.'_entry_content', $post_type );

			echo '<div class="entry-content clearfix">';
			
				do_action( 'maven_before_'.$post_type.'_content', $post_type );
				do_action( 'maven_'.$post_type.'_archive_content', $post_type );
				do_action( 'maven_after_'.$post_type.'_content', $post_type );
				
			echo '</div>';
			
			do_action( 'maven_after_'.$post_type.'_entry_content', $post_type );
		
		echo '</div>';
		
		do_action( 'maven_after_'.$post_type.'_wrapper', $post_type );
	
	echo '</article>';

	do_action( 'maven_after_'.$post_type, $post_type );
}
 
 
 
 
/**
 * Setup the basic structure for a single page
 *
 * @since 1.0
 */
function maven_single( $custom_type = false ) {

	global $post, $s_post;
	$post_type = ( $custom_type ) ? $custom_type : get_post_type();
	
	get_header();
	do_action( 'maven_before_main', $post_type );
	?>
	
	<div id="main" role="main" class="clearfix">
	
		<div class="wrapper clearfix">
	
		<?php do_action( 'maven_before_'.$post_type.'_primary_secondary', $post_type ); ?>
		
		<div id="primary">
		
			<?php do_action( 'maven_before_'.$post_type.'_content_container', $post_type ); ?>
			
			<div id="content" role="main">

				<?php
				if ( have_posts() ) :
		
				/* Start the Loop */
				while ( have_posts() ) : the_post();
				
					do_action( 'maven_before_'.$post_type, $post_type );
					?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
						<?php do_action( 'maven_before_'.$post_type.'_wrapper', $post_type ); ?>
					
						<div class="wrapper">

							<?php do_action( 'maven_before_'.$post_type.'_entry_header', $post_type ); ?>
							
							<div class="entry-header clearfix">
								
								<?php
								do_action( 'maven_before_'.$post_type.'_entry_title', $post_type );
								do_action( 'maven_'.$post_type.'_entry_title', $post_type );
								do_action( 'maven_after_'.$post_type.'_entry_title', $post_type );
								?>
							
							</div><!-- .entry-header -->
							
							<?php do_action( 'maven_before_'.$post_type.'_entry_content', $post_type ); ?>
	
							<div class="entry-content clearfix">
							
								<?php
								do_action( 'maven_before_'.$post_type.'_content', $post_type );
								do_action( 'maven_'.$post_type.'_content', $post_type );
								do_action( 'maven_after_'.$post_type.'_content', $post_type );
								?>
	
							</div><!-- .entry-content -->
							
							<?php do_action( 'maven_after_'.$post_type.'_entry_content', $post_type ); ?>
						
						</div><!-- .wrapper -->
						
						<?php do_action( 'maven_after_'.$post_type.'_wrapper', $post_type ); ?>
					
					</article><!-- #post-<?php the_ID(); ?> -->
					
					<?php do_action( 'maven_after_'.$post_type, $post_type ); ?>
					
				<?php
				endwhile;
				
				else :
				endif;
				?>
		
			</div><!-- #content -->
			
			<?php do_action( 'maven_after_'.$post_type.'_content_container', $post_type ); ?>
			
		</div><!-- #primary -->
		
		<?php get_sidebar(); ?>
		
		<?php do_action( 'maven_after_'.$post_type.'_primary_secondary', $post_type ); ?>
		
		</div><!-- .wrapper -->
		
	</div><!-- #main -->
	
	<?php
	do_action( 'maven_after_main', $post_type );
	
	get_footer();
}