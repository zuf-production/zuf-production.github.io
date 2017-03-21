<?php

add_action( 'init','maven_custom_posttypes' );
/**
 * Add custom post types
 *
 * @since 1.0
 */
function maven_custom_posttypes() {
	
	$posttypes = array();
	
	if( current_theme_supports('project-postype') ) {
	
		// Create labels
		$labels = array(
			'name' => __( 'Projects', 'digitec' ),
			'singular_name' => __( 'Project', 'digitec' ),
			'add_new' => __( 'Add New', 'digitec' ),
			'add_new_item' => __( 'Add New Project', 'digitec' ),
			'edit_item' => __( 'Edit Project', 'digitec' ),
			'new_item' => __( 'New Project', 'digitec' ),
			'view_item' => __( 'View Project', 'digitec' ),
			'search_items' => __( 'Search Projects', 'digitec' ),
			'not_found' => __( 'No Projects Found', 'digitec' ),
			'not_found_in_trash' => __( 'No Projects Found in Trash', 'digitec' ), 
			'parent_item_colon' => '',
			'menu_name' => __( 'Projects', 'digitec' )
		);
		$labels = apply_filters( 'maven_project_labels', $labels );
		
		// Get the custom post slug
		$options = get_option( 'maven_general_options' );
		$slug = ( $options ) ? sanitize_text_field( $options['project_slug'] ) : 'project';
		
		// Create the arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => true,
			'supports' => array( 'title', 'thumbnail', 'editor', 'comments' ),
			'show_in_nav_menus' => true,
			'rewrite' => array( 'slug' => $slug )
		); 
		$args = apply_filters( 'maven_project_args', $args );
		
		$posttypes['project'] = $args;
	}
	
	// Filter the post types
	$posttypes = apply_filters( 'maven_custom_posttypes', $posttypes );
	
	// Register the post types
	foreach( $posttypes as $name => $args ) {
		register_post_type( $name, $args );	
	}
}
