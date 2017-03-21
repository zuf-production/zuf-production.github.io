<?php
/**
 * Adds header structures.
 *
 * @category   Maven
 * @package    Structure
 * @subpackage Header
 * @author     MetaphorCreations
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://www.metaphorcreations.com/themes/maven
 */




add_action( 'maven_doctype', 'maven_do_doctype' );
/**
 * Print the doctype and opening markup.
 *
 * @since 1.0
 */
function maven_do_doctype() {
	?>
	<!doctype html>
	<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<?php
}




add_action( 'maven_title', 'maven_do_title' );
/**
 * Print the title.
 *
 * @since 1.0
 */
function maven_do_title() {
	?>
	<title>
	<?php
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		echo " | $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' | ' . sprintf( __( 'Page %s', 'digitec' ), max( $paged, $page ) );
	}
	?>
	</title>
	<?php
}




add_action( 'maven_meta', 'maven_do_meta' );
/**
 * Print the meta.
 *
 * @since 1.0
 */
function maven_do_meta() {
	?>
	<meta name="description" content="">
	<meta name="author" content="">
	<?php
}




add_action( 'wp_head', 'maven_do_meta_pingback' );
/**
 * Adds the pingback meta tag to the head so that other sites can know how to
 * send a pingback to our site.
 *
 * @since 1.0
 */
function maven_do_meta_pingback() {
	if ( 'open' == get_option( 'default_ping_status' ) ) {
		echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
	}
}




add_action( 'maven_favicon', 'maven_do_favicon' );
/**
 * Setup the favicon.
 *
 * @since 1.0
 */
function maven_do_favicon() {
	// Set the favicon
	$options = get_option( 'maven_general_options' );

	if ( isset($options['favicon']) ) {
		if( get_post_mime_type($options['favicon'][0]) == 'image/png' ) {
			$favicon = wp_get_attachment_image_src( $options['favicon'][0], 'full' );
			echo '<link rel="icon" type="image/png" href="'.$favicon[0].'">';
		} elseif( get_post_mime_type($options['favicon'][0]) == 'image/x-icon' ) {
			$favicon = wp_get_attachment_image_src( $options['favicon'][0], 'full' );
			echo '<link rel="icon" type="image/x-icon" href="'.$favicon[0].'">';
		}
	}
}




add_action( 'maven_header', 'maven_do_header' );
/**
 * Print out the header section.
 *
 * Includes the main menu, logo, and tagline
 *
 * @since 1.0
 */
function maven_do_header() {
	?>
	<header id="siteHeader" class="clearfix">
		<div class="wrapper">

			<a id="logo" href="<?php echo home_url(); ?>"><?php maven_header_logo(); ?></a>
			<p id="tagline"><?php echo get_bloginfo ( 'description' ); ?></p>

			<?php
			$args = array(
				'theme_location'		=> 'main-menu',
				'menu'							=> 'main-menu',
				'menu_class'				=> 'main-menu clearfix',
				'container'					=> 'div',
				'container_class'		=> 'main-menu-container',
				'fallback_cb'				=> 'main_menu_fallback'
			);

			// Add the menu
			wp_nav_menu( $args );
			?>

		</div>
	</header><!-- #siteHeader -->
	<?php
}