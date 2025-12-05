<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rudraksha_Product_Gallery {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_filter( 'wc_get_template', array( $this, 'override_product_image_template' ), 10, 5 );
	}

	public function enqueue_assets() {
		if ( ! is_product() ) {
			return;
		}

		// Enqueue Swiper (if not already enqueued by theme, but good to ensure)
		wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), '8.4.7' );
		wp_enqueue_script( 'swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array( 'jquery' ), '8.4.7', true );

		// Custom Gallery Assets
		wp_enqueue_style( 'rudraksha-gallery-css', RUDRAKSHA_WOO_ADDONS_URL . 'modules/product-gallery/assets/css/product-gallery.css', array( 'swiper-css' ), RUDRAKSHA_WOO_ADDONS_VERSION );
		wp_enqueue_script( 'rudraksha-gallery-js', RUDRAKSHA_WOO_ADDONS_URL . 'modules/product-gallery/assets/js/product-gallery.js', array( 'jquery', 'swiper-js' ), RUDRAKSHA_WOO_ADDONS_VERSION, true );
	}

	public function override_product_image_template( $template, $template_name, $args, $template_path, $default_path ) {
		if ( 'single-product/product-image.php' === $template_name ) {
			$custom_template = RUDRAKSHA_WOO_ADDONS_PATH . 'modules/product-gallery/templates/product-image.php';
			if ( file_exists( $custom_template ) ) {
				return $custom_template;
			}
		}
		return $template;
	}
}
