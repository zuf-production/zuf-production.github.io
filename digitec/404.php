<?php
/**
 * 404 page code
 *
 * The code that specifically deals with
 * 404 pages
 *
 * @package WordPress
 * @subpackage Digitec
 */




$post_type = 'page';

global $post, $wp_query;
$options = get_option('maven_general_options');		
if( isset($options['404_page']) ) {
	$args = array(
		'post_type'=> $post_type,
		'page_id' => $options['404_page']
	);
	// Save the original query & create a new one
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query( $args );
}

the_post();

get_header();
do_action( 'maven_before_main', $post_type );
?>

<div id="main" role="main" class="clearfix">

	<div class="wrapper clearfix">

	<?php do_action( 'maven_before_'.$post_type.'_primary_secondary', $post_type ); ?>
	
	<div id="primary">
	
		<?php do_action( 'maven_before_'.$post_type.'_content_container', $post_type ); ?>
		
		<div id="content" role="main">

			<?php do_action( 'maven_before_'.$post_type, $post_type ); ?>
			
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