<?php
/**
 * Search specific theme code
 *
 * The code that specifically deals with
 * search results goes here
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Create a custom search loop - @since 1.0
add_action( 'maven_search_archive_loop', 'digitech_search_archive_loop' );

// Add the search title - @since 1.0
add_action( 'maven_before_search_primary_secondary', 'digitec_search_title', 5 );




/**
 * Create a custom search loop
 *
 * @since 1.0
 */
function digitech_search_archive_loop() {
	
	global $wp_query;
	$post_type = 'search';
	
	if ( have_posts() ) :
		
		if( maven_sidebar() ) {
			
			// Start the Loop
			while ( have_posts() ) : the_post();

				echo '<div class="digitec-search-row clearfix">';
				maven_loop( $post_type );
				echo '</div>';

			endwhile;

		} else {
			
			echo '<div class="digitec-search-container clearfix">';
			
			// Start the Loop
			while ( have_posts() ) : the_post();
			
				echo '<div class="digitec-search-block">';
				maven_loop( $post_type );
				echo '</div>';

			endwhile;
			
			echo '</div>';
		}
	
	else :
		
		echo '<div id="digitec-no-search-results">';
		printf( __( 'No matches found for %s', 'digitec' ), '<span>"'.get_search_query().'"</span>' );
		echo '</div>';
	
	endif;
}

/**
 * Add the search title
 *
 * @since 1.0
 */
function digitec_search_title() {

	echo '<div class="entry-header clearfix">';						
	echo '<h1 class="entry-title">'.__( 'Search our site', 'digitec' ).'</h1>	';
	$options = get_option( 'maven_general_options' );
	if( !isset($options['search_field']) ) {
		get_search_form();
	}					
	echo '</div>';
}

