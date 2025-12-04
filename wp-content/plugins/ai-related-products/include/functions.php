<?php
/**
 * Smart Related Products Controls
 *
 * @package Smart Related Products
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class ST_Woo_AI_Rel_Products_Control
{

	public function __construct()
	{
		$replace_default_rel_products = get_option('st_woo_ai_rel_products_replace_single_rel_products', true);
		if ($replace_default_rel_products) {
			add_action('wp_loaded', array($this, 'st_woo_rel_products_hooks'), 100);
		}
		add_action('wp_loaded', array($this, 'st_woo_ai_rel_products_rest_api_includes'), 5);
	}

	/*
	 * single related products
	 */
	public function st_woo_rel_products_hooks()
	{
		// change heading for related products
		add_filter('woocommerce_product_related_products_heading', array($this, 'single_rel_products_heading'));
		
		// // remove action for single block template
		// remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

		// // new action for single block template
		// add_action('woocommerce_after_single_product_summary', array($this, 'single_output_related_products'), 20);

		// filter for classic themes
		add_filter('woocommerce_output_related_products_args', array($this, 'single_rel_products_args'));

		// filter for related products
		add_filter('woocommerce_related_products', array($this, 'single_rel_products_replacement_args'), 100, 3);

		// show related products in cart page
		$enable_in_cart_page = get_option('st_woo_ai_rel_products_cart_page_rel_products', false);
		if ($enable_in_cart_page) {
			add_action('woocommerce_after_cart', array($this, 'single_output_related_products'), 20);
		}
	}

	/*
	 * dependency for api call
	 */
	public function st_woo_ai_rel_products_rest_api_includes()
	{
		require_once(WC_ABSPATH . 'includes/wc-cart-functions.php');
		require_once(WC_ABSPATH . 'includes/wc-notice-functions.php');
	}

	/*
	 * get past purchases of user
	 */
	public static function purchased_products($user, $ref_order)
	{
		$current_user = $user;

		if (!$current_user) {

			// check if user is logged in
			if (!is_user_logged_in()) {
				return array();
			}

			// get current user
			$current_user = wp_get_current_user();
			$current_user = $current_user->ID;
		}

		// get post types
		$post_types = wc_get_order_types();

		// get product status
		$status = array_keys(wc_get_is_paid_statuses());

		// get ref products
		$ref_products = (int) $ref_order ? absint($ref_order) : -1;

		// get purchased orders
		$customer_orders = get_posts(array(
			'numberposts' => $ref_products,
			'meta_key' => '_customer_user',
			'meta_value' => $current_user,
			'post_type' => $post_types,
			'post_status' => $status,
		));

		// loop through orders and get product ids
		$product_ids = array();

		if (!empty($customer_orders)) {
			foreach ($customer_orders as $customer_order) {
				$order = wc_get_order($customer_order->ID);
				$items = $order->get_items();
				foreach ($items as $item) {
					$product_id = $item->get_product_id();
					$product_ids[] = $product_id;
				}
			}
		}

		return $product_ids;
	}

	/**
	 * Get ordered and cart products
	 *
	 * params
	 * $cart = include cart for filter (bool) true/false
	 * $ref_order = no of recently ordered/purchased products (int) val / empty for all
	 * $user = user id (int) val
	 * 
	 * @package Smart Related Products
	 * @since 1.0.0
	 */
	public static function st_woo_rel_products($cart = false, $ref_order = '', $user = false, $api_call = false)
	{

		if (is_admin()) {
			return array();
		}

		// get previous purchases
		$product_ids = self::purchased_products($user, $ref_order);

		// cart items
		$cart_items = array();
		if ($cart) {
			if (is_user_logged_in()) {

				if (is_object(WC()->cart)) {
					if (WC()->cart->get_cart_contents_count() != 0) {
						foreach (WC()->cart->get_cart() as $cart_item) {
							// get the data of the cart item
							$cart_items[] = $cart_item['product_id'];
						}
					}
				}

			} else {

				if (function_exists('WC') && WC()->session instanceof WC_Session) {

					// Retrieve data from the session
					$cart_contents = WC()->session->get('cart', array());

					if (isset($cart_contents) && !empty($cart_contents)) {
						foreach ($cart_contents as $content) {
							$cart_items[] = $content['product_id'];
						}
					}

				}

			}
		}

		$product_ids = array_merge($product_ids, $cart_items);
		$product_ids = array_unique($product_ids);

		return $product_ids;
	}

	/**
	 * Single related products replacement
	 *
	 * @package Smart Related Products
	 * @since 1.0.0
	 */
	public function single_rel_products_replacement_args($related_posts, $product_id, $args)
	{
		// Get options for including cart reference
		$inc_cart = get_option('st_woo_ai_rel_products_cart_ref_single_rel_products');

		// Custom function to get product IDs based on the options
		$product_ids = $this::st_woo_rel_products($inc_cart, 1);

		$product_cats = array();
		$parent_cats = array();

		// Collect product categories and their parent categories
		if (!empty($product_ids)) {
			foreach ($product_ids as $product) {
				$product_cat_ids = wc_get_product_term_ids($product, 'product_cat');
				if (!empty($product_cat_ids)) {
					// Add the first category and its parent (if any)
					$product_cat = $product_cat_ids[0];
					$product_cats[] = $product_cat;

					$parent_cat_ids = get_ancestors($product_cat, 'product_cat');
					if (!empty($parent_cat_ids)) {
						$parent_cats[] = $parent_cat_ids[0];
					}
				}
			}

			// Merge and remove duplicate categories
			$product_cats = array_merge($product_cats, $parent_cats);
			$product_cats = array_unique($product_cats);
		}

		// Get the number of related products to fetch
		$no_of_products = get_option('st_woo_ai_rel_products_number_single_rel_products', 6);

		// Build query arguments for related products
		$related_args = array(
			'post_type' => 'product',
			'posts_per_page' => absint($no_of_products + 2),
			'orderby' => 'rand',
			'exclude' => array($product_id),
			'meta_query' => array(
				array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '='
				)
			)
		);

		if (!empty($product_cats)) {
			$related_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'term_id',
					'terms' => $product_cats,
				),
			);
		}

		// Fetch related posts
		$related_posts_query = get_posts($related_args);

		// Extract post IDs from the query result
		$related_posts = wp_list_pluck($related_posts_query, 'ID');

		return $related_posts;
	}

	/**
	 * Single related products args
	 *
	 * @package Smart Related Products
	 * @since 1.0.0
	 */
	public function single_rel_products_args($args)
	{
		$no_of_products = get_option('st_woo_ai_rel_products_number_single_rel_products', 6);
		$column = get_option('st_woo_ai_rel_products_column_single_rel_products', 3);
		$args['posts_per_page'] = absint($no_of_products);
		$args['columns'] = absint($column);

		return $args;
	}

	/**
	 * Single related products args
	 *
	 * @package Smart Related Products
	 * @since 1.0.0
	 */
	public function single_rel_products_heading($heading)
	{
		$heading = get_option('st_woo_ai_rel_products_label_single_rel_products', __('You May Also Like', 'ai-related-products'));
		return esc_html($heading);
	}

	/**
	 * Single related products args
	 *
	 * @package Smart Related Products
	 * @since 1.0.0
	 */
	public function single_output_related_products()
	{
		$no_of_products = get_option('st_woo_ai_rel_products_number_single_rel_products', 6);
		$column = get_option('st_woo_ai_rel_products_column_single_rel_products', 3);
		$inc_cart = get_option('st_woo_ai_rel_products_cart_ref_single_rel_products');
		$heading = get_option('st_woo_ai_rel_products_label_single_rel_products', __('You May Also Like', 'ai-related-products'));

		$output = '<h2>' . esc_html($heading) . '</h2>';

		// Shortcode for related products
		$output .= do_shortcode('[ST_WOO_AI_REL_PRODUCTS column="' . absint($column) . '" cart_ref="' . ($inc_cart ? 'yes' : 'no') . '" no_of_products="' . absint($no_of_products) . '" sort="rand"]');

		echo $output;
	}

}

new ST_Woo_AI_Rel_Products_Control();
