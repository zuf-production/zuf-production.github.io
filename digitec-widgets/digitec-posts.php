<?php

/* Register the widget - @since 1.0 */
add_action( 'widgets_init', 'digitec_posts_widget' );

/**
 * Register the widget
 *
 * @since 1.0
 */
function digitec_posts_widget() {
	register_widget( 'digitec_posts' );
}




/**
 * Create a class for the widget
 *
 * @since 1.0
 */
class digitec_posts extends WP_Widget {
	
/**
 * Widget setup
 *
 * @since 1.0
 */
function digitec_posts() {
	
	// Widget settings
	$widget_ops = array(
		'classname' => 'digitec-posts-widget',
		'description' => __('Displays recent posts.', 'digitec')
	);

	// Widget control settings
	$control_ops = array(
		'id_base' => 'digitec-posts'
	);

	// Create the widget
	$this->WP_Widget( 'digitec-posts', __('Digitec Posts', 'digitec'), $widget_ops, $control_ops );
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
	
	$widget_limit = intval( $instance['widget_limit'] );
	if ( $widget_limit == '' || $widget_limit == 0 ) {
		$widget_limit = 3;
	}
	
	// Before widget (defined by themes)
	echo $before_widget;
	
	// Title of widget (before and after defined by themes)
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}	
	
	$args = array(
		'post_type'=> 'post',
		'posts_per_page' => $widget_limit
	);
	
	// Save the original query & create a new one
	global $wp_query;
	$original_query = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query( $args );
	
	if ( have_posts() ) :
	
	$output = '<ul>';
	
	// Start the Loop
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		$output .= '<li>';
		$output .= '<a class="digitec-posts-widget-title" href="'.get_permalink().'">'.get_the_title().'</a> ';
		$output .= digitec_post_widget_excerpt( 72 );
		$output .= '<br/><a class="digilink" href="'.get_permalink().'">Read more</a> ';
		$output .= '</li>';
		
	endwhile;
	
	$output .= '</ul>';
	
	else :
	endif;
	
	$wp_query = null;
	$wp_query = $original_query;
	wp_reset_postdata();
	
	echo $output;

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
	$instance['widget_limit'] = intval( $new_instance['widget_limit'] );

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
		'title' => 'Blog Posts',
		'widget_limit' => 3
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
  <!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
	</p>
	
  <!-- Widget Limit: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'widget_limit' ); ?>"><?php _e( 'Number of Posts:', 'digitec' ); ?></label><br/>
		<input class="widefat" id="<?php echo $this->get_field_id( 'widget_limit' ); ?>" name="<?php echo $this->get_field_name( 'widget_limit' ); ?>" value="<?php echo $instance['widget_limit']; ?>" style="width:50px;" />
	</p>
	
	<?php
}
}

/**
 * Set a maximum excerpt length
 *
 * @since 1.0
 */
function digitec_post_widget_excerpt( $charlength ) {
	$excerpt = get_the_excerpt();
	$charlength++;
	
	$output = '';
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$output .= mb_substr( $subex, 0, $excut );
		} else {
			$output .= $subex;
		}
		$output .= '&hellip;';
	} else {
		$output .= $excerpt;
	}
	return $output;
}
