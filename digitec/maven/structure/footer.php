<?php
/**
 * Adds footer structures.
 *
 * @category   Maven
 * @package    Structure
 * @subpackage Footer
 * @author     MetaphorCreations
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://www.metaphorcreations.com/themes/maven
 */




if( current_theme_supports('footer-widgets') ) {

	add_action( 'maven_before_footer', 'maven_footer_widgets' );
	/**
	 * Print the footer widgets.
	 *
	 * @since 1.0
	 */
	function maven_footer_widgets() {
		
		global $style_id;
		$footer_layout = get_post_meta( $style_id, '_maven_footer_layout', true );
		$footer_widget_1 = get_post_meta( $style_id, '_maven_footer_widget_1', true );
		$footer_widget_2 = get_post_meta( $style_id, '_maven_footer_widget_2', true );
		$footer_widget_3 = get_post_meta( $style_id, '_maven_footer_widget_3', true );
		$footer_widget_4 = get_post_meta( $style_id, '_maven_footer_widget_4', true );

		if( $footer_layout ) {
			if( $footer_layout != 'none' ) {
			?>
			<div id="footer-widgets" class="<?php echo $footer_layout; ?> clearfix">
				<div class="wrapper clearfix">
				<?php
					switch( $footer_layout ) {
						case 'two-col':
							?>
							<div id="footer-widget-area-1" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_1 ); ?>
							</div>
							<div id="footer-widget-area-2" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_2 ); ?>
							</div>
							<?php
							break;
						case 'three-col-1':
						case 'three-col-2':
						case 'three-col-3':
						case 'three-col-4':
							?>
							<div id="footer-widget-area-1" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_1 ); ?>
							</div>
							<div id="footer-widget-area-2" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_2); ?>
							</div>
							<div id="footer-widget-area-3" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_3 ); ?>
							</div>
							<?php
							break;
						case 'four-col':	
							?>
							<div id="footer-widget-area-1" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_1 ); ?>
							</div>
							<div id="footer-widget-area-2" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_2 ); ?>
							</div>
							<div id="footer-widget-area-3" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_3 ); ?>
							</div>
							<div id="footer-widget-area-4" class="widget-area" role="complementary">
								<?php dynamic_sidebar( $footer_widget_4 ); ?>
							</div>
							<?php
							break;
					}
					?>
					</div>
				</div><!-- #footer-widgets .<?php echo $footer_layout; ?> -->
				<?php
			}
		}
	}
}




add_action( 'maven_footer', 'maven_do_footer' );
/**
 * Print the copyright.
 *
 * Includes the copyright.
 *
 * @since 1.0
 */
function maven_do_footer() {
	$options = get_option( 'maven_general_options' );
	?>
	<div id="copyright">
		<?php
		if( isset($options['copyright_text']) ) {
			echo wpautop( stripslashes( $options['copyright_text'] ) );
		}
		?>
	</div><!-- #copyright -->
	<?php
}




add_action( 'maven_after', 'maven_do_after' );
/**
 * Print out anything that comes after wp_footer().
 *
 * @since 1.0
 */
function maven_do_after() {
	?>
	
	<script>
	<?php
	$options = get_option( 'maven_general_options' );
	if( isset($options['google_analytics']) ) {
	
		$google_analytics = sanitize_text_field( $options['google_analytics'] );
		
		if( current_theme_supports('modernizr') ) { ?>
			
			window._gaq = [['_setAccount','<?php echo $google_analytics; ?>'],['_trackPageview'],['_trackPageLoadTime']];
			Modernizr.load({
				load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
			});
			
		<?php } else { ?>
		
			var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		<?php
		}
	}  
	?>
	</script>
	
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	<?php
}