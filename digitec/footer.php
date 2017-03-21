<?php
/**
 * The template for displaying the footer structure
 *
 * @package WordPress
 * @subpackage Digitec
 */




do_action( 'maven_before_footer' ); ?>

<footer id="siteFooter" role="contentinfo">

	<div class="wrapper clearfix">
	<?php do_action( 'maven_footer' ); ?>
	</div><!-- .wrapper -->
	
</footer><!-- #siteFooter -->

<?php do_action( 'maven_after_footer' ); ?>

</div><!-- #wrapper -->

<?php
do_action( 'maven_after' );
wp_footer();
?>
 
</body>
</html>