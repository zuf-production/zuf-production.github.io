<?php
/**
 * This is where we put all the media functions.
 *
 * @category Plugins
 * @package  MetaTools
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/plugins/metatools
 **/
 
 
 
 
add_action( 'wp_footer', 'metatools_footer_scripts' );
/**
 * Add scripts to the footer.
 *
 * @since 1.0
 */
function metatools_footer_scripts() {
	?>
	<script>
	jQuery( document ).ready( function() {
		jQuery('video,audio').mediaelementplayer({
			videoVolume: 'horizontal',
			success: function(player, node) {
				//jQuery(node).parents('.mejs-container').css('position','relative');
				//jQuery(node).parents('.mejs-container').append('<p style="position:absolute;z-index:999999;top:20px;left:20px;color:#FFF;background:#000;">Succes (mode: ' + player.pluginType+')</p>');
			}
		});
	});
	</script>
	<?php
}
 
 
 

/**
 * Return values for custom image sizes
 *
 * @since 1.0
 */ 
function get_m4c_image_size( $size ) {
	
	global $_wp_additional_image_sizes;
	
	// Find the image size name
	if( is_array( $size ) ) {
		foreach( $_wp_additional_image_sizes as $key => $image_size ) {
			if( $image_size['width'] == $size[0] && $image_size['height'] == $size[1] ) {
				return $key;
			}			
		}
		return false;
	
	// Or, find the image size dimensions
	} else {	
		if ( isset($_wp_additional_image_sizes[$size]) ) {
			return $_wp_additional_image_sizes[$size];
		}
	}
}
 
 
 

/**
 * Print a timthumb image
 *
 * @since 1.0
 */ 
function m4c_timthumb_image( $path, $size, $attr='' ) {
	
	echo get_m4c_timthumb_image( $path, $size, $attr );
}




/**
 * Return a timthumb image
 *
 * @since 1.0
 */
function get_m4c_timthumb_image( $path, $size, $attr='' ) {

	// Set defaults
	$defaults = array(
		'class' => ''
	);
	$attr = wp_parse_args( $attr, $defaults );
	
	// Set the classes
	$class = ( get_m4c_image_size($size) ) ? 'attachment-'.$size.' '.$attr['class'] : $attr['class'];
	
	// Get the source & dimensions
	$arr = get_m4c_timthumb_image_src( $path, $size );

	return '<img src="'.$arr[0].'" width="'.$arr[1].'" height="'.$arr[2].'" class="'.$class.'" />';
}




/**
 * Return a timthumb image src
 *
 * @since 1.0
 */
function get_m4c_timthumb_image_src( $path, $size ) {
	
	$img=''; $w=''; $h='';
	
	// If this is a custom size
	if ( is_array( $size ) ) {
		$w = $size[0];
		$h = isset( $size[1] ) ? $size[1] : 0;
	} else {
		$custom = get_m4c_image_size( $size );
		$w = $custom['width'];
		$h = $custom['height'];
	}
	
	// If there is no height specified, get it.
	if( $h == 0 ) {
		$size = getimagesize( $path );
		$percent = $w/$size[0];
		$h = floor( $size[1] * $percent );
	}
	
	$src = METATOOLS_TIMTHUMB_URL.'/timthumb.php?src='.$path.'&amp;w='.$w.'&amp;h='.$h;
	
	// Return the source
	return array( $src, $w, $h );
}




/**
 * Echo the appropriate attachment image
 *
 * @since 1.0
 */
function m4c_attachment_image( $attachment_id, $size, $icon=false, $attr='' ) {

	echo get_m4c_attachment_image( $attachment_id, $size, $icon, $attr );
}




/**
 * Get the attachment mime type and return the appropriate image
 *
 * @since 1.0
 */
function get_m4c_attachment_image( $attachment_id, $size, $icon=false, $attr='', $mime_type=false ) {
	
	if( $attachment = get_post($attachment_id) ) {
	
		// If the size is an array, attempt to find the registered name
		if( is_array($size) ) {
			$name = get_m4c_image_size( $size );
			if( $name ) {
				$size = $name;
			}
		}
	
		$mime = ( $mime_type ) ? $mime_type : $attachment->post_mime_type; 
		
		switch ( $mime ) {
			case 'image/jpeg':
				return wp_get_attachment_image( $attachment_id, $size, $icon, $attr );
				break;
				
			case 'image/png':
				return wp_get_attachment_image( $attachment_id, $size, $icon, $attr );
				break;
			
			case 'audio/mpeg':
				// Get the poster image
				$image_id = get_post_meta( $attachment_id, '_attachment_poster_image', true );
				$default = ( !$image_id || $image_id=='none' ) ? true : false;
				return ( $default ) ? get_m4c_default_audio_image( $size, $icon, $attr ) : wp_get_attachment_image( $image_id, $size, $icon, $attr );
				break;
	
			case 'video/mp4':
				// Get the poster image
				$image_id = get_post_meta( $attachment_id, '_attachment_poster_image', true );
				$default = ( !$image_id || $image_id=='none' ) ? true : false;
				return ( $default ) ? get_m4c_default_video_image( $size, $attr ) : wp_get_attachment_image( $image_id, $size, $icon, $attr );
				break;
				
			case 'video/m4v':
				// Get the poster image
				$image_id = get_post_meta( $attachment_id, '_attachment_poster_image', true );
				$default = ( !$image_id || $image_id=='none' ) ? true : false;
				return ( $default ) ? get_m4c_default_video_image( $size, $attr ) : wp_get_attachment_image( $image_id, $size, $icon, $attr );
				break;
			
			case 'vimeo':
				// Create a timthumb image
				$thumb = get_post_meta( $attachment_id, '_video_thumb_large', true );
				return get_m4c_timthumb_image( $thumb, $size, $attr );
				break;
			
			case 'youtube':
				// Create a timthumb image
				$thumb = get_post_meta( $attachment_id, '_video_thumb_large', true );
				return get_m4c_timthumb_image( $thumb, $size, $attr );
				break;
		}
	}
}




/**
 * Get the attachment mime type and return the appropriate source
 *
 * @since 1.0
 */
function get_m4c_attachment_image_src( $attachment_id, $size, $icon=false, $mime_type=false ) {
	
	if( $attachment = get_post($attachment_id) ) {
		
		// If the size is an array, attempt to find the registered name
		if( is_array($size) ) {
			$name = get_m4c_image_size( $size );
			if( $name ) {
				$size = $name;
			}
		}
		
		$mime = ( $mime_type ) ? $mime_type : $attachment->post_mime_type;
		
		switch ( $mime ) {
			case 'image/jpeg':
				return wp_get_attachment_image_src( $attachment_id, $size, $icon );
				break;
				
			case 'image/png':
				return wp_get_attachment_image_src( $attachment_id, $size, $icon );
				break;
			
			case 'audio/mpeg':
				// Get the poster image
				$image_id = get_post_meta( $attachment_id, '_attachment_poster_image', true );
				$default = ( !$image_id || $image_id=='none' ) ? true : false;
				return ( $default ) ? get_m4c_default_audio_image_src( $size ) : wp_get_attachment_image_src( $image_id, $size, $icon );
				break;
	
			case 'video/mp4':
				// Get the poster image
				$image_id = get_post_meta( $attachment_id, '_attachment_poster_image', true );
				$default = ( !$image_id || $image_id=='none' ) ? true : false;
				return ( $default ) ? get_m4c_default_video_image_src( $size ) : wp_get_attachment_image_src( $image_id, $size, $icon );
				break;
				
			case 'video/m4v':
				// Get the poster image
				$image_id = get_post_meta( $attachment_id, '_attachment_poster_image', true );
				$default = ( !$image_id || $image_id=='none' ) ? true : false;
				return ( $default ) ? get_m4c_default_video_image_src( $size ) : wp_get_attachment_image_src( $image_id, $size, $icon );
				break;
			
			case 'vimeo':
				// Create a timthumb image
				$thumb = get_post_meta( $attachment_id, '_video_thumb_large', true );
				return get_m4c_timthumb_image_src( $thumb, $size );
				break;
			
			case 'youtube':
				// Create a timthumb image
				$thumb = get_post_meta( $attachment_id, '_video_thumb_large', true );
				return get_m4c_timthumb_image_src( $thumb, $size );
				break;
		}
	}
}




/**
 * Print the default audio image
 *
 * @since 1.0
 */
function m4c_default_audio_image( $size, $attr='' ) {
	echo get_m4c_default_audio_image( $size, $attr );
}




/**
 * Return the default audio image.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default theme image.
 *
 * @since 1.0
 */
function get_m4c_default_audio_image( $size, $attr='' ) {

	$options = get_option( 'm4c_media_options' );
	$id = ( isset($options['default_audio_image'][0]) ) ? $options['default_audio_image'][0] : false;

	if( $id ) {
	
		return wp_get_attachment_image( $id, $size, false, $attr );
		
	} else {
		
		// Set defaults
		$defaults = array(
			'class' => ''
		);
		$attr = wp_parse_args( $attr, $defaults );
		
		// Get the source & dimensions
		$arr = get_m4c_default_audio_image_src( $size );
	
		// Set the classes
		$class = ( get_m4c_image_size($size) ) ? 'attachment-'.$size.' '.$attr['class'] : $attr['class'];
		
		return '<img src="'.$arr[0].'" width="'.$arr[1].'" height="'.$arr[2].'" class="'.$class.'" />';
	}
}




/**
 * Return the default audio image source.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default theme image.
 *
 * @since 1.0
 */
function get_m4c_default_audio_image_src( $size ) {

	$options = get_option( 'm4c_default_audio_image' );
	$id = ( isset($options[0]) ) ? $options[0] : false;
	
	if( $id ) {
	
		return wp_get_attachment_image_src( $id, $size );
		
	} else {
		
		$src = METATOOLS_IMAGES_URL.'/defaults/default-audio.jpg';
		$src = apply_filters( 'm4c_default_audio_image_src', $src );
		return get_m4c_timthumb_image_src( $src, $size );
	}
}




/**
 * Print an audio attachment.
 *
 * @since 1.0
 */
function m4c_audio( $id, $dimensions ) {

	echo get_m4c_audio( $id, $dimensions );
}




/**
 * Return an audio attachment.
 *
 * @since 1.0
 */
function get_m4c_audio( $id, $dimensions, $class='' ) {
	
	// Set the mediaelement toggle to true
	global $mediaelement;
	$mediaelement = true;
	
	$width = isset( $dimensions ) ? $dimensions[0] : 560;
	$height = isset( $dimensions[1] ) ? $dimensions[1] : ($width/16)*9;
	
	$url = wp_get_attachment_url( $id );
	$mime = get_post_mime_type( $id );
	$poster = get_m4c_attachment_image_src( $id, array($width,$height) );
	$class = ( $class != '' ) ? ' class="'.$class.'"' : '';
	
	return '<audio src="'.$url.'" width="'.$width.'" height="'.$height.'" poster="'.$poster[0].'" type="'.$mime.'" controls="controls"'.$class.'></audio>';
}




/**
 * Print the default video image
 *
 * @since 1.0
 */
function m4c_default_video_image( $size, $attr='' ) {
	echo get_m4c_default_video_image( $size, $attr );
}




/**
 * Return the default video image.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default theme image.
 *
 * @since 1.0
 */
function get_m4c_default_video_image( $size, $attr='' ) {

	$options = get_option( 'm4c_media_options' );
	$id = ( isset($options['default_audio_image'][0]) ) ? $options['default_audio_image'][0] : false;
	
	if( $id ) {
	
		return wp_get_attachment_image( $id, $size, false, $attr );
		
	} else {

		// Set defaults
		$defaults = array(
			'class' => ''
		);
		$attr = wp_parse_args( $attr, $defaults );
		$class = ( get_m4c_image_size($size) ) ? 'attachment-'.$size.' '.$attr['class'] : $attr['class'];
		
		// Get the source & dimensions
		$arr = get_m4c_default_video_image_src( $size );
	
		return '<img src="'.$arr[0].'" width="'.$arr[1].'" height="'.$arr[2].'" class="'.$class.'" />';
	}
}




/**
 * Return the default video image source.
 *
 * Use a user uploaded image is there is one set,
 * or default back to the default theme image.
 *
 * @since 1.0
 */
function get_m4c_default_video_image_src( $size ) {

	$options = get_option( 'm4c_default_video_image' );
	$id = ( isset($options[0]) ) ? $options[0] : false;
	
	if( $id ) {
	
		return wp_get_attachment_image_src( $id, $size );
		
	} else {
		
		$src = METATOOLS_IMAGES_URL.'/defaults/default-video.jpg';
		$src = apply_filters( 'm4c_default_video_image_src', $src );
		return get_m4c_timthumb_image_src( $src, $size );
	}
}




/**
 * Print a video attachment.
 *
 * @since 1.0
 */
function m4c_video( $id, $dimensions ) {

	echo get_m4c_video( $id, $dimensions, $mime );
}




/**
 * Return an video attachment.
 *
 * @since 1.0
 */
function get_m4c_video( $id, $dimensions, $class='' ) {

	// Set the mediaelement toggle to true
	global $mediaelement;
	$mediaelement = true;
	
	$width = isset( $dimensions ) ? $dimensions[0] : 560;
	$height = isset( $dimensions[1] ) ? $dimensions[1] : ($width/16)*9;
	
	$url = wp_get_attachment_url( $id );
	$mime = get_post_mime_type( $id );
	$poster = get_m4c_attachment_image_src( $id, array($width,$height) );
	$class = ( $class != '' ) ? ' class="'.$class.'"' : '';
	
	return '<video width="'.$width.'" height="'.$height.'" src="'.$url.'" type="'.$mime.'" poster="'.$poster[0].'" controls="controls" preload="none"'.$class.'></video>';
}




/**
 * Print a youtube video.
 *
 * @since 1.0
 */
function m4c_youtube( $args='' ) {

	echo get_m4c_youtube( $args );
}




/**
 * Return a youtube video.
 *
 * @since 1.0
 */
function get_m4c_youtube( $args='' ) {

	// Set defaults
	$defaults = array(
		'id' => false,
		'att_id' => false,
		'width' => '560',
		'height' => false,
		'class' => ''
	);
	extract( wp_parse_args( $args, $defaults ) );

	$id = ( $id ) ? $id : get_post_meta( $att_id, '_video_id', true );	

	if( !$height && $att_id ) {	
		$dimensions = get_m4c_youtube_vimeo_dimensions( $att_id, $width );
		$height = $dimensions[1];
	} elseif( !$height ) {
		$height = ($width/16)*9;
	}
	return '<iframe class="youtube '.$class.'" src="http://www.youtube.com/embed/'.$id.'?rel=0&amp;wmode=transparent&amp;showinfo=0" width="'.$width.'" height="'.$height.'"></iframe>';
}




/**
 * Print a vimeo video.
 *
 * @since 1.0
 */
function m4c_vimeo( $args='' ) {

	echo get_m4c_vimeo( $args );
}




/**
 * Return a vimeo video.
 *
 * @since 1.0
 */
function get_m4c_vimeo( $args='' ) {

	// Set defaults
	$defaults = array(
		'id' => false,
		'att_id' => false,
		'width' => '560',
		'height' => false,
		'class' => ''
	);
	extract( wp_parse_args( $args, $defaults ) );
	 
	$id = ( $id ) ? $id : get_post_meta( $att_id, '_video_id', true );	

	if( !$height && $att_id ) {	
		$dimensions = get_m4c_youtube_vimeo_dimensions( $att_id, $width );
		$height = $dimensions[1];
	} elseif( !$height ) {
		$height = ($width/16)*9;
	}
	return '<iframe class="vimeo '.$class.'" src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'"></iframe>';
}




/**
 * Return a youtube or vimeo video dimensions.
 *
 * @since 1.0
 */
function get_m4c_youtube_vimeo_dimensions( $id, $width=false ) {
	
	$video_width = get_post_meta( $id, '_video_width', true );
	$video_height = get_post_meta( $id, '_video_height', true );
	if( $width ) {
		$video_height = ( $width/$video_width ) * $video_height;
		$video_width = $width;
	}
	return array( $video_width, $video_height );
}




add_shortcode( 'video', 'm4c_video_shortcode' );
/**
 * Add a video shortcode
 *
 * @since 1.0
 */
function m4c_video_shortcode( $atts ) {
   extract( shortcode_atts(array(
      'id' => '',
      'width' => '560',
      'height' => '',
      'class' => '',
   ), $atts));

   $dimensions = ( $height == '' ) ? array( $width ) : array( $width, $height );
   
   return get_m4c_video( $id, $dimensions, $class );
}




add_shortcode( 'audio', 'm4c_audio_shortcode' );
/**
 * Add a audio shortcode
 *
 * @since 1.0
 */
function m4c_audio_shortcode( $atts ) {
   extract( shortcode_atts(array(
      'id' => '',
      'width' => '560',
      'height' => '',
      'class' => '',
   ), $atts));

   $dimensions = ( $height == '' ) ? array( $width ) : array( $width, $height );
   
   return get_m4c_audio( $id, $dimensions, $class );
}
