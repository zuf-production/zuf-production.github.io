<?php
/**
 * Admin theme code
 *
 * Put all the admin specific code here
 *
 * @package WordPress
 * @subpackage Digitec
 */




// Set custom columns for Post edit screen - @since 1.0
add_filter( 'manage_edit-post_columns', 'digitec_post_edit_columns' );

// Set custom columns for Project edit screen - @since 1.0
add_filter( 'manage_edit-project_columns', 'digitec_project_edit_columns' );

// Set custom columns for Team edit screen - @since 1.0
add_filter( 'manage_edit-team_columns', 'digitec_team_edit_columns' );

// Set custom columns for Content Blocks edit screen - @since 1.0
add_filter( 'manage_edit-contentblock_columns', 'digitec_contentblock_edit_columns' );

// Set custom columns for Slider Blocks edit screen - @since 1.0
add_filter( 'manage_edit-sliderblock_columns', 'digitec_sliderblock_edit_columns' );




// Display the custom columns - @since 1.0
add_action( 'manage_posts_custom_column',  'digitec_custom_columns' );

// Initialize the theme - @since 1.0
add_action( 'after_setup_theme', 'digitec_theme_setup' );

// Remove the content editor from archive templates - @since 1.0
add_action( 'admin_init', 'digitec_remove_editor' );

// Add styles to the admin - @since 1.0
add_action( 'admin_head', 'digitec_admin_css' );




/* Create metaboxes

* Create featured slider metaboxes - @since 1.0
* Create team member metaboxes - @since 1.0
* Create content block metaboxes - @since 1.0

*/




/**
 * Set custom columns for Post edit screen
 *
 * @since 1.0
 */
function digitec_post_edit_columns( $columns ){

/*
	print_r($columns);

	$cb = $columns['cb'];
	unset( $columns['cb'] );
	
	$id = array(
		'shortcode_id' => __( 'ID', 'digitec' )
	);
	
	array_unshift( $columns, $cb, $id );
*/
	
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'shortcode_id' => __( 'ID', 'digitec' ),
		'title' => __( 'Title', 'digitec' ),
		'author' => __( 'Author', 'digitec' ),
		'categories' => __( 'Categories', 'digitec' ),
		'tags' => __( 'Tags', 'digitec' ),
		'comments' => __( 'Comments', 'digitec' ),
		'date' => __( 'Created', 'digitec' )
	);
	return $columns;
}

/**
 * Set custom columns for Project edit screen
 *
 * @since 1.0
 */
function digitec_project_edit_columns( $columns ){
	
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'shortcode_id' => __( 'ID', 'digitec' ),
		'title' => __( 'Title', 'digitec' ),
		'comments' => __( 'Comments', 'digitec' ),
		'date' => __( 'Created', 'digitec' )
	);
	return $columns;
}

/**
 * Set custom columns for Team edit screen
 *
 * @since 1.0
 */
function digitec_team_edit_columns( $columns ){
	
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'shortcode_id' => __( 'ID', 'digitec' ),
		'title' => __( 'Title', 'digitec' ),
		'comments' => __( 'Comments', 'digitec' ),
		'date' => __( 'Created', 'digitec' )
	);
	return $columns;
}

/**
 * Set custom columns for Content Blocks edit screen
 *
 * @since 1.0
 */
function digitec_contentblock_edit_columns( $columns ){
	
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title', 'digitec' ),
		'shortcode' => __( 'Shortcode', 'digitec' ),
		'attributes' => __( 'Additional Attributes', 'digitec' ),
		'date' => __( 'Created', 'digitec' )
	);
	return $columns;
}

/**
 * Set custom columns for Slider Blocks edit screen
 *
 * @since 1.0
 */
function digitec_sliderblock_edit_columns( $columns ){
	
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'shortcode_id' => __( 'ID', 'digitec' ),
		'title' => __( 'Title', 'digitec' ),
		'date' => __( 'Created', 'digitec' )
	);
	return $columns;
}




/**
 * Display the custom columns
 *
 * @since 1.0
 */
function digitec_custom_columns( $column ){
	
	global $post;
	$id = get_the_ID();
	$title = get_the_title();
	
	switch ( $column ) {
			
		case 'shortcode':
			echo '<pre>[content_blocks title="'.$title.'" id="'.$id.'"]</pre>';
			break;
			
		case 'shortcode_id':
			echo '<strong>'.$id.'</strong>';
			break;
			
		case 'attributes':
			echo '<pre>border="<strong>top</strong>, <strong>bottom</strong>, or <strong>both</strong>"</pre>';
			break;	
	}
}

//add_action('init', 'tester');
function tester() {
	
	$options = get_option( 'maven_style_options' );
	$options['post'] = 500;
	update_option( 'maven_style_options', $options );
}


/**
 * Initialize the theme
 *
 * Set default options and create default styles
 *
 * @since 1.0
 */
function digitec_theme_setup() {
	
	// Check if the theme has been initialized
	$init_status = get_option( 'theme_init_status' );
	if ( $init_status !== '1' ) {
		
		$encoded_options = file_get_contents( THEME_DIR.'/digitec-init.json' );  
    $options = json_decode( $encoded_options, true ); 
    
    $primary;
    $full_width;
  
    // Create the default style posts
    foreach ( $options['styles'] as $key => $value ) {
    	
    	// Insert a new style post
    	$post = array(
    		'post_type' => 'maven_styles',
			  'post_title' => $value['post_title'],
			  'post_status' => 'publish'
			);
			$id = wp_insert_post( $post ); 
			
			// Add the post meta to the post
			if( $id ) {

				// Store the primary & full width IDs
				if( $value['post_title'] == 'Primary' ) {
					$primary = $id;
				} elseif( $value['post_title'] == 'Full Width' ) {
					$full_width = $id;
				}
			
				$custom = $value['custom'];
				foreach( $custom as $n => $v ) {
					add_post_meta( $id, $n, $v );
				}
			}  
    } 
    
    // Set the default options
    foreach ( $options['options'] as $key => $value ) {  
    	update_option( $key, $value );  
    }  
    
    // Create a 404 page
  	$post = array(
  		'post_type' => 'page',
		  'post_title' => 'Whoops! There\'s nothing here...',
		  'post_status' => 'publish',
		  'post_content' => '<p class="sub-heading">Sorry, but there doesn\'t seem to be page here for you to look at.<br/>Give the search a try or check out some of our blog posts.</p><br/>[post_slider title=\'\']'
		);
		$error = wp_insert_post( $post );
    $general_options = get_option( 'maven_general_options' );
		$general_options['404_page'] = $error;
		update_option( 'maven_general_options', $general_options );
		
    $style_options = get_option( 'maven_style_options' );
		$style_options['post'] = $primary;
		$style_options['page'] = $full_width;
		$style_options['project'] = $primary;
		$style_options['team'] = $primary;
		$style_options['search'] = $full_width;
		update_option( 'maven_style_options', $style_options );

		// Set the init toggle so this doesn't run again
		update_option( 'theme_init_status', '1' );
		
		// Notify the user
		$styles = get_admin_url( false, 'edit.php?post_type=maven_styles' );
		$styles_msg = sprintf( __('We created two default <strong><a href="%s">Page Styles</a></strong>. Check out the documentation on using Page Styles in your site.', 'digitec' ), $styles );
		
		$error = 517;
		$error_link = get_admin_url( false, 'post.php?post='.$error.'&action=edit' );
		$error_msg = sprintf( __('We created a custom 404 page for your site! Feel free to <strong><a href="%s">edit it</a></strong> to fit your needs.', 'digitec' ), $error_link );
		
		$options = get_admin_url( false, 'themes.php?page=maven_framework' );
		$options_msg = sprintf( __('We also preset your theme options. Feel free to <strong><a href="%s">modify</a></strong> as you see fit.', 'digitec' ), $options );
		
		$envato = get_admin_url( false, 'admin.php?page=envato-wordpress-toolkit' );
		$envato_msg = sprintf( __('Lastly, be sure to set the <strong><a href="%s">Envato Toolkit</a></strong> options to stay current with any updates!', 'digitec' ), $envato );

		$msg = '<strong>Thanks for purchasing Digitec!</strong>';
		$msg .= '<br/>We set up a few things to make your life a little easier:';
		$msg .= '<br/><strong>1.</strong> '.$styles_msg;
		$msg .= '<br/><strong>2.</strong> '.$error_msg;
		$msg .= '<br/><strong>3.</strong> '.$options_msg;
		$msg .= '<br/><strong>4.</strong> '.$envato_msg;
		
		$msg = '<div class="updated">'.$msg.'</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
}

/**
 * Remove the content editor from archive templates
 *
 * @since 1.0
 */
function digitec_remove_editor( $columns ){
	
	$template = get_maven_admin_template();
	if( $template=='pgtemp_blog.php' || $template=='pgtemp_team.php' || $template=='pgtemp_portfolio.php' ) {
		
		global $_wp_post_type_features;
		unset($_wp_post_type_features['page']['editor']);
	}
}

/**
 * Add styles to the admin
 *
 * @since 1.0
 */
function digitec_admin_css() {
	?>
	<style>
	.column-shortcode_id {
		width: 40px;
	}
	</style>
	<?php
}




/**
 * Create featured slider metaboxes
 *
 * @since 1.0
 */  
$featured_slider_info = array(
	'id' => '_digitec_featured_slider_info',
	'title' => __( 'Featured Slider', 'digitec' ),
	'page' => array( 'page' ),
	'context' => 'side',
	'priority' => 'low',
	'fields' => array(
		array(
			'id' => '_digitec_featured_slider',
			'type' => 'text',
			'size' => 30,
			'name' => __( 'Slider Block ID\'s', 'digitec' ),
			'description' => __( 'Add the Block ID\'s separated by commas (,)<br/><strong>* Featured Sliders will override the Header Image.</strong>', 'digitec' ),
			'layout' => 'vertical'
		)
	)
);
new MetaBoxer( apply_filters('digitec_featured_slider_info', $featured_slider_info) );

/**
 * Create team member metaboxes
 *
 * @since 1.1.5
 */  
$member_info = array(
	'id' => '_digitec_member_info',
	'title' => __( 'Member Info', 'digitec' ),
	'page' => array( 'team' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'id' => '_digitec_member_title',
			'type' => 'text',
			'name' => __( 'Member Title', 'digitec' ),
			'description' => __( 'Add a title for the team member.', 'digitec' )
		),
		array(
			'id' => '_digitec_member_author',
			'type' => 'select',
			'options' => get_maven_author_array( 'None' ),
			'name' => __( 'Member Author Link', 'digitec' ),
			'description' => __( 'Link this member to a blog author.', 'digitec' )
		)
	),
);
new MetaBoxer( apply_filters('digitec_member_info', $member_info) );

$member_connect = array(
	'id' => '_digitec_member_connect',
	'title' => __( 'Connection Info', 'digitec' ),
	'page' => array( 'team' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'id' => '_digitec_member_widget_title',
			'type' => 'text',
			'name' => __( 'Widget Title', 'digitec' ),
			'default' => __( 'Connect', 'digitec' )
		),
		array(
			'id' => '_digitec_member_email',
			'type' => 'text',
			'name' => __( 'Email', 'digitec' )
		),
		array(
			'id' => '_digitec_member_url',
			'type' => 'text',
			'name' => __( 'Url', 'digitec' )
		),
		array(
			'id' => '_digitec_member_telephone',
			'type' => 'text',
			'name' => __( 'Telephone', 'digitec' )
		),
		array(
			'id' => '_digitec_member_fax',
			'type' => 'text',
			'name' => __( 'Fax', 'digitec' )
		),
		array(
			'id' => '_digitec_member_twitter',
			'type' => 'text',
			'name' => __( 'Twitter', 'digitec' )
		),
		array(
			'id' => '_digitec_member_facebook',
			'type' => 'text',
			'name' => __( 'Facebook', 'digitec' )
		),
		array(
			'id' => '_digitec_member_google',
			'type' => 'text',
			'name' => __( 'Google+', 'digitec' )
		),
		array(
			'id' => '_digitec_member_linkedin',
			'type' => 'text',
			'name' => __( 'LinkedIn', 'digitec' )
		),
		array(
			'id' => '_digitec_member_link_target',
			'type' => 'checkbox',
			'name' => __( 'Open Links in New Window', 'digitec' )
		)
	)
	
);
new MetaBoxer( apply_filters('digitec_member_connect', $member_connect) );

/**
 * Create content block metaboxes
 *
 * @since 1.0
 */  
$content_blocks = array(
	'id' => '_digitec_contentblock_data',
	'title' => __( 'Content Blocks', 'digitec' ),
	'page' => array( 'contentblock' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'id' => '_digitec_contentblock_title',
			'type' => 'checkbox',
			'name' => __( 'Show Title', 'digitec' ),
			'label' => __( 'Show Title', 'digitec' )
		),
		array(
			'id' => '_digitec_contentblock_title_position',
			'type' => 'radio',
			'name' => __( 'Title Position', 'digitec' ),
			'options' => array(
				'above' => __( 'Above Blocks', 'digitec' ),
				'include' => __( 'First Block', 'digitec' )
			),
			'display' => 'inline',
			'default' => 'above'
		),
		array(
			'id' => '_digitec_contentblock_1',
			'type' => 'wysiwyg',
			'name' => __( 'Block 1', 'digitec' )
		),
		array(
			'id' => '_digitec_contentblock_2',
			'type' => 'wysiwyg',
			'name' => __( 'Block 2', 'digitec' )
		),
		array(
			'id' => '_digitec_contentblock_3',
			'type' => 'wysiwyg',
			'name' => __( 'Block 3', 'digitec' )
		),
		array(
			'id' => '_digitec_contentblock_4',
			'type' => 'wysiwyg',
			'name' => __( 'Block 4', 'digitec' )
		)
	),
);
new MetaBoxer( apply_filters('digitec_content_blocks', $content_blocks) );
