jQuery( document ).ready( function() {
	
	/**
	 * Insert the Vimeo/Youtube video as an attachment.
	 *
	 * @since 1.0
	 */	
	jQuery('#m4c-add-video').click( function(e) {
		
		e.preventDefault();
		
		// Get the data
		var $form = jQuery('form#m4c-video-form'),
				$loading = $form.find('.m4c-loading-gif'),
				$error = $form.find('tr#m4c-video-error-message'),
				nonce = $form.children('input#_wpnonce').val(),
				type = jQuery('input[name="video_type"]:checked', $form ).val(),
				id = $form.find('input#video_id').val();
				
		// Hide any previous errors
		$error.slideUp();
		
		if( type=='' || id=='' ) {
		} else {
		
			// Show the loading gif
			$loading.animate( {
				opacity: 1
			}, 100 );

			// Set the ajax data and call the function
			if ( type == 'vimeo' ) {
				data = {
					action: 'm4c_insert_vimeo_attachment',
					post_id: post_id,
					file_id: id,
					security: nonce
				};
			} else {
				data = {
					action: 'm4c_insert_youtube_attachment',
					post_id: post_id,
					file_id: id,
					security: nonce
				};
			}
			jQuery.post( ajaxurl, data, function( response ) {
				if( response == 'Does not exist' ) {
					$error.slideDown();
					$loading.animate( {
						opacity: 0
					}, 100 );
				} else {
					// Go to the Gallery tab
					$tab = jQuery('#tab-gallery a');
					if( $tab.length > 0 ) {
						window.location = $tab.attr('href');
					} else {
						location.reload();
					}
				}
			});
		}
	});
	
	/**
	 * Add an auto-select
	 *
	 * @since 1.0
	 */
	jQuery( '.m4c-auto-select' ).click( function() {
		var refNode = jQuery( this )[0];
		if ( jQuery.browser.msie ) {
			var range = document.body.createTextRange();
			range.moveToElementText( refNode );
			range.select();
		} else if ( jQuery.browser.mozilla || jQuery.browser.opera ) {
			var selection = window.getSelection();
			var range = document.createRange();
			range.selectNodeContents( refNode );
			selection.removeAllRanges();
			selection.addRange( range );
		} else if ( jQuery.browser.safari ) {
			var selection = window.getSelection();
			selection.setBaseAndExtent( refNode, 0, refNode, 1 );
		}
	});
	
});