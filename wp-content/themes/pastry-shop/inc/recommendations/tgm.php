<?php

require get_template_directory() . '/inc/recommendations/class-tgm-plugin-activation.php';

/**
 * Recommended plugins.
 */
function pastry_shop_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Mizan Demo Importor', 'pastry-shop' ),
			'slug'             => 'mizan-demo-importer',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Unlimited Elements for Elementor', 'pastry-shop' ),
			'slug'             => 'unlimited-elements-for-elementor',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Elementor', 'pastry-shop' ),
			'slug'             => 'elementor',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Prime Slider', 'pastry-shop' ),
			'slug'             => 'bdthemes-prime-slider-lite',
			'required'         => false,
			'force_activation' => false,
		)
	);
	$config = array();
	pastry_shop_tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'pastry_shop_register_recommended_plugins' );