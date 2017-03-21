<?php

/* Register the widget - @since 1.0 */
add_action( 'widgets_init', 'digitec_contact_widget' );

/**
 * Register the widget
 *
 * @since 1.0
 */
function digitec_contact_widget() {
	register_widget( 'digitec_contact' );
}




/**
 * Create a class for the widget
 *
 * @since 1.0
 */
class digitec_contact extends WP_Widget {
	
/**
 * Widget setup
 *
 * @since 1.0
 */
function digitec_contact() {
	
	// Widget settings
	$widget_ops = array(
		'classname' => 'digitec-contact-widget',
		'description' => __('Displays contact information.', 'digitec')
	);

	// Widget control settings
	$control_ops = array(
		'id_base' => 'digitec-contact'
	);

	// Create the widget
	$this->WP_Widget( 'digitec-contact', __('Digitec Contact', 'digitec'), $widget_ops, $control_ops );
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

	$email = $instance['email'];
	$telephone = $instance['telephone'];
	$fax = $instance['fax'];
	$address = $instance['address'];
	
	// Before widget (defined by themes)
	echo $before_widget;
	
	// Title of widget (before and after defined by themes)
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}
	
	echo '<ul>';	
	
	// Add contact info
	if( $email != '' || $telephone != '' || $fax != '' ) {
		echo '<li class="digitec-contact-widget-info">';
		if( $email != '' ) {
			echo '<span class="digitec-contact-widget-email"><span class="digitec-contact-widget-title">E</span><a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a></span>';
		}
		if( $telephone != '' ) {
			echo '<span class="digitec-contact-widget-telephone"><span class="digitec-contact-widget-title">T</span>'.$telephone.'</span>';
		}
		if( $fax != '' ) {
			echo '<span class="digitec-contact-widget-fax"><span class="digitec-contact-widget-title">F</span>'.$fax.'</span>';
		}
		echo '</li>';
	}
	
	// Add the address
	if( $address != '' ) {
		echo '<li class="digitec-contact-widget-address">'.nl2br( $address ).'</li>';
	}

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
	$instance['email'] = sanitize_email( $new_instance['email'] );
	$instance['telephone'] = sanitize_text_field( $new_instance['telephone'] );
	$instance['fax'] = sanitize_text_field( $new_instance['fax'] );
	$instance['address'] = esc_textarea( $new_instance['address'] );

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
		'title' => 'Contact',
		'email' => '',
		'telephone' => '',
		'fax' => '',
		'address' => ''
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
  <!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
	</p>
    
  <!-- Email: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:97%;" />
	</p>
	
	<!-- Telephone: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'telephone' ); ?>"><?php _e( 'Telephone:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'telephone' ); ?>" name="<?php echo $this->get_field_name( 'telephone' ); ?>" value="<?php echo $instance['telephone']; ?>" style="width:97%;" />
	</p>
	
	<!-- Fax: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax:', 'digitec' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo $instance['fax']; ?>" style="width:97%;" />
	</p>
	
	<!-- Address: Textarea -->
	<p>
		<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', 'digitec' ); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" style="width:97%;" ><?php echo $instance['address']; ?></textarea>
	</p>
  	
	<?php
}
}
