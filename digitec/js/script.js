/**
 * Setup Variables
 */

var sliders;

var $mediaelement;

var $project_count;
var $project_container;
var projects;
var total_projects;
var current_project = 0;
var project_controls_enabled = false;
var project_down_x;
var project_up_x;

var $featured_container;
var features;
var total_features;
var featured_buttons;
var current_featured = 0;
var featured_controls_enabled = false;
var featured_down_x;
var featured_up_x;

var fade_speed = 1000;
var animate_speed = 1000;




/**
 * Initialize the Script
 */
 
function digitec_initialize_script() {

	// Save variables
	sliders = jQuery('.post-slider');
	
	// If there are any sliders
	if( sliders.length > 0 ) {
		sliders.each( function(index) {
			digitec_setup_slider( jQuery(this) );
		});
	}

	// If there are any featured sliders	
	if( jQuery('.featured-slider').length > 0 ) {
		
		$featured_container = jQuery('.featured-slider-container');
		features = jQuery('.featured-slider').children('.featured-slider-data');
		total_features = features.length;
		featured_buttons = jQuery('.featured-slider-buttons').find('a');
		
		// If there are any featured
		if( total_features > 0 ) {
		
			// Preload any images
			digitec_preload_featured_images( 0 );
			
			// Setup the first project
			digitec_setup_featured( 0 );
		}
	}
	
	if( digitec_vars.post_type == 'project' ) {
		
		$project_count = jQuery('.digitec-project-count');
		$project_container = jQuery('.project-slider-container');
		projects = jQuery('.project-slider').children('.project-slider-data');
		total_projects = projects.length;
		
		// If there are any projects
		if( total_projects > 0 ) {
		
			// Preload any images
			digitec_preload_project_images( 0 );
			
			// Setup the first project
			digitec_setup_project( 0 );
		}
	}
}




/**
 * Setup the slider
 *
 * @since 1.0
 */
function digitec_setup_slider( $slider ) {
	
	// Save variables
	var $content_container = $slider.find( '.post-slider-content-container' ),
			$content = $content_container.children( '.post-slider-content' ),
			$articles = $content.children( 'article' ),
			$prev = $slider.find( '.nav-previous' ).children( 'a' ),
			$next = $slider.find( '.nav-next' ).children( 'a' ),
			num_posts = $articles.length,
			width = $slider.width(),
			content_width = num_posts*240,
			current_x = $content.position().left;
			
	if( content_width <= width ) {
		// Remove nav buttons
		$next.remove();
		$prev.remove();
	}
	
	// Set the width of the content
	$content.css( 'width', content_width+'px');
	
	// Show the articles
	$articles.css( 'opacity', '1' );

	// Add click listeners
	$prev.click( function(e) {
		e.preventDefault();
		
		// Enable the next button
		$next.removeClass('disabled');
		
		// Find the new position
		current_x = current_x + width;
		if( current_x >= 0 ) {
			current_x = 0;
			// Disable the button
			jQuery(this).addClass('disabled');
		}
		
		// Slide the slider
		digitec_slide_slider( $content, current_x );
	});	
	$next.click( function(e) {
		e.preventDefault();
		
		// Enable the next button
		$prev.removeClass('disabled');
		
		// Find the new position
		current_x = current_x - width;
		if( current_x <= -(content_width-width) ) {
			current_x = -(content_width-width);
			// Disable the button
			jQuery(this).addClass('disabled');
		}
		
		// Slide the slider
		digitec_slide_slider( $content, current_x );
	});
}

/**
 * Slide the contents of a slider
 *
 * @since 1.0
 */
function digitec_slide_slider( $content, pos ) {
	
	$content.stop().animate( {
		left: pos+'px'
	}, animate_speed, 'easeOutExpo', function() {
		// Animation complete.
	});
}




/**
 * Preload featured images
 *
 * @since 1.0
 */
function digitec_preload_featured_images( i ) {
		
	// Preload the image
	var path = jQuery( features[i] ).attr( 'image' );
	var img = new Image();
	jQuery( img ).load(function () {  
    var next = i+1;
		if( next <= total_features-1 ) {
			digitec_preload_featured_images( next );
		}
  }).attr('src', path);
}

/**
 * Setup a featured image
 *
 * @since 1.0
 */
function digitec_setup_featured( i ) {
	
	// Start the timer
	if( digitec_vars.slider_timer && total_features > 1 ) {
		digitec_timer_stop();
	}
	
	// Disable the controls
	featured_controls_enabled = false;
	
	// Save the current project
	current_featured = i;

	// Remove any existing projects
	digitec_remove_featured();

	// Setup the new image
	var image = jQuery( features[i] ).attr( 'image' );
	var data = jQuery( features[i] ).html();
	var id = jQuery( features[i] ).attr( 'id' );

	// Set the selected button
	jQuery(featured_buttons[i]).addClass('active');
	
	// Add the image
	digitec_featured_image( image, data );
}

/**
 * Remove featured images
 *
 * @since 1.0
 */
function digitec_remove_featured() {
	
	// Remove selected buttons
	jQuery('.featured-slider-buttons').find('a').removeClass('active');
	
	// Remove images
	$featured_container.children().each( function(index) {	
		if( jQuery(this).is('img') ) {
			jQuery(this).fadeOut( fade_speed, function() {
				jQuery(this).remove();
			});
		} else if(jQuery(this).hasClass('featured-image-content')) {
			jQuery(this).fadeOut( fade_speed, function() {
				jQuery(this).remove();
			});
		}
	});
}

// Load a featured image
function digitec_featured_image( path, data ) {
	
	var img = new Image();
	var $data = jQuery('<div class="featured-image-content">'+data+'</div>');

  jQuery( img ).load(function () {
  
  	// Append the data to the container   
    $data.hide();
    $featured_container.prepend($data);
    $data.fadeIn( fade_speed );
    
    // Append the image to the container   
    jQuery(this).hide();
    $featured_container.prepend(this);
    jQuery(this).fadeIn( fade_speed, function() {
    	featured_controls_enabled = true;
    	
    	// Start the timer
    	if( digitec_vars.slider_timer && total_features > 1 ) {
				digitec_timer_start();
			}
    });

  }).attr('src', path);
}




/**
 * Preload project images
 *
 * @since 1.0
 */
function digitec_preload_project_images( i ) {
	
	if( jQuery(projects[i]).attr( 'mime_type' ) == 'image/jpeg' || jQuery(projects[i]).attr( 'mime_type' ) == 'image/png' ) {
		
		// Preload the image
		var path = jQuery( projects[i] ).attr( 'image' );
		var img = new Image();
		jQuery( img ).load(function () {  
	    var next = i+1;
			if( next <= total_projects-1 ) {
				digitec_preload_project_images( next );
			}
	  }).attr('src', path);
		
	} else {
		var next = i+1;
		if( next <= total_projects-1 ) {
			digitec_preload_project_images( next );
		}
	}
}

/**
 * Setup a project
 *
 * @since 1.0
 */
function digitec_setup_project( i ) {
	
	// Disable the controls
	project_controls_enabled = false;
	
	// Save the current project
	current_project = i;
	
	// Remove any existing projects
	digitec_remove_projects();
	
	// Update the project count
	$project_count.text( (i+1)+'/'+total_projects );

	// Setup the new project
	var mime_type = jQuery( projects[i] ).attr( 'mime_type' );
	var image = jQuery( projects[i] ).attr( 'image' );
	var path = jQuery( projects[i] ).attr( 'path' );
	
	switch( mime_type ) {
		
		case 'image/jpeg':
			digitec_project_image( image );
			break;
			
		case 'image/png':
			digitec_project_image( image );
			break;
			
		case 'audio/mpeg':
			digitec_project_audio( path, image, mime_type );
			break;
			
		case 'video/mp4':
			digitec_project_video( path, image, mime_type );
			break;
			
		case 'video/m4v':
			digitec_project_video( path, image, mime_type );
			break;
			
		case 'vimeo':
			digitec_project_vimeo( path );
			break;
			
		case 'youtube':
			digitec_project_youtube( path );
			break;	
			
		default:
			break;
	}
}

/**
 * Remove projects
 *
 * @since 1.0
 */
function digitec_remove_projects() {
	
	if( $mediaelement ) {
		$mediaelement[0].player.pause();
	}
	
	$project_container.children().each( function(index) {	
		jQuery(this).fadeOut( fade_speed, function() {
			jQuery(this).remove();
		});
	});
}

// Load an image
function digitec_project_image( path ) {
	
	var img = new Image();

  jQuery( img ).load(function () {
    
    // Append the image to the container   
    jQuery(this).hide();
    $project_container.append(this);
    jQuery(this).fadeIn( fade_speed, function() {
    	project_controls_enabled = true;
    });

  }).attr('src', path);
}

// Load an image
function digitec_project_audio( path, poster, mime_type ) {
	
	// Create the Vimeo iFrame
	$mediaelement = jQuery( '<audio src="'+path+'" width="'+digitec_vars.project_width+'" height="'+digitec_vars.project_height+'" type="'+mime_type+'" poster="'+poster+'" controls="controls"></audio>' );

	$project_container.append($mediaelement);
	$mediaelement.mediaelementplayer({
		audioVolume: 'vertical',
		defaultVideoWidth: digitec_vars.project_width,
    defaultVideoHeight: digitec_vars.project_height,
		features: ['playpause','progress','current','duration','volume'],
		alwaysShowControls: true,
		success: function(player, node) {
		}
	});
	//alwaysShowControls: true,
	var $me_wrapper = $project_container.children();
	$me_wrapper.hide();
	
	// Remove the time float
	$me_wrapper.find( '.mejs-time-float' ).remove();
	
	// Modify the time separater
	$me_wrapper.find( '.mejs-time' ).children( 'span:nth-child(2)' ).text( ' / ' );

	$me_wrapper.fadeIn( fade_speed, function() {
		project_controls_enabled = true;
	});
}

// Load an image
function digitec_project_video( path, poster, mime_type ) {
	
	// Create the Vimeo iFrame
	$mediaelement = jQuery( '<video src="'+path+'" width="'+digitec_vars.project_width+'" height="'+digitec_vars.project_height+'" type="'+mime_type+'" poster="'+poster+'" controls="controls" preload="none"></video>' );
	
	$project_container.append($mediaelement);
	$mediaelement.mediaelementplayer({
		videoVolume: 'vertical',
		defaultVideoWidth: digitec_vars.project_width,
    defaultVideoHeight: digitec_vars.project_height,
		features: ['playpause','progress','current','duration','volume','fullscreen'],
		success: function(player, node) {
		}
	});
	
	var $me_wrapper = $project_container.children();
	$me_wrapper.hide();
	
	// Remove the time float
	$me_wrapper.find( '.mejs-time-float' ).remove();
	
	// Modify the time separater
	$me_wrapper.find( '.mejs-time' ).children( 'span:nth-child(2)' ).text( ' / ' );

	$me_wrapper.fadeIn( fade_speed, function() {
		project_controls_enabled = true;
	});
}

// Load a vimeo video
function digitec_project_vimeo( id ) {
	
	// Create the Vimeo iFrame	
	$video = jQuery( '<iframe class="vimeo" width="'+digitec_vars.project_width+'" height="'+digitec_vars.project_height+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>' );
	
	$video.hide();
	$project_container.append($video);
	$video.load( function() {
		$video.fadeIn( fade_speed, function() {
			project_controls_enabled = true;
		});
	}).attr( 'src', 'http://player.vimeo.com/video/'+id+'?title=0&amp;byline=0&amp;portrait=0&amp;color='+digitec_vars.highlight_color );
}

// Load a youtube video
function digitec_project_youtube( id ) {
	
	// Create the YouTube iFrame
	$video = jQuery( '<iframe class="youtube" width="'+digitec_vars.project_width+'" height="'+digitec_vars.project_height+'"></iframe>' );
	
	$video.hide();
	$project_container.append($video);
	$video.load( function() {
		$video.fadeIn( fade_speed, function() {
			project_controls_enabled = true;
		});
	}).attr( 'src', 'http://www.youtube.com/embed/'+id+'?rel=0&amp;wmode=transparent&amp;showinfo=0' );
}




/**
 * Timer start and stop
 * 
 * @since 1.0
 */
function digitec_timer_start() {
	
	jQuery(this).everyTime( (digitec_vars.slider_timer_speed * 1000), 'timer', function() {

		// Setup the previous featured image
		if( featured_controls_enabled ) {	
			var new_featured = current_featured+1;
			if( new_featured > total_features-1 ) new_featured = 0;
			digitec_setup_featured( new_featured);
		}
	});
}

function digitec_timer_stop() {
	jQuery(this).stopTime( 'timer' );
}







/**
 * Add Event Listeners
 */
 
function digitec_addEventListeners() {
	
	// Feature project listeners
	jQuery('.featured-slider-prev').click( function(e) {
		e.preventDefault();
		
		// Setup the previous featured image
		if( featured_controls_enabled ) {	
			var new_featured = current_featured-1;
			if( new_featured < 0 ) new_featured = total_features-1;
			digitec_setup_featured( new_featured);
		}
	});
	jQuery('.featured-slider-next').click( function(e) {
		e.preventDefault();
		
		// Setup the previous featured image
		if( featured_controls_enabled ) {	
			var new_featured = current_featured+1;
			if( new_featured > total_features-1 ) new_featured = 0;
			digitec_setup_featured( new_featured);
		}
	});
	jQuery('.featured-slider-buttons').find('a').click( function(e) {
		e.preventDefault();
		
		// Setup the selected featured image
		if( featured_controls_enabled ) {	
			var new_featured = jQuery(this).parent().children().index(this);
			digitec_setup_featured( new_featured);
		}
	});
	jQuery('.featured-slider-container').bind( 'touchstart', function(e) {
		e.preventDefault();
		var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    featured_down_x = touch.pageX;
	});
	jQuery('.featured-slider-container').bind( 'touchend', function(e) {
		
		var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    featured_up_x = touch.pageX;

		if( Math.abs(featured_down_x-featured_up_x) > 100 ) {
			if ( featured_down_x-featured_up_x > 0 ) {
				if( featured_controls_enabled ) {	
					var new_featured = current_featured+1;
					if( new_featured > total_features-1 ) new_featured = 0;
					digitec_setup_featured( new_featured);
				}
			} else {
				if( featured_controls_enabled ) {	
					var new_featured = current_featured-1;
					if( new_featured < 0 ) new_featured = total_features-1;
					digitec_setup_featured( new_featured);
				}
			}
		}
	});
	
	
	
	
	// Poject slider listeners
	jQuery('.project-slider-prev').click( function(e) {
		e.preventDefault();
		
		// Setup the previous project
		if( project_controls_enabled ) {	
			var new_project = current_project-1;
			if( new_project < 0 ) new_project = total_projects-1;
			digitec_setup_project( new_project);
		}
	});
	jQuery('.project-slider-next').click( function(e) {
		e.preventDefault();
		
		// Setup the previous project
		if( project_controls_enabled ) {	
			var new_project = current_project+1;
			if( new_project > total_projects-1 ) new_project = 0;
			digitec_setup_project( new_project);
		}
	});	
	jQuery('.project-slider-container').bind( 'touchstart', function(e) {
		e.preventDefault();
		var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    project_down_x = touch.pageX;
	});
	jQuery('.project-slider-container').bind( 'touchend', function(e) {
		
		var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    project_up_x = touch.pageX;

		if( Math.abs(project_down_x-project_up_x) > 100 ) {
			if ( project_down_x-project_up_x > 0 ) {
				if( project_controls_enabled ) {	
					var new_project = current_project+1;
					if( new_project > total_projects-1 ) new_project = 0;
					digitec_setup_project( new_project);
				}
			} else {
				if( project_controls_enabled ) {	
					var new_project = current_project-1;
					if( new_project < 0 ) new_project = total_projects-1;
					digitec_setup_project( new_project);
				}
			}
		}
	});
}




/**
 * Document ready listener
 */
 
jQuery( document ).ready( function() {
	
	// Initialize the packages
	digitec_initialize_script();
	
	// Add event listeners
	digitec_addEventListeners();	
});