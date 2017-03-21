/**
 * Setup Variables
 */




/**
 * Initialize the Script
 */
 
function digitec_menu_initialize_script() {

	jQuery('.main-menu-container').find('.sub-menu').each( function(index) {
	
		var width = 0;
		var outer_width = 0;
		jQuery(this).children('li').each( function(index) {
			var w = jQuery(this).children('a').width();
			var outer_w = jQuery(this).children('a').outerWidth();
			if( w > width ) {
				width = w;
				outer_width = outer_w;
			}
		});
		jQuery(this).children('li').children('a').width(width);
		jQuery(this).width(outer_width);
		jQuery(this).children('li').children('ul').css('marginLeft', outer_width+'px');
		
	});
}



/**
 * Document ready listener
 */
 
jQuery( document ).ready( function() {
	
	// Initialize the packages
	digitec_menu_initialize_script();
	
	// Add event listeners
	digitec_menu_addEventListeners();	
});