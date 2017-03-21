<?php
/**
 * The theme options setup code
 *
 * @package WordPress
 * @subpackage Maven
 */


// Create the theme options page - @since 1.0
add_action( 'admin_menu', 'maven_theme_menu', 9 );

// Setup the theme options - @since 1.0
add_action( 'admin_init', 'maven_initialize_theme_options' );




/* Additional functions

* maven_framework_display // Render the theme options page - @since 1.0
* maven_general_options_callback // General options section callback - @since 1.0
* maven_style_options_callback // Style options section callback - @since 1.0
* maven_custom_sidebars_callback // Custom sidebars section callback - @since 1.0
* maven_social_options_callback // Social options section callback - @since 1.0

*/




/**
 * Create the theme options page
 *
 * @since 1.0
 */
function maven_theme_menu() {

	if( current_theme_supports('theme-options') ) {
		add_theme_page(
			__( 'Theme Options', 'digitec' ), 		// The title to be displayed in the browser window for this page.
			__( 'Theme Options', 'digitec' ),			// The text to be displayed for this menu item
			'administrator',										// Which type of users can see this menu item
			'maven_framework',									// The unique ID - that is, the slug - for this menu item
			'maven_framework_display'						// The name of the function to call when rendering this menu's page
		);
	}
}

/**
 * Setup the theme options
 *
 * @since 1.0
 */
function maven_initialize_theme_options() {

	// Get the post types
	$post_types = get_maven_global_options_post_types();

	/**
	 * General options sections
	 */
	if( current_theme_supports('general-theme-options') ) {

		$general_settings = array();

			$general_settings['search_field'] = array(
			'title' => __( 'Hide Search Field', 'digitec' ),
			'type' => 'checkbox'
		);

		$general_settings['posting_header'] = array(
			'title' => '<strong>'.__( 'Posting Options', 'digitec' ).'</strong>'
		);
		$general_settings['show_excerpt'] = array(
			'title' => __( 'Post Archive Excerpt', 'digitec' ),
			'type' => 'radio',
			'options' => array(
				'full' => __( 'Full Text', 'digitec' ),
				'excerpt' => __( 'Excerpt', 'digitec' )
			),
			'default' => 'excerpt',
			'description' => __( 'Select to show the full text or excerpt for archive pages.', 'digitec' ),
			'display' => 'inline'
		);
		$permalinks = get_admin_url( false, 'options-permalink.php' );
		$general_settings['archive_navigation'] = array(
			'title' => __( 'Archive Navigation', 'digitec' ),
			'type' => 'checkbox',
			'options' => array(
				'paginate' => __( 'Use Pagination', 'digitec' )
			),
			'description' => sprintf( __('In order to use pagination, <a href="%s">permalinks</a> must <strong>not be set to Default</strong>.', 'digitec'), $permalinks )
		);
		$general_settings['show_date'] = array(
			'title' => __( 'Show Date', 'digitec' ),
			'type' => 'checkbox',
			'options' => $post_types,
			'display' => 'inline'
		);
		$general_settings['show_author'] = array(
			'title' => __( 'Show Author', 'digitec' ),
			'type' => 'checkbox',
			'options' => $post_types,
			'display' => 'inline'
		);
		$general_settings['show_categories'] = array(
			'title' => __( 'Show Categories', 'digitec' ),
			'type' => 'checkbox',
			'options' => get_maven_global_options_post_types( 'category' ),
			'display' => 'inline'
		);
		$general_settings['show_tags'] = array(
			'title' => __( 'Show Tags', 'digitec' ),
			'type' => 'checkbox',
			'options' => get_maven_global_options_post_types( 'post_tag' ),
			'display' => 'inline'
		);
		$general_settings['allow_comments'] = array(
			'title' => __( 'Show Comments', 'digitec' ),
			'type' => 'checkbox',
			'options' => $post_types,
			'description' => 'Enabled settings may be overridden for individual posts.',
			'display' => 'inline'
		);
		$general_settings['search_results'] = array(
			'title' => __( 'Show in Search Results', 'digitec' ),
			'type' => 'checkbox',
			'options' => $post_types,
			'display' => 'inline'
		);

		$general_settings['archive_buttons_header'] = array(
			'title' => '<strong>'.__( 'Archive Buttons', 'digitec' ).'</strong>'
		);
		$general_settings['post_single_home'] = array(
			'title' => __( 'Post Single Navigation', 'digitec' ),
			'type' => 'text',
			'default' => __( 'Blog home', 'digitec' ),
			'size' => 10,
			'before' => '<strong>'.__( 'Home: ', 'digitec' ).'</strong>',
			'description' => __( 'Set the Post navigation labels.', 'digitec' ),
			'append' => array(
				'post_single_prev' => array(
					'type' => 'text',
					'default' => __( 'Prev post', 'digitec' ),
					'size' => 10,
					'before' => '<strong>'.__( 'Previous: ', 'digitec' ).'</strong>'
				),
				'post_single_next' => array(
					'type' => 'text',
					'default' => __( 'Next post', 'digitec' ),
					'size' => 10,
					'before' => '<strong>'.__( 'Next: ', 'digitec' ).'</strong>'
				)
			)
		);
		$general_settings['project_single_home'] = array(
			'title' => __( 'Project Single Navigation', 'digitec' ),
			'type' => 'text',
			'default' => __( 'Work home', 'digitec' ),
			'size' => 10,
			'before' => '<strong>'.__( 'Home: ', 'digitec' ).'</strong>',
			'description' => __( 'Set the Project navigation labels.', 'digitec' ),
			'append' => array(
				'project_single_prev' => array(
					'type' => 'text',
					'default' => __( 'Prev work', 'digitec' ),
					'size' => 10,
					'before' => '<strong>'.__( 'Previous: ', 'digitec' ).'</strong>'
				),
				'project_single_next' => array(
					'type' => 'text',
					'default' => __( 'Next work', 'digitec' ),
					'size' => 10,
					'before' => '<strong>'.__( 'Next: ', 'digitec' ).'</strong>'
				)
			)
		);
		$general_settings['team_single_home'] = array(
			'title' => __( 'Team Single Navigation', 'digitec' ),
			'type' => 'text',
			'default' => __( 'Team Home', 'digitec' ),
			'size' => 10,
			'before' => '<strong>'.__( 'Home: ', 'digitec' ).'</strong>',
			'description' => __( 'Set the Team navigation labels.', 'digitec' ),
			'append' => array(
				'team_single_prev' => array(
					'type' => 'text',
					'default' => __( 'Prev member', 'digitec' ),
					'size' => 10,
					'before' => '<strong>'.__( 'Previous: ', 'digitec' ).'</strong>'
				),
				'team_single_next' => array(
					'type' => 'text',
					'default' => __( 'Next member', 'digitec' ),
					'size' => 10,
					'before' => '<strong>'.__( 'Next: ', 'digitec' ).'</strong>'
				)
			)
		);

		$general_settings['posttype_header'] = array(
			'title' => '<strong>'.__( 'Custom Post Types', 'digitec' ).'</strong>'
		);
		$general_settings['project_slug'] = array(
			'title' => __( 'Project Slug', 'digitec' ),
			'type' => 'text',
			'default' => 'project',
			'description' => __( 'Set a custom slug for the projects post type. <strong>Update your permalinks after changing!</strong><br/><strong>*Note:</strong> You can not have a page that uses the same slug... this will cause issues!', 'digitec' )
		);
		$general_settings['copyright_text'] = array(
			'title' => __( 'Copyright Text', 'digitec' ),
			'type' => 'textarea',
			'cols' => '80'
		);
		$general_settings['additional_header'] = array(
			'title' => '<strong>'.__( 'Additional Options', 'digitec' ).'</strong>'
		);
		$general_settings['favicon'] = array(
			'title' => __( 'Favicon', 'digitec' ),
			'type' => 'image',
			'description' => __( 'Upload a custom favicon', 'digitec' )
		);
		$general_settings['default_avatar_image'] = array(
			'title' => __( 'Default Avatar Image', 'digitec' ),
			'type' => 'image',
			'description' => __( 'Upload a custom image to use for the default avatar', 'digitec' )
		);
		$general_settings['404_page'] = array(
			'title' => __( 'Select a 404 Page', 'digitec' ),
			'type' => 'select',
			'options' => get_maven_page_array( false ),
			'default' => '404',
			'key_val' => true
		);
		$general_settings['google_analytics'] = array(
			'title' => __( 'Google Analytics Account', 'digitec' ),
			'type' => 'text'
		);

		if( false == get_option('maven_general_options') ) {
			add_option( 'maven_general_options' );
		}

		/* Register the general options */
		add_settings_section(
			'general_settings_section',					// ID used to identify this section and with which to register options
			__( 'General Options', 'digitec' ),		// Title to be displayed on the administration page
			'maven_general_options_callback',		// Callback used to render the description of the section
			'maven_general_options'							// Page on which to add this section of options
		);

		$general_settings = apply_filters( 'maven_general_settings', $general_settings );

		if( is_array($general_settings) ) {
			foreach( $general_settings as $id => $setting ) {
				$setting['option'] = 'maven_general_options';
				$setting['option_id'] = $id;
				$setting['id'] = 'maven_general_options['.$id.']';
				add_settings_field( $setting['id'], $setting['title'], 'm4c_settings_callback', 'maven_general_options', 'general_settings_section', $setting);
			}
		}

		// Register the fields with WordPress
		register_setting( 'maven_general_options', 'maven_general_options' );
	}

	/**
	 * Style options sections
	 */
	if( current_theme_supports('style-theme-options') ) {

		$style_settings = array();

		$style_settings['global_style_header'] = array(
			'title' => '<strong>'.__( 'Global Site Style', 'digitec' ).'</strong>'
		);

		$style_settings['global_style'] = array(
			'title' => __( 'Color', 'digitec' ),
			'type' => 'select',
			'options' => array(
				'default' => __( 'Default - Blue', 'digitec' )
			)
		);

		$style_settings['page_style_header'] = array(
			'title' => '<strong>'.__( 'Default Page Styles', 'digitec' ).'</strong>'
		);

		$style_settings['post'] = array(
			'title' => __( 'Post Style', 'digitec' ),
			'type' => 'select',
			'options' => get_maven_styles(),
			'description' => __( ' Select the default style of posts.', 'digitec' )
		);
		$style_settings['page'] = array(
			'title' => __( 'Page Style', 'digitec' ),
			'type' => 'select',
			'options' => get_maven_styles(),
			'description' => __( ' Select the default style of pages.', 'digitec' )
		);
		if( current_theme_supports('project-postype') ) {
			$style_settings['project'] = array(
				'title' => __( 'Project Style', 'digitec' ),
				'type' => 'select',
				'options' => get_maven_styles(),
				'description' => __( ' Select the default style of projects.', 'digitec' )
			);
		}
		$style_settings['search'] = array(
			'title' => __( 'Search Style', 'digitec' ),
			'type' => 'select',
			'options' => get_maven_styles(),
			'description' => __( ' Select the default style of search pages.', 'digitec' )
		);

		if( false == get_option('maven_style_options') ) {
			add_option( 'maven_style_options' );
		}

		/* Register the style options */
		add_settings_section(
			'style_settings_section',					// ID used to identify this section and with which to register options
			__( 'Style Options', 'digitec' ),		// Title to be displayed on the administration page
			'maven_style_options_callback',		// Callback used to render the description of the section
			'maven_style_options'							// Page on which to add this section of options
		);

		$style_settings = apply_filters( 'maven_style_settings', $style_settings );

		if( is_array($style_settings) ) {
			foreach( $style_settings as $id => $setting ) {
				$setting['option'] = 'maven_style_options';
				$setting['option_id'] = $id;
				$setting['id'] = 'maven_style_options['.$id.']';
				add_settings_field( $setting['id'], $setting['title'], 'm4c_settings_callback', 'maven_style_options', 'style_settings_section', $setting);
			}
		}

		// Register the fields with WordPress
		register_setting( 'maven_style_options', 'maven_style_options' );
	}

	/**
	 * Sidebar options sections
	 */
	if( current_theme_supports('sidebar-theme-options') ) {

		$sidebar_settings = array();

		$sidebar_settings['sidebars'] = array(
			'title' => __( 'Sidebars', 'digitec' ),
			'type' => 'matrix',
			'table_width' => '300px',
			'widths' => array( '100%' ),
			'button' => __( 'Add Sidebar', 'digitec' )
		);

		// If the theme options don't exist, create them.
		if( false == get_option( 'maven_sidebar_options' ) ) {
			add_option( 'maven_sidebar_options' );
		}

		/* Register the custom sidebars */
		add_settings_section(
			'custom_sidebars_section',					// ID used to identify this section and with which to register options
			__( 'Custom Sidebars', 'digitec' ),		// Title to be displayed on the administration page
			'maven_custom_sidebars_callback',		// Callback used to render the description of the section
			'maven_sidebar_options'							// Page on which to add this section of options
		);

		$sidebar_settings = apply_filters( 'maven_sidebar_settings', $sidebar_settings );

		if( is_array($sidebar_settings) ) {
			foreach( $sidebar_settings as $id => $setting ) {
				$setting['option'] = 'maven_sidebar_options';
				$setting['option_id'] = $id;
				$setting['id'] = 'maven_sidebar_options['.$id.']';
				add_settings_field( $setting['id'], $setting['title'], 'm4c_settings_callback', 'maven_sidebar_options', 'custom_sidebars_section', $setting);
			}
		}

		// Register the fields with WordPress
		register_setting( 'maven_sidebar_options', 'maven_sidebar_options' );
	}

	/**
	 * Social options sections
	 */
	if( current_theme_supports('social-theme-options') ) {

		$social_settings = array();

		$social_settings['twitter_share'] = array(
			'title' => __( 'Add Twitter Share', 'digitec' ),
			'type' => 'checkbox',
			'options' => $post_types,
			'display' => 'inline'
		);
		$social_settings['twitter_share_prefix'] = array(
			'title' => __( 'Twitter Share Prefix', 'digitec' ),
			'type' => 'textarea',
			'rows' => 2,
			'default' => __( 'Check out this great article I found: ', 'digitec' ),
			'description' => __( 'Customize the format of the Twitter shares.', 'digitec' )
		);
		$social_settings['facebook_share'] = array(
			'title' => __( 'Add Facebook Share', 'digitec' ),
			'type' => 'checkbox',
			'options' => $post_types,
			'display' => 'inline'
		);
		$social_settings['twitter_link'] = array(
			'title' => __( 'Twitter Link', 'digitec' ),
			'type' => 'text'
		);
		$social_settings['facebook_link'] = array(
			'title' => __( 'Facebook Link', 'digitec' ),
			'type' => 'text'
		);
		$social_settings['google_link'] = array(
			'title' => __( 'Google+ Link', 'digitec' ),
			'type' => 'text'
		);
		$social_settings['linkedin_link'] = array(
			'title' => __( 'LinkedIn Link', 'digitec' ),
			'type' => 'text'
		);

		// If the social options don't exist, create them.
		if( false == get_option('maven_social_options') ) {
			add_option( 'maven_social_options' );
		}

		/* Register the style options */
		add_settings_section(
			'social_settings_section',					// ID used to identify this section and with which to register options
			__( 'Social Options', 'digitec' ),		// Title to be displayed on the administration page
			'maven_social_options_callback',		// Callback used to render the description of the section
			'maven_social_options'							// Page on which to add this section of options
		);

		$social_settings = apply_filters( 'maven_social_settings', $social_settings );

		if( is_array($social_settings) ) {
			foreach( $social_settings as $id => $setting ) {
				$setting['option'] = 'maven_social_options';
				$setting['option_id'] = $id;
				$setting['id'] = 'maven_social_options['.$id.']';
				add_settings_field( $setting['id'], $setting['title'], 'm4c_settings_callback', 'maven_social_options', 'social_settings_section', $setting);
			}
		}

		// Register the fields with WordPress
		register_setting( 'maven_social_options', 'maven_social_options' );
	}
}




/**
 * Render the theme options page
 *
 * @since 1.0
 */
function maven_framework_display( $active_tab = null ) {
	?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">

		<div id="icon-themes" class="icon32"></div>
		<h2><?php echo MAVEN_THEME_NAME; ?> <?php _e( 'Theme Options', 'digitec' ); ?></h2>
		<?php settings_errors(); ?>

		<?php
		if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else if( $active_tab == 'style_options' ) {
			$active_tab = 'style_options';
		} else if( $active_tab == 'sidebar_options' ) {
			$active_tab = 'sidebar_options';
		} else if( $active_tab == 'social_options' ) {
			$active_tab = 'social_options';
		} else {
			if( current_theme_supports('general-theme-options') ) {
				$active_tab = 'general_options';
			} elseif( current_theme_supports('style-theme-options') ) {
				$active_tab = 'style_options';
			} elseif( current_theme_supports('sidebar-theme-options') ) {
				$active_tab = 'sidebar_options';
			} elseif( current_theme_supports('social-theme-options') ) {
				$active_tab = 'social_options';
			}
		}
		?>

		<h2 class="nav-tab-wrapper">
		<?php if( current_theme_supports('general-theme-options') ) { ?>
			<a href="?page=maven_framework&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General', 'digitec' ); ?></a>
		<?php } ?>
		<?php if( current_theme_supports('style-theme-options') ) { ?>
			<a href="?page=maven_framework&tab=style_options" class="nav-tab <?php echo $active_tab == 'style_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Style', 'digitec' ); ?></a>
		<?php } ?>
		<?php if( current_theme_supports('sidebar-theme-options') ) { ?>
			<a href="?page=maven_framework&tab=sidebar_options" class="nav-tab <?php echo $active_tab == 'sidebar_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Sidebars', 'digitec' ); ?></a>
		<?php } ?>
		<?php if( current_theme_supports('social-theme-options') ) { ?>
			<a href="?page=maven_framework&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social', 'digitec' ); ?></a>
		<?php } ?>
		</h2>

		<form method="post" action="options.php">
			<?php

				if( $active_tab == 'general_options' ) {
					settings_fields( 'maven_general_options' );
					do_settings_sections( 'maven_general_options' );

				} elseif( $active_tab == 'style_options' ) {
					settings_fields( 'maven_style_options' );
					do_settings_sections( 'maven_style_options' );

				} elseif( $active_tab == 'sidebar_options' ) {
					settings_fields( 'maven_sidebar_options' );
					do_settings_sections( 'maven_sidebar_options' );
				} else {
					settings_fields( 'maven_social_options' );
					do_settings_sections( 'maven_social_options' );
				} // end if/else

				submit_button();
			?>
		</form>

	</div><!-- /.wrap -->
	<?php
}

/**
 * General options section callback
 *
 * @since 1.0
 */
function maven_general_options_callback() {
	echo '<p>'.__( 'Setup the general aspects of your site.', 'digitec' ).'</p>';
}

/**
 * Style options section callback
 *
 * @since 1.0
 */
function maven_style_options_callback() {
	echo '<p>'.__( 'Select the default styles for each post type.', 'digitec' ).'</p>';
}

/**
 * Custom sidebars section callback
 *
 * @since 1.0
 */
function maven_custom_sidebars_callback() {
	echo '<p>'.__( 'Add custom sidebars to use throughout your site.', 'digitec' ).'</p>';
}

/**
 * Social options section callback
 *
 * @since 1.0
 */
function maven_social_options_callback() {
	echo '<p>'.__( 'Setup global social options for your site.', 'digitec' ).'</p>';
}
