jQuery( document ).ready( function() {

	// If on a style page, setup the sidebar selects
	if( jQuery( '.page-layout-select' ).length > 0 ) {
		m4c_layout_selects_init();
	}
	
	/**
	 * Update the selects based on the image select.
	 *
	 * @since 1.0
	 */
	jQuery( '.page-layout-select' ).find( '.m4c-image-select-link' ).click( function() {

		// Show the selects
		m4c_page_layout( jQuery(this).attr('href') );
	});
	
	jQuery( '.footer-layout-select' ).find( '.m4c-image-select-link' ).click( function() {

		// Show the selects
		m4c_footer_layout( jQuery(this).attr('href') );
	});
});




/**
 * Show the widget selects based on the current layout.
 *
 * @since 1.0
 */
function m4c_layout_selects_init() {
	// Hide or show the page widget select
	m4c_page_layout( jQuery( '.page-layout-select' ).children( '.m4c-field-content' ).children( 'input#_maven_page_layout' ).val(), 0 ); 
	// Hide or show the footer widget selects
	m4c_footer_layout( jQuery( '.footer-layout-select' ).children( '.m4c-field-content' ).children( 'input#_maven_footer_layout' ).val(), 0 );
}

function m4c_page_layout( val, speed ) {
	speed = speed || 200;
	switch( val ) {
		case 'full-width':
			jQuery( '.page-widget-select' ).fadeOut( speed );
			break;
		case 'sidebar-right':
		case 'sidebar-left':
			jQuery( '.page-widget-select' ).fadeIn( speed );
			break;
	}
}

function m4c_footer_layout( val, speed ) {
	speed = speed || 200;
	switch( val ) {
		case 'none':
			jQuery( '.footer-widget-select-1' ).fadeOut( speed );
			jQuery( '.footer-widget-select-2' ).fadeOut( speed );
			jQuery( '.footer-widget-select-3' ).fadeOut( speed );
			jQuery( '.footer-widget-select-4' ).fadeOut( speed );
			break;
		case 'two-col':
			jQuery( '.footer-widget-select-1' ).fadeIn( speed );
			jQuery( '.footer-widget-select-2' ).fadeIn( speed );
			jQuery( '.footer-widget-select-3' ).fadeOut( speed );
			jQuery( '.footer-widget-select-4' ).fadeOut( speed );
			break;
		case 'three-col-1':
		case 'three-col-2':
		case 'three-col-3':
		case 'three-col-4':
			jQuery( '.footer-widget-select-1' ).fadeIn( speed );
			jQuery( '.footer-widget-select-2' ).fadeIn( speed );
			jQuery( '.footer-widget-select-3' ).fadeIn( speed );
			jQuery( '.footer-widget-select-4' ).fadeOut( speed );
			break;
		case 'four-col':
			jQuery( '.footer-widget-select-1' ).fadeIn( speed );
			jQuery( '.footer-widget-select-2' ).fadeIn( speed );
			jQuery( '.footer-widget-select-3' ).fadeIn( speed );
			jQuery( '.footer-widget-select-4' ).fadeIn( speed );
			break;
	}
}