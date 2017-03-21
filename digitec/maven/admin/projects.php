<?php
/**
 * Put all the project admin code here
 *
 * @package WordPress
 * @subpackage Maven
 */




//  Create a clients taxonomy - @since 1.0
if( current_theme_supports('clients-taxonomy') ) {
	add_action( 'init', 'maven_clients_taxonomy', 0 );
}




/* Create metaboxes

* Create a project assets metabox - @since 1.0

*/




/**
 * Create a clients taxonomy
 *
 * @since 1.0
 */
function maven_clients_taxonomy() {
  	
	// Create labels
	$labels = array(
		'name' => "Clients",
		'singular_name' => "Client",
		'search_items' =>  "Search Clients",
		'all_items' => "All Clients",
		'parent_item' => "Parent",
		'parent_item_colon' => "Parent:",
		'edit_item' => "Edit Client", 
		'update_item' => "Update Client",
		'add_new_item' => "Add New Client",
		'new_item_name' => "New Client Name",
		'menu_name' => "Clients",
	); 	 	
	
	// Create the arguments
	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'clients' )
	); 
	
	// Register the taxonomy
	register_taxonomy( 'clients', array( 'project' ), $args );
}




/**
 * Create a project assets metabox
 *
 * @since 1.0
 */
$assets = array(
	'id' => MAVEN_SHORTNAME.'project_assets',
	'title' => __( 'Project Assets', 'digitec' ),
	'page' => array( 'project' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'id' => MAVEN_SHORTNAME.'attachments',
			'type' => 'gallery',
			'name' => __( 'Resources', 'digitec' ),
			'description' => __( 'Add file attachments to your project.', 'digitec' )
		)
	)
);
new MetaBoxer( apply_filters('maven_project_assets', $assets) );
