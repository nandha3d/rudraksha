<?php
/**
 * Plugin Name: Smart Related Products – AI-Inspired Recommendations for WooCommerce
 * Plugin URI: https://www.sharkthemes.com
 * Description: Smart Related Products – AI-Inspired Recommendations for WooCommerce helps boost your sales with intelligent, behavior-driven product suggestions tailored to each customer’s interests. This powerful WooCommerce add-on uses a smart algorithm to display relevant, frequently bought together, and personalized products throughout your store. By showing the right products in the right places, it enhances engagement, increases conversions, and drives steady sales growth. Formerly known as "AI Related Products – WooCommerce Recommendation".
 * Version: 2.0.6
 * Author: Shark Themes
 * Author URI: https://sharkthemes.com
 * Requires at least: 5.6
 * Tested up to: 6.8.2
 * Requires Plugins: woocommerce
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Text Domain: ai-related-products
 * Domain Path: /languages/
 *
 * @package Smart Related Products
 * @category Core
 * @author Shark Themes
 */


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('ST_WOO_AI_REL_PRODUCTS')) {
	final class ST_WOO_AI_REL_PRODUCTS
	{

		protected static $instance = null;

		public static function get_instance()
		{
			if (is_null(self::$instance)) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function __construct()
		{
			add_action('activate_plugin', array($this, 'deactivate_plugin'));
			$this->st_woo_ai_rel_products_constant();
			$this->st_woo_ai_rel_products_core();
		}

		public function st_woo_ai_rel_products_constant()
		{
			global $wp_version;
			define('ST_WOO_AI_REL_PRODUCTS_WP_VERSION', $wp_version);
			define('ST_WOO_AI_REL_PRODUCTS_BASE_PATH', dirname(__FILE__));
			define('ST_WOO_AI_REL_PRODUCTS_URL_PATH', plugin_dir_url(__FILE__));
			define('ST_WOO_AI_REL_PRODUCTS_PLUGIN_BASE_PATH', plugin_basename(__FILE__));
			define('ST_WOO_AI_REL_PRODUCTS_PLUGIN_FILE_PATH', (__FILE__));
		}

		public function deactivate_plugin($plugin)
		{
			if ($plugin === 'ai-related-product-pro/ai-related-products.php') {
				deactivate_plugins('ai-related-products/ai-related-products.php');
			}
		}

		public function st_woo_ai_rel_products_core()
		{
			include_once ST_WOO_AI_REL_PRODUCTS_BASE_PATH . '/include/core.php';
		}

	}
}

if (!function_exists('ST_Woo_Ai_Rel_Products')) {
	function ST_Woo_Ai_Rel_Products()
	{
		return ST_WOO_AI_REL_PRODUCTS::get_instance();
	}
}

if (!function_exists('st_woo_ai_rel_products_admin_install_woo_notice')) {
	function st_woo_ai_rel_products_admin_install_woo_notice()
	{
		$class = 'notice notice-warning';
		$message = __('WooCommerce Smart Related Products Plugin is a supportive addon for WooCommerce. Please install and activate the WooCommerce plugin.', 'ai-related-products');
		$label = __('Install WooCommerce', 'ai-related-products');
		$url = admin_url('plugin-install.php?s=woocommerce&tab=search&type=term');

		printf('<div class="%1$s"><p>%2$s <a href="%3$s">%4$s</a></p></div>', esc_attr($class), esc_html($message), esc_url($url), esc_html($label));
	}
}

if (!function_exists('is_plugin_active')) {
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

if (!function_exists('st_woo_ai_rel_products_init')) {
	function st_woo_ai_rel_products_init()
	{
		if (is_plugin_active('woocommerce/woocommerce.php')) {
			// Initialize Smart Related Products
			ST_Woo_Ai_Rel_Products();
		} else {
			add_action('admin_notices', 'st_woo_ai_rel_products_admin_install_woo_notice');
		}
	}
}
add_action('init', 'st_woo_ai_rel_products_init');
