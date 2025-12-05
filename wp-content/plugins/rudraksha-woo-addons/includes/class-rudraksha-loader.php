<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rudraksha_Woo_Addons_Loader {

	public function init() {
		$this->load_modules();
	}

	private function load_modules() {
		// Load Modules
		require_once RUDRAKSHA_WOO_ADDONS_PATH . 'modules/product-gallery/class-product-gallery.php';
		new Rudraksha_Product_Gallery();

		require_once RUDRAKSHA_WOO_ADDONS_PATH . 'modules/swatches/class-swatches.php';
		new Rudraksha_Swatches();

		require_once RUDRAKSHA_WOO_ADDONS_PATH . 'modules/buy-now/class-buy-now.php';
		
		require_once RUDRAKSHA_WOO_ADDONS_PATH . 'modules/variation-manager/class-variation-manager.php';
		new Rudraksha_Variation_Manager();
		
		require_once RUDRAKSHA_WOO_ADDONS_PATH . 'modules/theme-colors/class-theme-colors.php';
	}
}
