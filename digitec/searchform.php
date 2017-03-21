<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage Digitec
 */
 
 
 
 
?>
<form method="get" class="search-form clearfix" action="<?php echo esc_url( home_url('/') ); ?>">
	<label for="s" class="assistive-text"><?php _e( 'Search', 'digitec' ); ?></label>
	<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search our site', 'digitec' ); ?>" /><span class="submit-wrapper"><input type="submit" class="submit" name="submit" value="<?php esc_attr_e( 'Search', 'digitec' ); ?>" /></span>
</form>
