<?php
/**
 * This is where we put all the general functions.
 *
 * @category Plugins
 * @package  MetaTools
 * @author   MetaphorCreations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/plugins/metatools
 **/
 
 


add_action( 'wp_enqueue_scripts', 'metatools_load_scripts' );
/**
 * Enqueue the scripts used on the front-end of the site.
 *
 * @since 1.0
 */
function metatools_load_scripts() {
	
	// Add MediaElement Player JS
	wp_register_script( 'mediaelement-and-player', METATOOLS_MEDIAELEMENT_URL.'/mediaelement-and-player.js', array( 'jquery' ), METATOOLS_VERSION, true );
	wp_enqueue_script( 'mediaelement-and-player' );
	
	// Add MediaElement Player CSS
	wp_register_style( 'mediaelementplayer', METATOOLS_MEDIAELEMENT_URL.'/mediaelementplayer.min.css', false, METATOOLS_VERSION );
	wp_enqueue_style( 'mediaelementplayer' );
	
	// Add the metatools script
	wp_register_script( 'metatools', METATOOLS_JS_URL.'/metatools.js', array( 'jquery' ), METATOOLS_VERSION, true );
	wp_enqueue_script( 'metatools' );
	
	// Add the metatools styles
	wp_register_style( 'metatools', METATOOLS_CSS_URL.'/metatools.css', false, METATOOLS_VERSION );
	wp_enqueue_style( 'metatools' );
}




add_action( 'wp_head', 'm4c_add_ajaxurl' );
/**
 * Add the ajax url to the header.
 *
 * @since 1.0
 */
function m4c_add_ajaxurl() {
	?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
	</script>
	<?php
}
 
 
 
 
/**
 * Add custom image sizes.
 *
 * @since 1.0
 */
if ( function_exists( 'add_image_size' ) ) { 

	// Create custom image sizes
	add_image_size( 'm4c-gallery-thumb', 120, 120, true );
}
 
 
 
 
/**
 * Print a loading gif
 *
 * @since 1.0
 */
function m4c_loading_gif( $color='light', $style='' ) {
	echo get_m4c_loading_gif( $color, $style );
}




/**
 * Return a loading gif
 *
 * @since 1.0
 */
function get_m4c_loading_gif( $color='light', $style='' ) {
	if( $color=='light' ) {
		return '<img class="m4c-loading-gif" style="'.$style.'" src="'.METATOOLS_IMAGES_URL.'/loading.gif" width="16" height="16" />';
	} else {
		return '<img class="m4c-loading-gif" style="'.$style.'" src="'.METATOOLS_IMAGES_URL.'/loading.gif" width="16" height="16" />';
	}
}




/**
 * Convert twitter links
 *
 * @since 1.0
 */
function m4c_convert_twitter_links( $string ) {

	$html = maven_convert_hyperlink( $string );
	$html = preg_replace("/[@]+([A-Za-z0-9-_]+)/", "<a href=\"http://twitter.com/\\1\" target=\"_blank\">\\0</a>", $html ); 
	$html = preg_replace("/[#]+([A-Za-z0-9-_]+)/", "<a href=\"http://twitter.com/search?q=%23\\1\" target=\"_blank\">\\0</a>", $html );

  return $html;
}




/**
 * Convert hyperlink text
 *
 * @since 1.0
 */
function m4c_convert_hyperlink( $string ) {

	return preg_replace( '@(?])\b(?:(?:https?|ftp|file)://|[a-z]\.)[-A-Z0-9+&#/%=~_|$?!:,.]*[A-Z0-9+&#/%=~_|$]@i', '\0', $string );
}




/**
 * Create an array of patterns
 *
 * @since 1.0
 */
function get_m4c_patterns() {
	$patterns = array(
		array( 'name' => __('None', 'digitec'), 'value' => 'none' ),
		array( 'name' => '45 Degree Fabric', 'value' => METATOOLS_IMAGES_URL.'/patterns/45degreee_fabric.png' ),
		array( 'name' => '60 Degree Grey', 'value' => METATOOLS_IMAGES_URL.'/patterns/60degree_gray.png' ),
		array( 'name' => 'Always Grey', 'value' => METATOOLS_IMAGES_URL.'/patterns/always_grey.png' ),
		array( 'name' => 'Batthern', 'value' => METATOOLS_IMAGES_URL.'/patterns/batthern.png' ),
		array( 'name' => 'Beige Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/beige_paper.png' ),
		array( 'name' => 'BG Noise LG', 'value' => METATOOLS_IMAGES_URL.'/patterns/bgnoise_lg.png' ),
		array( 'name' => 'Black Denim', 'value' => METATOOLS_IMAGES_URL.'/patterns/black_denim.png' ),
		array( 'name' => 'Black Linen', 'value' => METATOOLS_IMAGES_URL.'/patterns/black-Linen.png' ),
		array( 'name' => 'Black Linen V2', 'value' => METATOOLS_IMAGES_URL.'/patterns/black_linen_v2.png' ),
		array( 'name' => 'Black Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/black_paper.png' ),
		array( 'name' => 'Black Scales', 'value' => METATOOLS_IMAGES_URL.'/patterns/black_scales.png' ),
		array( 'name' => 'Black Thread', 'value' => METATOOLS_IMAGES_URL.'/patterns/black_thread.png' ),
		array( 'name' => 'Black Mamba', 'value' => METATOOLS_IMAGES_URL.'/patterns/blackmamba.png' ),
		array( 'name' => 'Bright Squares', 'value' => METATOOLS_IMAGES_URL.'/patterns/bright_squares.png' ),
		array( 'name' => 'Broken Noise', 'value' => METATOOLS_IMAGES_URL.'/patterns/broken_noise.png' ),
		array( 'name' => 'Brushed Alu', 'value' => METATOOLS_IMAGES_URL.'/patterns/brushed_alu.png' ),
		array( 'name' => 'Brushed Alu Dark', 'value' => METATOOLS_IMAGES_URL.'/patterns/brushed_alu_dark.png' ),
		array( 'name' => 'Candyhole', 'value' => METATOOLS_IMAGES_URL.'/patterns/candyhole.png' ),
		array( 'name' => 'Carbon Fibre', 'value' => METATOOLS_IMAGES_URL.'/patterns/carbon_fibre.png' ),
		array( 'name' => 'Carbon Fibre V2', 'value' => METATOOLS_IMAGES_URL.'/patterns/carbon_fibre_v2.png' ),
		array( 'name' => 'Carbon Fibre Big', 'value' => METATOOLS_IMAGES_URL.'/patterns/carbon_fibre_big.png' ),
		array( 'name' => 'Cardboard', 'value' => METATOOLS_IMAGES_URL.'/patterns/cardboard.png' ),
		array( 'name' => 'Checkered Pattern', 'value' => METATOOLS_IMAGES_URL.'/patterns/checkered_pattern.png' ),
		array( 'name' => 'Circles', 'value' => METATOOLS_IMAGES_URL.'/patterns/circles.png' ),
		array( 'name' => 'Classy Fabric', 'value' => METATOOLS_IMAGES_URL.'/patterns/classy_fabric.png' ),
		array( 'name' => 'Concrete Wall', 'value' => METATOOLS_IMAGES_URL.'/patterns/concrete_wall.png' ),
		array( 'name' => 'Concrete Wall 2', 'value' => METATOOLS_IMAGES_URL.'/patterns/concrete_wall_2.png' ),
		array( 'name' => 'Concrete Wall 3', 'value' => METATOOLS_IMAGES_URL.'/patterns/concrete_wall_3.png' ),
		array( 'name' => 'Connect', 'value' => METATOOLS_IMAGES_URL.'/patterns/connect.png' ),
		array( 'name' => 'Cork 1', 'value' => METATOOLS_IMAGES_URL.'/patterns/cork_1.png' ),
		array( 'name' => 'Criss X Cross', 'value' => METATOOLS_IMAGES_URL.'/patterns/crissXcross.png' ),
		array( 'name' => 'Crossed Stripes', 'value' => METATOOLS_IMAGES_URL.'/patterns/crossed_stripes.png' ),
		array( 'name' => 'Crosses', 'value' => METATOOLS_IMAGES_URL.'/patterns/crosses.png' ),
		array( 'name' => 'Cubes', 'value' => METATOOLS_IMAGES_URL.'/patterns/cubes.png' ),
		array( 'name' => 'Dark Brick Wall', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_brick_wall.png' ),
		array( 'name' => 'Dark Circles', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_circles.png' ),
		array( 'name' => 'Dark Leather', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_leather.png' ),
		array( 'name' => 'Dark Matter', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_matter.png' ),
		array( 'name' => 'Dark Mosaic', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_mosaic.png' ),
		array( 'name' => 'Dark Stripes', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_stripes.png' ),
		array( 'name' => 'Dark Wood', 'value' => METATOOLS_IMAGES_URL.'/patterns/dark_wood.png' ),
		array( 'name' => 'Dark Denim 3', 'value' => METATOOLS_IMAGES_URL.'/patterns/darkdenim3.png' ),
		array( 'name' => 'Darth Stripe', 'value' => METATOOLS_IMAGES_URL.'/patterns/darth_stripe.png' ),
		array( 'name' => 'Denim', 'value' => METATOOLS_IMAGES_URL.'/patterns/denim.png' ),
		array( 'name' => 'Diagmonds', 'value' => METATOOLS_IMAGES_URL.'/patterns/diagmonds.png' ),
		array( 'name' => 'Diagonal Noise', 'value' => METATOOLS_IMAGES_URL.'/patterns/diagonal-noise.png' ),
		array( 'name' => 'Diamonds', 'value' => METATOOLS_IMAGES_URL.'/patterns/diamonds.png' ),
		array( 'name' => 'Double Lined', 'value' => METATOOLS_IMAGES_URL.'/patterns/double_lined.png' ),
		array( 'name' => 'DVSup', 'value' => METATOOLS_IMAGES_URL.'/patterns/dvsup.png' ),
		array( 'name' => 'Elastoplast', 'value' => METATOOLS_IMAGES_URL.'/patterns/elastoplast.png' ),
		array( 'name' => 'Elegant Grid', 'value' => METATOOLS_IMAGES_URL.'/patterns/elegant_grid.png' ),
		array( 'name' => 'Exclusive Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/exclusive_paper.png' ),
		array( 'name' => 'Fabric 1', 'value' => METATOOLS_IMAGES_URL.'/patterns/fabric_1.png' ),
		array( 'name' => 'Fabric Plaid', 'value' => METATOOLS_IMAGES_URL.'/patterns/fabric_plaid.png' ),
		array( 'name' => 'Fake Brick', 'value' => METATOOLS_IMAGES_URL.'/patterns/fake_brick.png' ),
		array( 'name' => 'Fancy Deboss', 'value' => METATOOLS_IMAGES_URL.'/patterns/fancy_deboss.png' ),
		array( 'name' => 'Felt', 'value' => METATOOLS_IMAGES_URL.'/patterns/felt.png' ),
		array( 'name' => 'Flowers', 'value' => METATOOLS_IMAGES_URL.'/patterns/flowers.png' ),
		array( 'name' => 'Foggy Birds', 'value' => METATOOLS_IMAGES_URL.'/patterns/foggy_birds.png' ),
		array( 'name' => 'Foil', 'value' => METATOOLS_IMAGES_URL.'/patterns/foil.png' ),
		array( 'name' => 'Gold Scale', 'value' => METATOOLS_IMAGES_URL.'/patterns/gold_scale.png' ),
		array( 'name' => 'Graphy', 'value' => METATOOLS_IMAGES_URL.'/patterns/graphy.png' ),
		array( 'name' => 'Gray Sand', 'value' => METATOOLS_IMAGES_URL.'/patterns/gray_sand.png' ),
		array( 'name' => 'Green Dust Scratch', 'value' => METATOOLS_IMAGES_URL.'/patterns/green_dust_scratch.png' ),
		array( 'name' => 'Green Gobbler', 'value' => METATOOLS_IMAGES_URL.'/patterns/green_gobbler.png' ),
		array( 'name' => 'Green Fibers', 'value' => METATOOLS_IMAGES_URL.'/patterns/green-fibers.png' ),
		array( 'name' => 'Grid Me', 'value' => METATOOLS_IMAGES_URL.'/patterns/gridme.png' ),
		array( 'name' => 'Grilled', 'value' => METATOOLS_IMAGES_URL.'/patterns/grilled.png' ),
		array( 'name' => 'Groove Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/groovepaper.png' ),
		array( 'name' => 'Grunge Wall', 'value' => METATOOLS_IMAGES_URL.'/patterns/grunge_wall.png' ),
		array( 'name' => 'Gun Metal', 'value' => METATOOLS_IMAGES_URL.'/patterns/gun_metal.png' ),
		array( 'name' => 'Handmade Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/handmadepaper.png' ),
		array( 'name' => 'Hixs Pattern Evolution', 'value' => METATOOLS_IMAGES_URL.'/patterns/hixs_pattern_evolution.png' ),
		array( 'name' => 'Inflicted', 'value' => METATOOLS_IMAGES_URL.'/patterns/inflicted.png' ),
		array( 'name' => 'Iron Grip', 'value' => METATOOLS_IMAGES_URL.'/patterns/irongrip.png' ),
		array( 'name' => 'XXXXX', 'value' => METATOOLS_IMAGES_URL.'/patterns/knitted-netting.png' ),
		array( 'name' => 'Knitted Netting', 'value' => METATOOLS_IMAGES_URL.'/patterns/leather_1.png' ),
		array( 'name' => 'Light Alu', 'value' => METATOOLS_IMAGES_URL.'/patterns/light_alu.png' ),
		array( 'name' => 'Light Checkered Tiles', 'value' => METATOOLS_IMAGES_URL.'/patterns/light_checkered_tiles.png' ),
		array( 'name' => 'Light Grey Floral Motif', 'value' => METATOOLS_IMAGES_URL.'/patterns/light_grey_floral_motif.png' ),
		array( 'name' => 'Light Honeycomb', 'value' => METATOOLS_IMAGES_URL.'/patterns/light_honeycomb.png' ),
		array( 'name' => 'Lined Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/lined_paper.png' ),
		array( 'name' => 'Little Pluses', 'value' => METATOOLS_IMAGES_URL.'/patterns/little_pluses.png' ),
		array( 'name' => 'Little Knobs', 'value' => METATOOLS_IMAGES_URL.'/patterns/littleknobs.png' ),
		array( 'name' => 'Merely Cubed', 'value' => METATOOLS_IMAGES_URL.'/patterns/merely_cubed.png' ),
		array( 'name' => 'Micro Carbon', 'value' => METATOOLS_IMAGES_URL.'/patterns/micro_carbon.png' ),
		array( 'name' => 'Mirrored Squares', 'value' => METATOOLS_IMAGES_URL.'/patterns/mirrored_squares.png' ),
		array( 'name' => 'Nami', 'value' => METATOOLS_IMAGES_URL.'/patterns/nami.png' ),
		array( 'name' => 'Noise Pattern with Crosslines', 'value' => METATOOLS_IMAGES_URL.'/patterns/noise_pattern_with_crosslines.png' ),
		array( 'name' => 'Noisy', 'value' => METATOOLS_IMAGES_URL.'/patterns/noisy.png' ),
		array( 'name' => 'Old Mathematics', 'value' => METATOOLS_IMAGES_URL.'/patterns/old_mathematics.png' ),
		array( 'name' => 'Old Wall', 'value' => METATOOLS_IMAGES_URL.'/patterns/old_wall.png' ),
		array( 'name' => 'Padded', 'value' => METATOOLS_IMAGES_URL.'/patterns/padded.png' ),
		array( 'name' => 'Paper 1', 'value' => METATOOLS_IMAGES_URL.'/patterns/paper_1.png' ),
		array( 'name' => 'Paper 2', 'value' => METATOOLS_IMAGES_URL.'/patterns/paper_2.png' ),
		array( 'name' => 'Paper 3', 'value' => METATOOLS_IMAGES_URL.'/patterns/paper_3.png' ),
		array( 'name' => 'Paven', 'value' => METATOOLS_IMAGES_URL.'/patterns/paven.png' ),
		array( 'name' => 'Pineapple Cut', 'value' => METATOOLS_IMAGES_URL.'/patterns/pineapplecut.png' ),
		array( 'name' => 'Pinstripe', 'value' => METATOOLS_IMAGES_URL.'/patterns/pinstripe.png' ),
		array( 'name' => 'Plaid', 'value' => METATOOLS_IMAGES_URL.'/patterns/plaid.png' ),
		array( 'name' => 'Polaroid', 'value' => METATOOLS_IMAGES_URL.'/patterns/polaroid.png' ),
		array( 'name' => 'Polonez Car', 'value' => METATOOLS_IMAGES_URL.'/patterns/polonez_car.png' ),
		array( 'name' => 'Pool Table', 'value' => METATOOLS_IMAGES_URL.'/patterns/pool_table.png' ),
		array( 'name' => 'Project Papper', 'value' => METATOOLS_IMAGES_URL.'/patterns/project_papper.png' ),
		array( 'name' => 'px_by_Gre3g', 'value' => METATOOLS_IMAGES_URL.'/patterns/px_by_Gre3g.png' ),
		array( 'name' => 'Random Grey Variations', 'value' => METATOOLS_IMAGES_URL.'/patterns/random_grey_variations.png' ),
		array( 'name' => 'Ravenna', 'value' => METATOOLS_IMAGES_URL.'/patterns/ravenna.png' ),
		array( 'name' => 'Real CF', 'value' => METATOOLS_IMAGES_URL.'/patterns/real_cf.png' ),
		array( 'name' => 'Rice Paper', 'value' => METATOOLS_IMAGES_URL.'/patterns/ricepaper.png' ),
		array( 'name' => 'Rice Paper 2', 'value' => METATOOLS_IMAGES_URL.'/patterns/ricepaper2.png' ),
		array( 'name' => 'RIP Jobs', 'value' => METATOOLS_IMAGES_URL.'/patterns/rip_jobs.png' ),
		array( 'name' => 'Robots', 'value' => METATOOLS_IMAGES_URL.'/patterns/robots.png' ),
		array( 'name' => 'Rockywall', 'value' => METATOOLS_IMAGES_URL.'/patterns/rockywall.png' ),
		array( 'name' => 'Rough Cloth', 'value' => METATOOLS_IMAGES_URL.'/patterns/roughcloth.png' ),
		array( 'name' => 'Rubber Grip', 'value' => METATOOLS_IMAGES_URL.'/patterns/rubber_grip.png' ),
		array( 'name' => 'Silver Scales', 'value' => METATOOLS_IMAGES_URL.'/patterns/silver_scales.png' ),
		array( 'name' => 'Small Tiles', 'value' => METATOOLS_IMAGES_URL.'/patterns/small_tiles.png' ),
		array( 'name' => 'Small Crackle Bright', 'value' => METATOOLS_IMAGES_URL.'/patterns/small-crackle-bright.png' ),
		array( 'name' => 'Smooth Wall', 'value' => METATOOLS_IMAGES_URL.'/patterns/smooth_wall.png' ),
		array( 'name' => 'Soft Circle Scales', 'value' => METATOOLS_IMAGES_URL.'/patterns/soft_circle_scales.png' ),
		array( 'name' => 'Soft Pad', 'value' => METATOOLS_IMAGES_URL.'/patterns/soft_pad.png' ),
		array( 'name' => 'Soft Wallpaper', 'value' => METATOOLS_IMAGES_URL.'/patterns/soft_wallpaper.png' ),
		array( 'name' => 'Square BG', 'value' => METATOOLS_IMAGES_URL.'/patterns/square_bg.png' ),
		array( 'name' => 'Squares', 'value' => METATOOLS_IMAGES_URL.'/patterns/squares.png' ),
		array( 'name' => 'Starring', 'value' => METATOOLS_IMAGES_URL.'/patterns/starring.png' ),
		array( 'name' => 'Struck Axiom', 'value' => METATOOLS_IMAGES_URL.'/patterns/struckaxiom.png' ),
		array( 'name' => 'Stucco', 'value' => METATOOLS_IMAGES_URL.'/patterns/stucco.png' ),
		array( 'name' => 'Subtle Freckles', 'value' => METATOOLS_IMAGES_URL.'/patterns/subtle_freckles.png' ),
		array( 'name' => 'Subtle Orange Emboss', 'value' => METATOOLS_IMAGES_URL.'/patterns/subtle_orange_emboss.png' ),
		array( 'name' => 'Tactile Noise', 'value' => METATOOLS_IMAGES_URL.'/patterns/tactile_noise.png' ),
		array( 'name' => 'Texturetastic Gray', 'value' => METATOOLS_IMAGES_URL.'/patterns/texturetastic_gray.png' ),
		array( 'name' => 'Triangles', 'value' => METATOOLS_IMAGES_URL.'/patterns/triangles.png' ),
		array( 'name' => 'Type', 'value' => METATOOLS_IMAGES_URL.'/patterns/type.png' ),
		array( 'name' => 'Vertical Cloth', 'value' => METATOOLS_IMAGES_URL.'/patterns/vertical_cloth.png' ),
		array( 'name' => 'Vichy', 'value' => METATOOLS_IMAGES_URL.'/patterns/vichy.png' ),
		array( 'name' => 'Washi', 'value' => METATOOLS_IMAGES_URL.'/patterns/washi.png' ),
		array( 'name' => 'Wavecut', 'value' => METATOOLS_IMAGES_URL.'/patterns/wavecut.png' ),
		array( 'name' => 'White Brick Wall', 'value' => METATOOLS_IMAGES_URL.'/patterns/white_brick_wall.png' ),
		array( 'name' => 'White Carbon', 'value' => METATOOLS_IMAGES_URL.'/patterns/white_carbon.png' ),
		array( 'name' => 'White Paperboard', 'value' => METATOOLS_IMAGES_URL.'/patterns/white_paperboard.png' ),
		array( 'name' => 'White Plaster', 'value' => METATOOLS_IMAGES_URL.'/patterns/white_plaster.png' ),
		array( 'name' => 'White Sand', 'value' => METATOOLS_IMAGES_URL.'/patterns/white_sand.png' ),
		array( 'name' => 'White Texture', 'value' => METATOOLS_IMAGES_URL.'/patterns/white_texture.png' ),
		array( 'name' => 'White Diamond', 'value' => METATOOLS_IMAGES_URL.'/patterns/whitediamond.png' ),
		array( 'name' => 'Whitey', 'value' => METATOOLS_IMAGES_URL.'/patterns/whitey.png' ),
		array( 'name' => 'Wood 1', 'value' => METATOOLS_IMAGES_URL.'/patterns/wood_1.png' ),
		array( 'name' => 'Wood Pattern', 'value' => METATOOLS_IMAGES_URL.'/patterns/wood_pattern.png' ),
		array( 'name' => 'Woven', 'value' => METATOOLS_IMAGES_URL.'/patterns/woven.png' ),
		array( 'name' => 'XV', 'value' => METATOOLS_IMAGES_URL.'/patterns/xv.png' ),
		array( 'name' => 'Zig Zag', 'value' => METATOOLS_IMAGES_URL.'/patterns/zigzag.png' )	
	);
	
	return $patterns;
}