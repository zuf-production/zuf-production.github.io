var placeholder_support;

jQuery( document ).ready( function() {

	// Check for placeholder support
	placeholder_support = metatools_placeholder_support();

	
	
	
	/**
	 * Add placeholder support for non-placeholder browsers
	 *
	 * @since 1.0
	 */
	if( !placeholder_support ){		
		jQuery( '[placeholder]' ).each( function(index) {
			var input = jQuery( this );
			input.addClass( 'placeholder' );
			input.val( input.attr('placeholder') );
		});
		jQuery( '[placeholder]' ).live( 'focus', function() {
		  var input = jQuery( this );
		  if ( input.val() == input.attr('placeholder') ) {
				input.val( '' );
				input.removeClass( 'placeholder' );
		  }
		}).live( 'blur', function() {
		  var input = jQuery( this );
		  if ( input.val() == '' || input.val() == input.attr('placeholder') ) {
				input.addClass( 'placeholder' );
				input.val( input.attr('placeholder') );
		  }
		}).blur();
		
		jQuery( '[placeholder]' ).parents( 'form' ).submit( function() {
		  jQuery( this ).find( '[placeholder]' ).each( function() {
				var input = jQuery( this );
				if ( input.val() == input.attr('placeholder') ) {
				  input.val( '' );
				}
		  })
		});	
	}
	
	
	
	
	/**
	 * Check for placeholder support
	 * 
	 * @since 1.0
	 */
	function metatools_placeholder_support() {
	  var input = document.createElement('input');
	  return ( 'placeholder' in input );
	}
});