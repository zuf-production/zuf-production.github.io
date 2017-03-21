<?php

/* Register the widget - @since 1.0 */
add_action( 'widgets_init', 'digitec_twitter_widget' );

/**
 * Register the widget
 *
 * @since 1.0
 */
function digitec_twitter_widget() {
	register_widget( 'digitec_twitter' );
}




/**
 * Create a class for the widget
 *
 * @since 1.0
 */
class digitec_twitter extends WP_Widget {
	
/**
 * Widget setup
 *
 * @since 1.0
 */
function digitec_twitter() {
	
	// Widget settings
	$widget_ops = array(
		'classname' => 'digitec-twitter-widget',
		'description' => __('Displays a users latest twitter comments.', 'digitec')
	);

	// Widget control settings
	$control_ops = array(
		'id_base' => 'digitec-twitter'
	);

	// Create the widget
	$this->WP_Widget( 'digitec-twitter', __('Digitec Twitter', 'digitec'), $widget_ops, $control_ops );
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
	
	$widget_limit = intval( $instance['widget_limit'] );
	if ( $widget_limit == '' || $widget_limit == 0 ) {
		$widget_limit = 3;
	}
	
	$twitter_image = isset( $instance['widget_image'] );
	
	// Before widget (defined by themes)
	echo $before_widget;
	
	// Title of widget (before and after defined by themes)
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}	
	
	// Display the twitter feed
	digitec_twitter_feed( $twitter_name, $widget_limit, $twitter_image );

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
	$instance['widget_limit'] = intval( $new_instance['widget_limit'] );
	$instance['widget_image'] = $new_instance['widget_image'];

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
		'title' => 'Recent Tweets',
		'twitter_name' => '',
		'widget_limit' => 3,
		'widget_image' => ''
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
	
  <!-- Widget Limit: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'widget_limit' ); ?>"><?php _e( 'Number of Tweets:', 'digitec' ); ?></label><br/>
		<input class="widefat" id="<?php echo $this->get_field_id( 'widget_limit' ); ?>" name="<?php echo $this->get_field_name( 'widget_limit' ); ?>" value="<?php echo $instance['widget_limit']; ?>" style="width:50px;" />
	</p>
	
	<!-- Display Widget Image: Checkbox -->
	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['widget_image'], 'on' ); ?> id="<?php echo $this->get_field_id( 'widget_image' ); ?>" name="<?php echo $this->get_field_name( 'widget_image' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'widget_image' ); ?>"><?php _e( 'Show Avatar?', 'digitec' ); ?></label>
	</p>
	
	<?php
}
}




/**
 * Display the feed 
 *
 * @since 1.3
 */
function digitec_twitter_feed( $twitter_name, $widget_limit, $twitter_image ) {

	if ( $twitter_name != "" ) {
		
		// Create variables for the cache file and cache time
		$cachefile = dirname( __FILE__ ).'/cache/' . $twitter_name . '-twitter-cache';
		$cachetime = 600;
		
		// if the file exists & the time it was created is less then cache time
		if ( (file_exists($cachefile)) && ( time() - $cachetime < filemtime($cachefile) ) ) {
			
			// Get the cache file contents & display the feed
			$twitter_feed = file_get_contents( $cachefile );
			digitec_display_twitter_feed( $twitter_feed, $widget_limit, $twitter_image );
			
		} else {
		
			// Turn on output buffering
			ob_start();

			// Save the feed
			$twitter_feed = digitec_get_twitter_feed( $twitter_name );
			
			// If errors, use old file
			if ( digitec_check_twitter_error($twitter_feed) ) {
				
				// Get the cache file contents & display the feed
				if ( (file_exists($cachefile)) ) {
					$twitter_feed = file_get_contents( $cachefile );
					
					// Resave the feed to reset the cache time
					$fp = fopen( $cachefile, 'w' );
					fwrite( $fp, $twitter_feed );
					fclose( $fp );
					
					digitec_display_twitter_feed( $twitter_feed, $widget_limit, $twitter_image );	
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
				digitec_display_twitter_feed( $twitter_feed, $widget_limit, $twitter_image );
			
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
function digitec_get_twitter_feed( $twitter_name ) {
	
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
function digitec_check_twitter_error( $twitter_feed ) {

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
function digitec_display_twitter_feed( $twitter_feed, $widget_limit, $twitter_image ) {
	
	// Store the data in a variable
	$output = "<ul>";
	
	// If the feed is not empty
	if( !empty($twitter_feed) ) {
		
		// Save the data as json data
		$json_data = json_decode( $twitter_feed, true );
		
		// Create a limit variable
		$limit = sizeof( $json_data );
		if ( $widget_limit < $limit ) {
			$limit = $widget_limit;
		}
			
		if ( isset($json_data['error']) ) {
			$output .= '<li>'.$json_data['error'].'</li>';
		} elseif ( isset($json_data['errors']) ) {
			foreach( $json_data['errors'] as $error ) {
				$output .= '<li>Error '.$error['code'].': '.$error['message'].'</li>';
			}	
		} else {
			
			// Loop through the tweets
			for ( $i=0; $i < $limit; $i++ ) {
		
				$twitter_name = $json_data[$i]['user']['screen_name'];
				$twitter_avatar = $json_data[$i]['user']['profile_image_url'];
				$twitter_text = $json_data[$i]['text'];
				$twitter_date = $json_data[$i]['created_at'];
				$twitter_id = $json_data[$i]['id_str'];

				$output .= '<li>';
				$output .= '<span class="digitec-twitter-widget-image">';
				if( $twitter_image ) {
					$output .= '<img src="'.$twitter_avatar.'" />';
				}	
				$output .= '</span>';		
				$output .= '"'.digitec_convert_twitter_links( $twitter_text ).'"<span class="digitec-twitter-widget-date">'.human_time_diff( strtotime($twitter_date), current_time('timestamp') ).' ago</span>';
				$output .= '</li>';	
			}
		}
	} else {
		$output .= '<li><p>Sorry, but there was a problem connecting to the API.</p></li>';
	}
	$output .= '</ul>';
	
	echo $output;
}