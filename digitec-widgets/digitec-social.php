<?php

/* Register the widget - @since 1.0 */
add_action( 'widgets_init', 'digitec_social_widget' );

/**
 * Register the widget
 *
 * @since 1.0
 */
function digitec_social_widget() {
	register_widget( 'digitec_social' );
}




/**
 * Create a class for the widget
 *
 * @since 1.0
 */
class digitec_social extends WP_Widget {
	
/**
 * Widget setup
 *
 * @since 1.0
 */
function digitec_social() {
	
	// Widget settings
	$widget_ops = array(
		'classname' => 'digitec-social-widget',
		'description' => __('Displays social links and twitter feed.', 'digitec')
	);

	// Widget control settings
	$control_ops = array(
		'id_base' => 'digitec-social'
	);

	// Create the widget
	$this->WP_Widget( 'digitec-social', __('Digitec Social', 'digitec'), $widget_ops, $control_ops );
}

/**
 * Display the widget
 *
 * @since 1.0
 */
function widget( $args, $instance ) {
	
	extract( $args );

	// User-selected settings	
	$title = $instance['title'];
	$title = apply_filters( 'widget_title', $title );
	
	$twitter_name = sanitize_text_field( $instance['twitter_name'] );
	$twitter = esc_url( $instance['twitter_link'] );
	$facebook = esc_url( $instance['facebook_link'] );
	$google = esc_url( $instance['google_link'] );
	$linkedin = esc_url( $instance['linkedin_link'] );

	$twitter_image = isset( $instance['widget_image'] );
	
	// Before widget (defined by themes)
	echo $before_widget;
	
	// Title of widget (before and after defined by themes)
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}
	
	echo '<ul>';	
	
	// Add Social Info
	if( $twitter != '' || $facebook != '' || $google != '' || $linkedin != '' ) {
		echo '<li class="digitec-social-widget-links clearfix">';
		if( $twitter != '' ) {
			echo '<a class="twitter-link social-link hover-anim" href="'.$twitter.'"><span></span></a>';
		}
		if( $facebook != '' ) {
			echo '<a class="facebook-link social-link hover-anim" href="'.$facebook.'"><span></span></a>';
		}
		if( $google != '' ) {
			echo '<a class="google-link social-link hover-anim" href="'.$google.'"><span></span></a>';
		}
		if( $linkedin != '' ) {
			echo '<a class="linkedin-link social-link hover-anim" href="'.$linkedin.'"><span></span></a>';
		}
		echo '</li>';
	}
	
	// Display the twitter feed
	digitec_social_feed( $twitter_name );
	
	echo '</ul>';

	// After widget (defined by themes)
	echo $after_widget;
}

/**
 * Update the widget
 *
 * @since 1.0
 */
function update( $new_instance, $old_instance ) {
	
	$instance = $old_instance;

	// Strip tags (if needed) and update the widget settings
	$instance['title'] = sanitize_text_field( $new_instance['title'] );
	$instance['twitter_name'] = sanitize_text_field( strip_tags($new_instance['twitter_name']) );
	$instance['twitter_link'] = esc_url( $new_instance['twitter_link'] );
	$instance['facebook_link'] = esc_url( $new_instance['facebook_link'] );
	$instance['google_link'] = esc_url( $new_instance['google_link'] );
	$instance['linkedin_link'] = esc_url( $new_instance['linkedin_link'] );

	return $instance;
}

/**
 * Widget settings
 *
 * @since 1.0
 */
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'Get Social',
		'twitter_name' => '',
		'twitter_link' => '',
		'facebook_link' => '',
		'google_link' => '',
		'linkedin_link' => ''
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
  <!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
	</p>
    
  <!-- Twitter Username: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'twitter_name' ); ?>"><?php _e( 'Twitter Username:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_name' ); ?>" name="<?php echo $this->get_field_name( 'twitter_name' ); ?>" value="<?php echo $instance['twitter_name']; ?>" style="width:97%;" />
	</p>
	
	<!-- Twitter Link: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'twitter_link' ); ?>"><?php _e( 'Twitter Link:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_link' ); ?>" name="<?php echo $this->get_field_name( 'twitter_link' ); ?>" value="<?php echo $instance['twitter_link']; ?>" style="width:97%;" />
	</p>
	
	<!-- Facebook Link: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'facebook_link' ); ?>"><?php _e( 'Facebook Link:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_link' ); ?>" name="<?php echo $this->get_field_name( 'facebook_link' ); ?>" value="<?php echo $instance['facebook_link']; ?>" style="width:97%;" />
	</p>
	
	<!-- Google Link: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'google_link' ); ?>"><?php _e( 'Google+ Link:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'google_link' ); ?>" name="<?php echo $this->get_field_name( 'google_link' ); ?>" value="<?php echo $instance['google_link']; ?>" style="width:97%;" />
	</p>
	
	<!-- LinkedIn Link: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'linkedin_link' ); ?>"><?php _e( 'LinkedIn Link:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_link' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_link' ); ?>" value="<?php echo $instance['linkedin_link']; ?>" style="width:97%;" />
	</p>
  	
	<?php
}
}




/**
 * Display the feed 
 *
 * @since 1.3
 */
function digitec_social_feed( $twitter_name ) {

	if ( $twitter_name != "" ) {
		
		// Create variables for the cache file and cache time
		$cachefile = dirname( __FILE__ ).'/cache/' . $twitter_name . '-twitter-cache';
		$cachetime = 600;
		
		// if the file exists & the time it was created is less then cache time
		if ( (file_exists($cachefile)) && ( time() - $cachetime < filemtime($cachefile) ) ) {
			
			// Get the cache file contents & display the feed
			$twitter_feed = file_get_contents( $cachefile );
			digitec_display_social_feed( $twitter_feed );
			
		} else {
		
			// Turn on output buffering
			ob_start();

			// Save the feed
			$twitter_feed = digitec_get_social_feed( $twitter_name );
			
			// If errors, use old file
			if ( digitec_check_social_error($twitter_feed) ) {
				
				// Get the cache file contents & display the feed
				if ( (file_exists($cachefile)) ) {
					$twitter_feed = file_get_contents( $cachefile );
					
					// Resave the feed to reset the cache time
					$fp = fopen( $cachefile, 'w' );
					fwrite( $fp, $twitter_feed );
					fclose( $fp );
					
					digitec_display_social_feed( $twitter_feed );	
				}
			
			// Else populate updated data
			} else {
	
				// Create or open the cache file
				$fp = fopen( $cachefile, 'w' );
				
				// Write the twitter feed to the cache file
				fwrite( $fp, $twitter_feed );
				
				// Close the file
				fclose( $fp );

				// Display the twitter feed
				digitec_display_social_feed( $twitter_feed );
			
			}
			
			// End and close the output buffer
			ob_end_flush();
		}
	}
}

/**
 * Use curl to get the feed
 *
 * @since 1.1
 */
function digitec_get_social_feed( $twitter_name ) {
	
	// Set the limit
	$limit = '31';
	
	$ch = curl_init();
	@curl_setopt( $ch, CURLOPT_URL, 'http://api.twitter.com/1/statuses/user_timeline/'.$twitter_name.'.json?count='.$limit.'&include_rts=true&callback=?' );
	@curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
	@curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	
	// Save the data
	$json = curl_exec( $ch );
	curl_close( $ch );
	
	// Return the data
	return $json;
}

/**
 * Check for twitter errors
 *
 * @since 1.1
 */
function digitec_check_social_error( $twitter_feed ) {

	$error = false;
	
	// Save the data as json data
	$json_data = json_decode( $twitter_feed, true );
	
	if( empty($twitter_feed) ) {
		$error = true;
	} else {
		if ( isset($json_data['error']) || isset($json_data['errors']) ) {
			$error = true;
		}
	}
	return $error;
}

/**
 * Display the feed on th site
 *
 * @since 1.1
 */
function digitec_display_social_feed( $twitter_feed ) {
	
	// Store the data in a variable
	$output = '';
	
	// If the feed is not empty
	if( !empty($twitter_feed) ) {
		
		// Save the data as json data
		$json_data = json_decode( $twitter_feed, true );

		if ( isset($json_data['error']) ) {
			$output .= '<li>'.$json_data['error'].'</li>';
		} elseif ( isset($json_data['errors']) ) {
			foreach( $json_data['errors'] as $error ) {
				$output .= '<li>Error '.$error['code'].': '.$error['message'].'</li>';
			}	
		} else {
			
			// Loop through the tweets
			for ( $i=0; $i < 1; $i++ ) {
		
				$twitter_name = $json_data[$i]['user']['screen_name'];
				$twitter_avatar = $json_data[$i]['user']['profile_image_url'];
				$twitter_text = $json_data[$i]['text'];
				$twitter_date = $json_data[$i]['created_at'];
				$twitter_id = $json_data[$i]['id_str'];

				$output .= '<li>';
				$output .= '<span class="digitec-social-widget-title">Recent Tweet</span>';	
				$output .= '"'.digitec_convert_twitter_links( $twitter_text ).'" <span class="digitec-social-widget-date">'.human_time_diff( strtotime($twitter_date), current_time('timestamp') ).' ago</span>';
				$output .= '</li>';	
			}
		}
	} else {
		$output .= '<li><p>Sorry, but there was a problem connecting to the API.</p></li>';
	}
	
	echo $output;
}