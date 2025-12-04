<?php
/**
 * Customizer partials.
 *
 * @package pastry_shop
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function pastry_shop_customize_partial_blogname() {

	bloginfo( 'name' );

}

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function pastry_shop_customize_partial_blogdescription() {

	bloginfo( 'description' );

}

/**
 * Partial for copyright text.
 *
 * @since 1.0.0
 *
 * @return void
 */
function pastry_shop_render_partial_copyright_text() {

	$pastry_shop_copyright_text = pastry_shop_get_option( 'pastry_shop_copyright_text' );
	$pastry_shop_copyright_text = apply_filters( 'pastry_shop_filter_copyright_text', $pastry_shop_copyright_text );
	if ( ! empty( $pastry_shop_copyright_text ) ) {
		$pastry_shop_copyright_text = wp_kses_data( $pastry_shop_copyright_text );
	}
	echo $pastry_shop_copyright_text;

}
