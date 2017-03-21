<?php
/**
 * This is where we put all the admin specific media functions.
 *
 * @category Plugins
 * @package  MetaTools
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/plugins/metatools
 **/




add_filter( 'get_media_item_args', 'm4c_media_item_args' );
/**
 * Modify the media item args
 *
 * @since 1.0
 */
function m4c_media_item_args( $args ) {	
	$args['send'] = true;
	return $args;
}
 
  
 
 
add_filter( 'upload_mimes', 'm4c_mime_types' );
/**
 * Add custom mime types
 *
 * @since 1.0
 */
function m4c_mime_types( $existing_mimes=array() ) {
 
	// add your ext => mime to the array
	$existing_mimes['vimeo'] = 'mime/type';
	$existing_mimes['youtube'] = 'mime/type';

	// and return the new full result
	return $existing_mimes; 
}




/*
 * For future use. Need to figure out why filtered Vimeo
 * & YouTube videos are not showing up.
 *
add_filter('post_mime_types', 'modify_post_mime_types');
**
 * Add custom mime filters
 *
 * @since 1.0
 *
function modify_post_mime_types($post_mime_types) {
    $post_mime_types['vimeo'] = array(__('Vimeo'), __('Manage Vimeo'), _n_noop('Vimeo <span class="count">(%s)</span>', 'Vimeo <span class="count">(%s)</span>'));
    $post_mime_types['youtube'] = array(__('YouTube'), __('Manage YouTube'), _n_noop('YouTube <span class="count">(%s)</span>', 'YouTube <span class="count">(%s)</span>'));
    return $post_mime_types;
}
*/




if( get_option('m4c_custom_mime_type_icons') ) {

	add_filter( 'icon_dir', 'm4c_icon_directory' );
	/**
	 * Set a custom media icon directory
	 *
	 * @since 1.0
	 */
	function m4c_icon_directory( $icon_dir ) {
		return METATOOLS_IMAGES_DIR.'/media-icons';
	}
}




add_filter( 'icon_dir_uri', 'm4c_icon_uri' );
/**
 * Set a custom media icon directory uri
 *
 * @since 1.0
 */
function m4c_icon_uri( $icon_dir ) {
	return METATOOLS_IMAGES_URL.'/media-icons';
}




add_filter( 'media_upload_tabs', 'm4c_upload_tabs' );
/**
 * Add custom tabs to the media uploader
 * and re-order the existing tabs
 *
 * @since 1.0
 */
function m4c_upload_tabs($tabs) {
	
	$m4c_tabs = array(
		'type' => __('From Computer', 'digitec'),
		'type_url' => __('From URL', 'digitec'),
		'vimeo_youtube' => __('Vimeo/YouTube', 'digitec'),
		'gallery' => __('Gallery', 'digitec'),
		'library' => __('Media Library', 'digitec')
	);

	return $m4c_tabs;
}




add_action( 'media_upload_vimeo_youtube', 'm4c_vimeo_youtube_iframe' );
/**
 * Create the Vimeo/YouTube uploader iframe
 *
 * @since 1.0
 */
function m4c_vimeo_youtube_iframe() {
	return wp_iframe( 'm4c_upload_vimeo_youtube_form' );
}




/**
 * Create the Vimeo/YouTube uploader form
 *
 * @since 1.0
 */
function m4c_upload_vimeo_youtube_form() {
	echo media_upload_header();
  ?>
	<form enctype="multipart/form-data" method="post" action="" id="m4c-video-form">
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'm4c_ajax_file_nonce' ); ?>">
		<h3 class="media-title"><?php _e('Link a video from Vimeo or YouTube', 'digitec'); ?></h3>
		<div id="media-items">
			<div class="media-item media-blank">
				<p class="media-types"><label><input type="radio" name="video_type" value="vimeo" id="vimeo-select" checked="checked"> <?php _e('Vimeo', 'digitec'); ?></label> &nbsp; &nbsp; <label><input type="radio" name="video_type" value="youtube" id="youtube-select"> <?php _e('YouTube', 'digitec'); ?></label></p>
				<table class="describe ">
					<tbody>
						<tr>
							<th valign="top" scope="row" class="label" style="width:130px;">
								<span class="alignleft"><label for="src"><?php _e('Video ID', 'digitec'); ?></label></span>
								<span class="alignright"><abbr id="status_img" title="required" class="required">*</abbr></span>
							</th>
							<td class="field"><input id="video_id" name="video_id" value="" type="text" aria-required="true"></td>
						</tr>
						<tr>
							<td></td>
							<td class="clearfix">
								<input style="float:left;margin-right:5px;" type="button" class="button" id="m4c-add-video" value="<?php _e('Add Video', 'digitec'); ?>">
								<?php m4c_loading_gif('light','display:block;float:left;padding-top:4px;opacity:0;'); ?>
							</td>
						</tr>
						<tr id="m4c-video-error-message" style="display:none;">
							<td></td>
							<td><div id="message" style="margin-left:0;margin-right:0;" class="error"><p><strong><?php _e('Video does not exist', 'digitec'); ?>!</strong></p></div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
	<?php
}




/**
 * Get Vimeo data via the Vimeo API
 *
 * @since 1.0
 */
function get_m4c_vimeo_data( $id ) {
	
	$curl = m4c_curl_get( 'http://vimeo.com/api/v2/video/'.$id.'.json' );
	$vimeo = json_decode( $curl, true );

	if ( $vimeo ) {
		$data = array();
		$data['title'] = $vimeo[0]['title'];
		$data['description'] = $vimeo[0]['description'];
		$data['width'] = $vimeo[0]['width'];
		$data['height'] = $vimeo[0]['height'];
		$data['thumbnail_small'] = $vimeo[0]['thumbnail_small'];
		$data['thumbnail_medium'] = $vimeo[0]['thumbnail_medium'];
		$data['thumbnail_large'] = $vimeo[0]['thumbnail_large'];
		return $data;
	} else {
		return false;
	}
}




/**
 * Get YouTube data via the YouTube API
 *
 * @since 1.0
 */
function get_m4c_youtube_data( $id ) {

	$curl = m4c_curl_get( 'http://gdata.youtube.com/feeds/api/videos/'.$id.'?v=2&alt=jsonc' );
	$youtube = json_decode( $curl, true );
	
	if ( isset( $youtube['data'] ) ) {
		$data = array();
		$data['title'] = $youtube['data']['title'];
		$data['description'] = $youtube['data']['description'];
		$data['aspectRatio'] = $youtube['data']['aspectRatio'];
		if ( $youtube['data']['aspectRatio'] == 'widescreen' ) {
			$data['width'] = '560';
			$data['height'] = '345';
		} else {
			$data['width'] = '400';
			$data['height'] = '330';
		}
		$data['thumbnail_default'] = $youtube['data']['thumbnail']['sqDefault'];
		$data['thumbnail_hq'] = $youtube['data']['thumbnail']['hqDefault'];
		return $data;
	} else {
		return false;
	}
}




/**
 * Add a curl helper for APIs
 *
 * @since 1.0
 */
function m4c_curl_get( $url ) {
	$curl = curl_init( $url );
	@curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	@curl_setopt( $curl, CURLOPT_TIMEOUT, 30 );
	@curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
	$return = curl_exec( $curl );
	curl_close( $curl );
	return $return;
}




add_action( 'wp_ajax_m4c_insert_vimeo_attachment', 'm4c_insert_vimeo_attachment' );
/**
 * Ajax function used to insert Vimeo attachments
 *
 * @since 1.0
 */
function m4c_insert_vimeo_attachment() {
	
	// Get access to the database
	global $wpdb;
	
	// Check the nonce
	check_ajax_referer( 'm4c_ajax_file_nonce', 'security' );
	
	// Get variables
	$file_id  = $_POST['file_id'];
	$post_id  = $_POST['post_id'];

	// Get the vimeo data
	$vimeo = get_m4c_vimeo_data( $file_id );
	
	// If the video exists
	if( $vimeo ) {
		$attachment = array(
	     'guid' => $file_id, 
	     'post_mime_type' => 'vimeo',
	     'post_title' => $vimeo['title'],
	     'post_content' => $vimeo['description'],
	     'post_status' => 'inherit'
	  );
		
		$id = wp_insert_attachment( $attachment, $vimeo['title'], $post_id );
		update_post_meta( $id, '_video_id', $file_id );
		update_post_meta( $id, '_video_width', $vimeo['width'] );
		update_post_meta( $id, '_video_height', $vimeo['height'] );
		update_post_meta( $id, '_video_thumb_small', $vimeo['thumbnail_small'] );
		update_post_meta( $id, '_video_thumb_medium', $vimeo['thumbnail_medium'] );
		update_post_meta( $id, '_video_thumb_large', $vimeo['thumbnail_large'] );
		
		echo __('Vimeo video added!', 'digitec');
	} else {
		echo __('Does not exist', 'digitec');
	}

	die(); // this is required to return a proper result
}




add_action( 'wp_ajax_m4c_insert_youtube_attachment', 'm4c_insert_youtube_attachment' );
/**
 * Ajax function used to insert YouTube attachments
 *
 * @since 1.0
 */
function m4c_insert_youtube_attachment() {
	
	// Get access to the database
	global $wpdb;
	
	// Check the nonce
	check_ajax_referer( 'm4c_ajax_file_nonce', 'security' );
	
	// Get variables
	$file_id  = $_POST['file_id'];
	$post_id  = $_POST['post_id'];
	
	// Get the vimeo data
	$youtube = get_m4c_youtube_data( $file_id );

	// If the video exists
	if( $youtube ) {
		$attachment = array(
	     'guid' => $file_id, 
	     'post_mime_type' => 'youtube',
	     'post_title' => $youtube['title'],
	     'post_content' => $youtube['description'],
	     'post_status' => 'inherit'
	  );
	
		$id = wp_insert_attachment( $attachment, $youtube['title'], $post_id );
		update_post_meta( $id, '_video_id', $file_id );
		update_post_meta( $id, '_video_aspect', $youtube['aspectRatio'] );
		update_post_meta( $id, '_video_width', $youtube['width'] );
		update_post_meta( $id, '_video_height', $youtube['height'] );
		update_post_meta( $id, '_video_thumb_small', $youtube['thumbnail_default'] );
		update_post_meta( $id, '_video_thumb_large', $youtube['thumbnail_hq'] );
		
		echo __('YouTube video added!', 'digitec');
	} else {
		echo __('Does not exist', 'digitec');
	}

	die(); // this is required to return a proper result
}




add_filter( 'attachment_fields_to_edit', 'm4c_fields_to_edit', null, 2 );
/**
 * Add, remove and modify attachment fields
 *
 * @since 1.0
 */
function m4c_fields_to_edit( $form_fields, $post ) {

	/**
	 * Custom fields for uploaded audio & video files
	 *
	 * @since 1.0
	 */  
	if( substr($post->post_mime_type, 0, 5) == 'audio' || substr($post->post_mime_type, 0, 5) == 'video' ){
	
		$attachment_poster_image = get_post_meta( $post->ID, '_attachment_poster_image', true );
	
		// Get all images for the post parent
		$parent = $post->post_parent;
		$args = array(
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_type'      => 'attachment',
			'post_parent'    => $parent,
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
		);
		$attachments = get_posts( $args );
		$img_options = "<option value='none' selected='selected'>".__('None', 'digitec')."</option>";
		if ($attachments) {
	    foreach ($attachments as $attachment) {
	    	$id = $attachment->ID;
	    	$title = $attachment->post_title;
	    	if( $attachment_poster_image == $id ) {
    			$img_options .= "<option value='{$id}' selected='selected'>{$title}</option>";
		    } else {
		    	$img_options .= "<option value='{$id}'>{$title}</option>";
	    	}
			}
		}
	
		$form_fields["attachment_poster_image"]["label"] = __('Poster Image', 'digitec');  
		$form_fields["attachment_poster_image"]["input"] = "html";  
		$form_fields["attachment_poster_image"]["html"] = " 
		<select name='attachments[{$post->ID}][attachment_poster_image]' id='attachments[{$post->ID}][attachment_poster_image]'>{$img_options}</select>"; 
	}  
	
	/**
	 * Custom fields for vimeo videos
	 *
	 * @since 1.0
	 */ 
	if( $post->post_mime_type == 'vimeo' ){
	
		$video_width = get_post_meta( $post->ID, '_video_width', true );
		$video_height = get_post_meta( $post->ID, '_video_height', true );
		$video_thumb_small = get_post_meta( $post->ID, '_video_thumb_small', true );
		$video_thumb_medium = get_post_meta( $post->ID, '_video_thumb_medium', true );
		$video_thumb_large = get_post_meta( $post->ID, '_video_thumb_large', true );
		
		$form_fields["video_width"]["label"] = __('Width', 'digitec');  
		$form_fields["video_width"]["input"] = "html";  
		$form_fields["video_width"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_width]' value='".$video_width."'>";
		
		$form_fields["video_height"]["label"] = __('Height', 'digitec');  
		$form_fields["video_height"]["input"] = "html";  
		$form_fields["video_height"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_height]' value='".$video_height."'>";
		
		$form_fields["video_thumb_small"]["label"] = __('Small Thumbnail', 'digitec');  
		$form_fields["video_thumb_small"]["input"] = "html";  
		$form_fields["video_thumb_small"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_thumb_small]' value='".$video_thumb_small."'>";
		
		$form_fields["video_thumb_medium"]["label"] = __('Medium Thumbnail', 'digitec');  
		$form_fields["video_thumb_medium"]["input"] = "html";  
		$form_fields["video_thumb_medium"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_thumb_medium]' value='".$video_thumb_medium."'>";
		
		$form_fields["video_thumb_large"]["label"] = __('Large Thumbnail', 'digitec');  
		$form_fields["video_thumb_large"]["input"] = "html";  
		$form_fields["video_thumb_large"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_thumb_large]' value='".$video_thumb_large."'>";
		
		// Remove the excerpt & image url
		unset($form_fields['post_excerpt']);
		unset($form_fields['image_url']);
		unset($form_fields['url']);
	}
	
	/**
	 * Custom fields for youtube videos
	 *
	 * @since 1.0
	 */ 
	if( $post->post_mime_type == 'youtube' ){
		
		$video_aspect = get_post_meta( $post->ID, '_video_aspect', true );
		$video_width = get_post_meta( $post->ID, '_video_width', true );
		$video_height = get_post_meta( $post->ID, '_video_height', true );	
		$video_thumb_small = get_post_meta( $post->ID, '_video_thumb_small', true );
		$video_thumb_large = get_post_meta( $post->ID, '_video_thumb_large', true );
		
		$form_fields["video_aspect"]["label"] = __('Aspect Ratio', 'digitec');  
		$form_fields["video_aspect"]["input"] = "html";  
		$form_fields["video_aspect"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_aspect]' value='".$video_aspect."'>";
		
		$form_fields["video_width"]["label"] = __('Width', 'digitec');  
		$form_fields["video_width"]["input"] = "html";  
		$form_fields["video_width"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_width]' value='".$video_width."'>";
		
		$form_fields["video_height"]["label"] = __('Height', 'digitec');  
		$form_fields["video_height"]["input"] = "html";  
		$form_fields["video_height"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_height]' value='".$video_height."'>";
		
		$form_fields["video_thumb_small"]["label"] = __('Small Thumbnail', 'digitec');  
		$form_fields["video_thumb_small"]["input"] = "html";  
		$form_fields["video_thumb_small"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_thumb_small]' value='".$video_thumb_small."'>";
		
		$form_fields["video_thumb_large"]["label"] = __('Large Thumbnail', 'digitec');  
		$form_fields["video_thumb_large"]["input"] = "html";  
		$form_fields["video_thumb_large"]["html"] = "<input type='text' class='text' readonly='readonly' name='attachments[{$post->ID}][video_thumb_large]' value='".$video_thumb_large."'>";
		
		// Remove the excerpt & image url
		unset($form_fields['post_excerpt']);
		unset($form_fields['image_url']);
		unset($form_fields['url']);
	}
    
  return $form_fields;
}




add_filter( 'attachment_fields_to_save', 'm4c_fields_to_save', null, 2 );
/**
 * Save the custom attachment fields
 *
 * @since 1.0
 */
function m4c_fields_to_save( $post, $attachment ) {  
	
	if( isset($attachment['attachment_poster_image']) ) {
		update_post_meta( $post['ID'], '_attachment_poster_image', $attachment['attachment_poster_image'] );
	}	
	if( isset($attachment['video_aspect']) ) {
		update_post_meta( $post['ID'], '_video_aspect', $attachment['video_aspect'] );
	}
	if( isset($attachment['video_width']) ) {
		update_post_meta( $post['ID'], '_video_width', $attachment['video_width'] );
	}
	if( isset($attachment['video_height']) ) {
		update_post_meta( $post['ID'], '_video_height', $attachment['video_height'] );
	}
	if( isset($attachment['video_thumb_small']) ) {
		update_post_meta( $post['ID'], '_video_thumb_small', $attachment['video_thumb_small'] );
	}
	if( isset($attachment['video_thumb_medium']) ) {
		update_post_meta( $post['ID'], '_video_thumb_medium', $attachment['video_thumb_medium'] );
	}
	if( isset($attachment['video_thumb_large']) ) {
		update_post_meta( $post['ID'], '_video_thumb_large', $attachment['video_thumb_large'] );
	}
        
  return $post;  
}  




add_filter( 'media_send_to_editor', 'm4c_send_to_editor', 10, 3 );
/**
 * Check for Vimeo or YouTube attachments to insert shortcodes
 *
 * @since 1.0
 */
function m4c_send_to_editor( $html, $send_id, $attachment ) { 

	$attachment = get_post( $send_id );
	$mime = $attachment->post_mime_type;
	$id = get_post_meta( $send_id, '_video_id', true );

	if( $mime=='vimeo' ) {
		$html = '[embed title="'.$attachment->post_title.'"]http://vimeo.com/'.$id.'[/embed]';
	} elseif( $mime=='youtube') {
		$html = '[embed title="'.$attachment->post_title.'"]http://www.youtube.com/watch?v='.$id.'[/embed]';
	} elseif( $mime=='video/mp4' ) {
		$html = '[video id="'.$send_id.'"]';
	} elseif( $mime=='audio/mpeg' ) {
		$html = '[audio id="'.$send_id.'"]';
	}

	return $html;
}