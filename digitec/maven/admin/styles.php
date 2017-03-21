<?php
/**
 * Put all the page styles admin code here
 *
 * @package WordPress
 * @subpackage Maven
 */



// Creates the page styles post type - @since 1.0
add_action( 'init','maven_styles_posttype' );

// Create a style warning message - @since 1.0
add_action( 'admin_notices', 'maven_style_message' );




/* Create metaboxes

* Setup a branding styles metabox - @since 1.0
* Setup a layout options metabox - @since 1.0
* Setup a background options metabox - @since 1.0
* Setup an addition styleing metabox - @since 1.0
* Create all the metaboxes - @since 1.0

*/




/**
 * Creates the page styles post type
 *
 * @since 1.0
 */
function maven_styles_posttype() {
	
	// Create labels
	$labels = array(
		'name' => __( 'Page Styles', 'digitec' ),
		'singular_name' => __( 'Page Style', 'digitec' ),
		'add_new' => __( 'Add New', 'digitec' ),
		'add_new_item' => __( 'Add New Page Style', 'digitec' ),
		'edit_item' => __( 'Edit Page Style', 'digitec' ),
		'new_item' => __( 'New Page Style', 'digitec' ),
		'view_item' => __( 'View Page Style', 'digitec' ),
		'search_items' => __( 'Search Page Styles', 'digitec' ),
		'not_found' => __( 'No Page Styles Found', 'digitec' ),
		'not_found_in_trash' => __( 'No Page Styles Found In Trash', 'digitec' ), 
		'parent_item_colon' => '',
		'menu_name' => __( 'Page Styles', 'digitec' )
	);

	// Create the arguments
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_in_nav_menus' => false,
		'show_ui' => true, 
		'show_in_menu' => 'themes.php', 
		'query_var' => true,
		'rewrite' => true,
		'supports' => array( 'title' )
	); 
	
	// Register the post type
	register_post_type( 'maven_styles', $args );
}

/**
 * Create a style warning message
 *
 * @since 1.0
 */
function maven_style_message() {
	$styles = get_posts( array( 'post_type'=>'maven_styles', 'orderby' => 'title', 'order' => 'ASC' ) );
	if( count($styles) == 0 ) {
		$url = get_admin_url( false, 'edit.php?post_type=maven_styles' );
		maven_admin_message( sprintf( __('<b>No styles created yet!</b> Let\'s create some. <a href="%d">Click here</a>.', 'digitec'), $url ), true );
	}
}




// Create a styles array
$styles_array = array();

/**
 * Create a branding options metabox
 *
 * @since 1.0
 */
if( current_theme_supports('branding-styles') ) {

	$branding_array = array();
	$branding_array['header_logo'] = array(
		'id' => MAVEN_SHORTNAME.'style_header_logo',
		'type' => 'image',
		'name' => __( 'Header Logo', 'digitec' ),
		'description' => __( 'Upload an image to use for the header logo.', 'digitec' ),
		'button' => __( 'Add Image', 'digitec' ),
		'size' => 'full'
	);
	$branding_array['footer_logo'] = array(
		'id' => MAVEN_SHORTNAME.'style_footer_logo',
		'type' => 'image',
		'name' => __( 'Footer Logo', 'digitec' ),
		'description' => __( 'Upload an image to use for the footer logo.', 'digitec' ),
		'button' => __( 'Add Image', 'digitec' ),
		'size' => 'full'
	);
	$branding_array['tagline_color'] = array(
		'id' => MAVEN_SHORTNAME.'style_tagline_color',
		'type' => 'farbtastic',
		'name' => __( 'Tagline Color', 'digitec' ),
		'description' => __( 'Select a custom tagline color.', 'digitec' ),
		'default' => '#FFFFFF'
	);
	$branding_array['copyright_color'] = array(
		'id' => MAVEN_SHORTNAME.'style_copyright_color',
		'type' => 'farbtastic',
		'name' => __( 'Copyright Color', 'digitec' ),
		'description' => __( 'Select a custom copyright color.', 'digitec' ),
		'default' => '#FFFFFF'
	);
	$branding_array = apply_filters( 'maven_branding_styles', $branding_array );
	$styles_array['branding_options'] = array(
		'id' => MAVEN_SHORTNAME . 'style_branding_options',
		'title' => __( 'Branding Options', 'digitec' ),
		'page' => array( 'maven_styles' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $branding_array
	);
}

/**
 * Create a layout options metabox
 *
 * @since 1.0
 */
if( current_theme_supports('layout-styles') ) {
	
	$layout_array = array();
	$layout_array['page_layout'] = array(
				'id' => MAVEN_SHORTNAME.'page_layout',
				'type' => 'image_select',
				'name' => __( 'Page Layout', 'digitec' ),
				'description' => __( 'Choose the layout of the page.', 'digitec' ),
				'options' => array(
					array( 'value' => 'full-width', 'label' => __( 'Full Width', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/full-width.png' ),
					array( 'value' => 'sidebar-right', 'label' => __( 'Sidebar Right', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/sidebar-right.png' ),
					array( 'value' => 'sidebar-left', 'label' => __( 'Sidebar Left', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/sidebar-left.png' )
				),
				'default' => 'sidebar-right',
				'class' => 'page-layout-select',
			);
	$layout_array['page_sidebar'] = array(
				'id' => MAVEN_SHORTNAME.'page_sidebar',
				'type' => 'select',
				'name' => __( 'Page Sidebar', 'digitec' ),
				'description' => '',
				'options' => get_maven_sidebars(),
				'link' => '<a href="'.get_admin_url( false, 'themes.php?page=maven_framework&tab=sidebar_options' ).'">'.__( 'Add Sidebar', 'digitec' ).'</a>',
				'default' => __( 'Primary Widget Area', 'digitec' ),
				'class' => 'page-widget-select'
			);
			
	if( current_theme_supports('footer-widgets') ) {
	
		$layout_array['footer_layout'] = array(
			'id' => MAVEN_SHORTNAME.'footer_layout',
			'type' => 'image_select',
			'name' => __( 'Footer Layout', 'digitec' ),
			'description' => __( 'Choose the layout of the footer.', 'digitec' ),
			'options' => array(
				array( 'value' => 'none', 'label' => __( 'No Footer Widgets', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-none.png' ),
				array( 'value' => 'two-col', 'label' => __( '2 Columns', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-2Col.png' ),
				array( 'value' => 'three-col-1', 'label' => __( '3 Columns', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-3Col-1.png' ),
				array( 'value' => 'three-col-2', 'label' => __( '3 Columns', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-3Col-2.png' ),
				array( 'value' => 'three-col-3', 'label' => __( '3 Columns', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-3Col-3.png' ),
				array( 'value' => 'three-col-4', 'label' => __( '3 Columns', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-3Col-4.png' ),
				array( 'value' => 'four-col', 'label' => __( '4 Columns', 'digitec' ), 'path' => MAVEN_ADMIN_IMAGES_URL.'/layout-icons/footer-4Col.png' )
			),
			'default' => 'three-col-1',
			'class' => 'footer-layout-select'
		);
		$layout_array['footer_widget_1'] = array(
			'id' => MAVEN_SHORTNAME.'footer_widget_1',
			'type' => 'select',
			'name' => __( 'Footer Widget 1', 'digitec' ),
			'description' => '',
			'options' => get_maven_sidebars(),
			'link' => '<a href="'.get_admin_url( false, 'themes.php?page=maven_framework&tab=sidebar_options' ).'">'.__( 'Add Sidebar', 'digitec' ).'</a>',
			'default' => __( 'Footer Widget Area 1', 'digitec' ),
			'class' => 'footer-widget-select-1'
		);
		$layout_array['footer_widget_2'] = array(
			'id' => MAVEN_SHORTNAME.'footer_widget_2',
			'type' => 'select',
			'name' => __( 'Footer Widget 2', 'digitec' ),
			'description' => '',
			'options' => get_maven_sidebars(),
			'link' => '<a href="'.get_admin_url( false, 'themes.php?page=maven_framework&tab=sidebar_options' ).'">'.__( 'Add Sidebar', 'digitec' ).'</a>',
			'default' => __( 'Footer Widget Area 2', 'digitec' ),
			'class' => 'footer-widget-select-2'
		);
		$layout_array['footer_widget_3'] = array(
			'id' => MAVEN_SHORTNAME.'footer_widget_3',
			'type' => 'select',
			'name' => __( 'Footer Widget 3', 'digitec' ),
			'description' => '',
			'options' => get_maven_sidebars(),
			'link' => '<a href="'.get_admin_url( false, 'themes.php?page=maven_framework&tab=sidebar_options' ).'">'.__( 'Add Sidebar', 'digitec' ).'</a>',
			'default' => __( 'Footer Widget Area 3', 'digitec' ),
			'class' => 'footer-widget-select-3'
		);
		$layout_array['footer_widget_4'] = array(
			'id' => MAVEN_SHORTNAME.'footer_widget_4',
			'type' => 'select',
			'name' => __( 'Footer Widget 4', 'digitec' ),
			'description' => '',
			'options' => get_maven_sidebars(),
			'link' => '<a href="'.get_admin_url( false, 'themes.php?page=maven_framework&tab=sidebar_options' ).'">'.__( 'Add Sidebar', 'digitec' ).'</a>',
			'default' => __( 'Footer Widget Area 4', 'digitec' ),
			'class' => 'footer-widget-select-4'
		);
	}
	$layout_array = apply_filters( 'maven_layout_styles', $layout_array );
	$styles_array['layout_options'] = array(
		'id' => MAVEN_SHORTNAME.'layout_options',
		'title' =>  __( 'Layout Options', 'digitec' ),
		'page' => array( 'maven_styles' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $layout_array
	);
}

/**
 * Create a background options metabox
 *
 * @since 1.0
 */
if( current_theme_supports('background-styles') ) {
	
	$background_array = array();
	$background_array['bg_color'] = array(
		'id' => MAVEN_SHORTNAME.'style_bg_color',
		'type' => 'farbtastic',
		'name' => __( 'Color', 'digitec' ),
		'description' => __( 'Select a custom background color.', 'digitec' ),
		'default' => '#FFFFFF'
	);
	$background_array['bg_pattern'] = array(
		'id' => MAVEN_SHORTNAME.'style_bg_pattern',
		'type' => 'pattern_select',
		'name' => __( 'Pattern', 'digitec' ),
		'description' => __( 'Select a preset pattern to use as the background.', 'digitec' ),
		'options' => get_m4c_patterns()
	);
	$background_array['bg_image'] = array(
		'id' => MAVEN_SHORTNAME.'style_bg_image',
		'type' => 'image',
		'name' => __( 'Image', 'digitec' ),
		'desc' => __( 'Upload an image to use as the background.', 'digitec' ),
		'button' => __( 'Add Image', 'digitec' )
	);
	$background_array['bg_type'] = array(
		'id' => MAVEN_SHORTNAME.'style_bg_type',
		'type' => 'select',
		'name' => __( 'Image Style', 'digitec' ),
		'description' => __( 'Select how the background image should be displayed.', 'digitec' ),
		'options' => array(
			array( 'name' => __( 'Full Screen', 'digitec' ), 'value' => 'fullscreen' ),
			array( 'name' => __( 'Tiled', 'digitec' ), 'value' => 'repeat' ),
			array( 'name' => __( 'Tiled-X', 'digitec' ), 'value' => 'repeat-x' ),
			array( 'name' => __( 'Tiled-Y', 'digitec' ), 'value' => 'repeat-y' ),
			array( 'name' => __( 'None', 'digitec' ), 'value' => 'no-repeat' ),
		)
	);
	$background_array['bg_position'] = array(
		'id' => MAVEN_SHORTNAME.'style_bg_position',
		'type' => 'select',
		'name' => __( 'Image Tile Position', 'digitec' ),
		'description' => __( 'Set the start position of your tiled image.', 'digitec' ),
		'options' => array(
			array( 'name' => __( 'Center Center', 'digitec' ), 'value' => 'center center' ),
			array( 'name' => __( 'Center Top', 'digitec' ), 'value' => 'center top' ),
			array( 'name' => __( 'Center Bottom', 'digitec' ), 'value' => 'center bottom' ),
			array( 'name' => __( 'Left Top', 'digitec' ), 'value' => 'left top' ),
			array( 'name' => __( 'Left Bottom', 'digitec' ), 'value' => 'left bottom' ),
			array( 'name' => __( 'Left Center', 'digitec' ), 'value' => 'left center' ),
			array( 'name' => __( 'Right Top', 'digitec' ), 'value' => 'right top' ),
			array( 'name' => __( 'Right Bottom', 'digitec' ), 'value' => 'right bottom' ),
			array( 'name' => __( 'Right Center', 'digitec' ), 'value' => 'right center' )
		)
	);
	$background_array = apply_filters( 'maven_background_styles', $background_array );
	$styles_array['background_options'] = array(
		'id' => MAVEN_SHORTNAME . 'style_background_options',
		'title' => __( 'Background Options', 'digitec' ),
		'page' => array( 'maven_styles' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $background_array
	);
}

/**
 * Create an additional styling metabox
 *
 * @since 1.0
 */
if( current_theme_supports('additional-styles') ) {
	
	$additional_array = array();
	$additional_array['custom_css'] = array(
		'id' => MAVEN_SHORTNAME.'style_custom_css',
		'type' => 'textarea',
		'name' => __( 'Custom CSS', 'digitec' ),
		'description' => __( 'Enter your own custom CSS styles.', 'digitec' ),
		'rows' => 10,
		'cols' => 80
	);
	$additional_array = apply_filters( 'maven_additional_styles', $additional_array );
	$styles_array['additional_styling'] = array(
		'id' => MAVEN_SHORTNAME . 'style_additional_styling',
		'title' => __( 'Additional Styling', 'digitec' ),
		'page' => array( 'maven_styles' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $additional_array
	);
}

/**
 * Create all the metaboxes
 *
 * @since 1.0
 */
$styles_array = apply_filters( 'maven_styles', $styles_array );
foreach( $styles_array as $style ) {
	new MetaBoxer( $style );
}
