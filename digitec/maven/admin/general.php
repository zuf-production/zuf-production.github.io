<?php
/**
 * Put all the general admin code here
 *
 * @package WordPress
 * @subpackage Maven
 */




// Register the defualt Maven menus - @since 1.0
add_action( 'init', 'maven_menus_init' );

// Create global metaboxes - @since 1.1
add_action( 'admin_init','maven_global_metaboxes' );




/* Additional functions

* maven_admin_message // Create admin messages - @since 1.0
* maven_curl_get // Add a curl helper for APIs - @since 1.0
* get_maven_admin_template // Get the template file for a page in the admin - @since 1.0
* get_maven_admin_post_id // Get the post id for a post in the admin - @since 1.0
* get_maven_author_array // Return an array of authors - @since 1.0
* get_maven_post_types // Return an array of post types - @since 1.0

*/




/**
 * Register the defualt Maven menus
 *
 * @since 1.0
 */
function maven_menus_init() {

	register_nav_menus(
		array(
			'main-menu' =>  __( 'Main Menu', 'digitec' )
		)
	);
}

/**
 * Create global metaboxes
 *
 * @since 1.1
 */
function maven_global_metaboxes() {

	$post_types = get_maven_global_options_post_types( false, true );
	
	$visual_options = array(
		'id' => MAVEN_SHORTNAME.'visual_options',
		'title' => __( 'Page Style', 'digitec' ),
		'page' => $post_types,
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			array(
				'id' => MAVEN_SHORTNAME.'style_select',
				'type' => 'select',
				'name' => __( 'Style', 'digitec' ),
				'options' => get_maven_styles( '* Use Default' ),
				'link' => '<a href="'.get_admin_url( false, 'edit.php?post_type=maven_styles' ).'">+ '.__( 'Add', 'digitec' ).'</a>',
				'default' => '* Use Default'
			),
			array(
				'id' => MAVEN_SHORTNAME.'page_sidebar',
				'type' => 'select',
				'name' => __( 'Sidebar', 'digitec' ),
				'options' => get_maven_sidebars( array('* Use Style Setting', '* None') ),
				'link' => '<a href="'.get_admin_url( false, 'themes.php?page=maven_framework&tab=sidebar_options' ).'">+ '.__( 'Add', 'digitec' ).'</a>',
				'default' => '* Use Style Setting'
			)
		)
	);
	new MetaBoxer( $visual_options );
	
	if( current_theme_supports('additional-content') ) {
		
		/**
		 * Create an additional content above metabox
		 *
		 * @since 1.0
		 */
		$above_array = array();
		$above_array['enabled'] = array(
			'id' => MAVEN_SHORTNAME.'above_content_enabled',
			'type' => 'checkbox',
			'name' => __( 'Enable Content', 'digitec' ),
			'options' => array( __( 'Enable', 'digitec' ) )
		);
		$above_array['position'] = array(
			'id' => MAVEN_SHORTNAME.'above_content_position',
			'type' => 'radio',
			'name' => __( 'Position', 'digitec' ),
			'options' => array(
				'outside' => __( 'Above Content & Sidebar', 'digitec' ),
				'inside' => __( 'Above Content', 'digitec' )
			),
			'display' => 'inline',
			'default' => 'outside'
		);
		$above_array['borders'] = array(
			'id' => MAVEN_SHORTNAME.'above_content_borders',
			'type' => 'checkbox',
			'name' => __( 'Borders', 'digitec' ),
			'options' => array( 'top' => __('Border Top', 'digitec'), 'bottom' => __('Border Bottom', 'digitec') ),
			'display' => 'inline'
		);
		$above_array['content'] = array(
			'id' => MAVEN_SHORTNAME.'above_content',
			'type' => 'wysiwyg',
			'name' => __( 'Above Content', 'digitec' ),
			'description' => __( 'Add extra content above the main content & sidebar.', 'digitec' )
		);
		$above_array = apply_filters( 'additional_content_above', $above_array );
		$additional_content_above = array(
			'id' => MAVEN_SHORTNAME.'additional_content_above',
			'title' => __( 'Additional Content Above', 'digitec' ),
			'page' => $post_types,
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $above_array
		);
		new MetaBoxer( $additional_content_above );
		
		/**
		 * Create an additional content below metabox
		 *
		 * @since 1.0
		 */
		$below_array = array();
		$below_array['enabled'] = array(
			'id' => MAVEN_SHORTNAME.'below_content_enabled',
			'type' => 'checkbox',
			'name' => __( 'Enable Content', 'digitec' ),
			'options' => array( __( 'Enable', 'digitec' ) )
		);
		$below_array['position'] = array(
			'id' => MAVEN_SHORTNAME.'below_content_position',
			'type' => 'radio',
			'name' => __( 'Position', 'digitec' ),
			'options' => array(
				'outside' => __( 'Below Content & Sidebar', 'digitec' ),
				'inside' => __( 'Below Content', 'digitec' )
			),
			'display' => 'inline',
			'default' => 'outside'
		);
		$below_array['borders'] = array(
			'id' => MAVEN_SHORTNAME.'below_content_borders',
			'type' => 'checkbox',
			'name' => __( 'Borders', 'digitec' ),
			'options' => array( 'top' => __( 'Border Top', 'digitec' ), 'bottom' => __( 'Border Bottom', 'digitec' ) ),
			'display' => 'inline'
		);
		$below_array['content'] = array(
			'id' => MAVEN_SHORTNAME.'below_content',
			'type' => 'wysiwyg',
			'name' => __( 'Below Content', 'digitec' ),
			'description' => __( 'Add extra content below the main content & sidebar.', 'digitec' )
		);
		$below_array = apply_filters( 'additional_content_below', $below_array );
		$additional_content_below = array(
			'id' => MAVEN_SHORTNAME.'additional_content_below',
			'title' => __( 'Additional Content Below', 'digitec' ),
			'page' => $post_types,
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $below_array
		);
		new MetaBoxer( $additional_content_below );
	}
	
	if( current_theme_supports('custom-widget') ) {
		
		/**
		 * Create a custom widget metabox
		 *
		 * @since 1.1
		 */
		$widget_array = array();
		$widget_array['enabled'] = array(
			'id' => MAVEN_SHORTNAME.'widget_enabled',
			'type' => 'checkbox',
			'name' => __( 'Enable Widget', 'digitec' ),
			'options' => array( __( 'Enable', 'digitec' ) )
		);
		$widget_array['position'] = array(
			'id' => MAVEN_SHORTNAME.'widget_position',
			'type' => 'radio',
			'name' => __( 'Widget Position', 'digitec' ),
			'options' => array(
				'top' => __( 'Sidebar Top', 'digitec' ),
				'bottom' => __( 'Sidebar Bottom', 'digitec' )
			),
			'display' => 'inline',
			'default' => 'top'
		);
		$widget_array['title'] = array(
			'id' => MAVEN_SHORTNAME.'widget_title',
			'type' => 'text',
			'name' => __( 'Widget Title', 'digitec' )
		);
		$widget_array['content'] = array(
			'id' => MAVEN_SHORTNAME.'widget_content',
			'type' => 'wysiwyg',
			'name' => __( 'Widget Content', 'digitec' )
		);
		$widget_array = apply_filters( 'custom_widget_data', $widget_array );
		$custom_widget = array(
			'id' => MAVEN_SHORTNAME.'custom_widget_data',
			'title' => __( 'Custom Sidebar Widget', 'digitec' ),
			'page' => $post_types,
			'context' => 'normal',
			'priority' => 'high',
			'fields' => $widget_array
		);
		new MetaBoxer( $custom_widget );
	}
}




/**
 * Create admin messages
 *
 * @since 1.0
 */
function maven_admin_message( $message, $errormsg=false ) {
	if ($errormsg) {
		echo '<div id="message" class="error">';
	} else {
		echo '<div id="message" class="updated fade">';
	}
	echo '<p>'.$message.'</p></div>';
} 

/**
 * Add a curl helper for APIs
 *
 * @since 1.0
 */
function maven_curl_get( $url ) {
	$curl = curl_init( $url );
	@curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	@curl_setopt( $curl, CURLOPT_TIMEOUT, 30 );
	@curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
	$return = curl_exec( $curl );
	curl_close( $curl );
	return $return;
}

/**
 * Get the template file for a page in the admin
 *
 * @since 1.0
 */
function get_maven_admin_template() {
	$template_file = get_post_meta( get_maven_admin_post_id(), '_wp_page_template', true );
	return $template_file;
}

/**
 * Get the post id for a post in the admin
 *
 * @since 1.0
 */
function get_maven_admin_post_id() {
	$post_id = ( isset($_GET['post']) ) ? $_GET['post'] : '';
	$post_id = ( $post_id == '' && isset($_POST['post_ID']) ) ? $_POST['post_ID'] : $post_id;
	return $post_id;
}

/**
 * Return an array of authors
 *
 * @since 1.0
 */
function get_maven_author_array( $add=false, $args=false ) {
	$defaults = array(
	  'exclude_admin' => false, 
	  'show_fullname' => false,
	  'hide_empty'    => false,
	  'echo'          => false,
	  'html'          => false
	);
	$args = wp_parse_args( $args, $defaults );
	$authors = wp_list_authors( $args );
	$authors_array = explode( ', ', $authors );
	if( $add ) {
		array_unshift( $authors_array, $add );
	}
	return $authors_array;
}

/**
 * Return an array of post types
 *
 * @since 1.0
 */
function get_maven_post_types( $output='names') {
	
	// Get custom post types
	$args=array(
	  'public'   => true,
	  '_builtin' => false
	); 
	$post_types = get_post_types( $args, $output );
	
	// Add the defaults
	array_push( $post_types, 'post', 'page' );
	
	$post_types = apply_filters( 'maven_post_types', $post_types );
	
	return $post_types;
}