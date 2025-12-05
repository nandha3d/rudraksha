<?php
/**
 * Plugin Name: Rudraksha Woo Addons
 * Plugin URI:  https://example.com
 * Description: Custom WooCommerce addons for Rudraksha (Product Gallery, Swatches, etc.)
 * Version:     1.0.0
 * Author:      Antigravity
 * Author URI:  https://example.com
 * Text Domain: rudraksha-woo-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Constants
define( 'RUDRAKSHA_WOO_ADDONS_VERSION', '1.0.0' );
define( 'RUDRAKSHA_WOO_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'RUDRAKSHA_WOO_ADDONS_URL', plugin_dir_url( __FILE__ ) );

// Include Loader Class
require_once RUDRAKSHA_WOO_ADDONS_PATH . 'includes/class-rudraksha-loader.php';

// Initialize Plugin
function rudraksha_woo_addons_init() {
	$loader = new Rudraksha_Woo_Addons_Loader();
	$loader->init();
}
add_action( 'plugins_loaded', 'rudraksha_woo_addons_init' );
