<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rudraksha_Theme_Colors {

	private $options;

	public function __construct() {
		$this->options = get_option( 'rudraksha_theme_colors', array(
			'primary_color'   => '#6d2911', // Dark brown - top header, buttons
			'secondary_color' => '#f5e6d3', // Light cream - menu bar
		) );

		// Admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Frontend CSS
		add_action( 'wp_head', array( $this, 'output_custom_css' ), 100 );
	}

	public function add_admin_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'Theme Colors', 'rudraksha-woo-addons' ),
			__( 'Theme Colors', 'rudraksha-woo-addons' ),
			'manage_options',
			'rudraksha-theme-colors',
			array( $this, 'render_settings_page' )
		);
	}

	public function register_settings() {
		register_setting( 'rudraksha_theme_colors_group', 'rudraksha_theme_colors', array( $this, 'sanitize_options' ) );
	}

	public function sanitize_options( $input ) {
		$sanitized = array();
		$sanitized['primary_color'] = isset( $input['primary_color'] ) ? sanitize_hex_color( $input['primary_color'] ) : '#6d2911';
		$sanitized['secondary_color'] = isset( $input['secondary_color'] ) ? sanitize_hex_color( $input['secondary_color'] ) : '#f5e6d3';
		return $sanitized;
	}

	public function enqueue_admin_scripts( $hook ) {
		if ( 'woocommerce_page_rudraksha-theme-colors' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 
			'rudraksha-theme-colors-admin', 
			RUDRAKSHA_WOO_ADDONS_URL . 'modules/theme-colors/assets/js/admin.js', 
			array( 'jquery', 'wp-color-picker' ), 
			RUDRAKSHA_WOO_ADDONS_VERSION, 
			true 
		);
		wp_enqueue_style( 
			'rudraksha-theme-colors-admin-css', 
			RUDRAKSHA_WOO_ADDONS_URL . 'modules/theme-colors/assets/css/admin.css', 
			array(), 
			RUDRAKSHA_WOO_ADDONS_VERSION 
		);
	}

	public function render_settings_page() {
		$options = $this->options;
		?>
		<div class="wrap rudraksha-theme-colors-wrap">
			<h1><?php _e( 'Theme Colors', 'rudraksha-woo-addons' ); ?></h1>
			<p class="description"><?php _e( 'Customize the main colors used across your website.', 'rudraksha-woo-addons' ); ?></p>
			
			<form method="post" action="options.php">
				<?php settings_fields( 'rudraksha_theme_colors_group' ); ?>
				
				<div class="rudraksha-color-settings">
					<div class="rudraksha-color-card">
						<h3><?php _e( 'Primary Color', 'rudraksha-woo-addons' ); ?></h3>
						<p class="description"><?php _e( 'Used for top header, buttons, links, and accents.', 'rudraksha-woo-addons' ); ?></p>
						<input type="text" 
							   name="rudraksha_theme_colors[primary_color]" 
							   value="<?php echo esc_attr( $options['primary_color'] ); ?>" 
							   class="rudraksha-color-picker" 
							   data-default-color="#6d2911" />
						<div class="color-preview primary-preview" style="background-color: <?php echo esc_attr( $options['primary_color'] ); ?>">
							<span>Header & Buttons</span>
						</div>
					</div>
					
					<div class="rudraksha-color-card">
						<h3><?php _e( 'Secondary Color', 'rudraksha-woo-addons' ); ?></h3>
						<p class="description"><?php _e( 'Used for menu bar, secondary backgrounds, and highlights.', 'rudraksha-woo-addons' ); ?></p>
						<input type="text" 
							   name="rudraksha_theme_colors[secondary_color]" 
							   value="<?php echo esc_attr( $options['secondary_color'] ); ?>" 
							   class="rudraksha-color-picker" 
							   data-default-color="#f5e6d3" />
						<div class="color-preview secondary-preview" style="background-color: <?php echo esc_attr( $options['secondary_color'] ); ?>">
							<span>Menu Bar</span>
						</div>
					</div>
				</div>
				
				<p class="submit">
					<input type="submit" class="button button-primary" value="<?php _e( 'Save Colors', 'rudraksha-woo-addons' ); ?>" />
					<button type="button" class="button rudraksha-reset-colors"><?php _e( 'Reset to Default', 'rudraksha-woo-addons' ); ?></button>
				</p>
			</form>
		</div>
		<?php
	}

	public function output_custom_css() {
		$primary = $this->options['primary_color'];
		$secondary = $this->options['secondary_color'];
		
		// Calculate darker/lighter variants
		$primary_dark = $this->adjust_brightness( $primary, -20 );
		$primary_light = $this->adjust_brightness( $primary, 40 );
		$secondary_dark = $this->adjust_brightness( $secondary, -15 );
		
		?>
		<style id="rudraksha-theme-colors">
			:root {
				--rudraksha-primary: <?php echo esc_attr( $primary ); ?>;
				--rudraksha-primary-dark: <?php echo esc_attr( $primary_dark ); ?>;
				--rudraksha-primary-light: <?php echo esc_attr( $primary_light ); ?>;
				--rudraksha-secondary: <?php echo esc_attr( $secondary ); ?>;
				--rudraksha-secondary-dark: <?php echo esc_attr( $secondary_dark ); ?>;
			}
			
			/* Top Header */
			.site-header .top-header,
			.top-bar,
			header .top-header,
			.header-top,
			.site-top-bar {
				background-color: var(--rudraksha-primary) !important;
			}
			
			/* Menu Bar / Secondary Header */
			.main-navigation,
			.site-header .main-header,
			.primary-menu-wrapper,
			.menu-bar,
			.header-main,
			.site-navigation,
			nav.main-navigation {
				background-color: var(--rudraksha-secondary) !important;
			}
			
			/* Navigation Links */
			.main-navigation a,
			.primary-menu a,
			.site-navigation a {
				color: var(--rudraksha-primary) !important;
			}
			
			.main-navigation a:hover,
			.primary-menu a:hover,
			.site-navigation a:hover {
				color: var(--rudraksha-primary-dark) !important;
			}
			
			/* ALL Buttons - Comprehensive (excluding gallery nav buttons) */
			.button,
			button:not(.rudraksha-gallery-thumb-btn):not(.wp-picker-clear):not(.wp-picker-default):not(.gallery-nav-btn),
			input[type="submit"],
			input[type="button"],
			.wp-block-button__link,
			.woocommerce a.button,
			.woocommerce button.button:not(.gallery-nav-btn),
			.woocommerce input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.add_to_cart_button,
			.single_add_to_cart_button,
			.rudraksha-buy-now-btn,
			.buy-now-btn,
			a.rudraksha-buy-now-btn,
			button.rudraksha-buy-now-btn,
			.cart button[type="submit"],
			.woocommerce .cart .button,
			.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
			.checkout-button,
			.woocommerce form .form-row button,
			.wc-block-components-button,
			.wp-element-button {
				background-color: var(--rudraksha-primary) !important;
				border-color: var(--rudraksha-primary) !important;
				color: #fff !important;
			}
			
			.button:hover,
			button:not(.rudraksha-gallery-thumb-btn):not(.wp-picker-clear):not(.wp-picker-default):not(.gallery-nav-btn):hover,
			input[type="submit"]:hover,
			input[type="button"]:hover,
			.wp-block-button__link:hover,
			.woocommerce a.button:hover,
			.woocommerce button.button:not(.gallery-nav-btn):hover,
			.woocommerce input.button:hover,
			.woocommerce #respond input#submit:hover,
			.woocommerce a.button.alt:hover,
			.woocommerce button.button.alt:hover,
			.woocommerce input.button.alt:hover,
			.add_to_cart_button:hover,
			.single_add_to_cart_button:hover,
			.rudraksha-buy-now-btn:hover,
			.buy-now-btn:hover,
			a.rudraksha-buy-now-btn:hover,
			button.rudraksha-buy-now-btn:hover,
			.cart button[type="submit"]:hover,
			.woocommerce .cart .button:hover,
			.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
			.checkout-button:hover,
			.woocommerce form .form-row button:hover,
			.wc-block-components-button:hover,
			.wp-element-button:hover {
				background-color: var(--rudraksha-primary-dark) !important;
				border-color: var(--rudraksha-primary-dark) !important;
			}
			
			/* Outline Buttons */
			.button-outline,
			.woocommerce a.button.button-outline,
			.btn-outline {
				background-color: transparent !important;
				border-color: var(--rudraksha-primary) !important;
				color: var(--rudraksha-primary) !important;
			}
			
			.button-outline:hover,
			.woocommerce a.button.button-outline:hover,
			.btn-outline:hover {
				background-color: var(--rudraksha-primary) !important;
				color: #fff !important;
			}
			
			/* Links */
			a {
				color: var(--rudraksha-primary);
			}
			
			a:hover {
				color: var(--rudraksha-primary-dark);
			}
			
			/* Product Gallery Border */
			.rudraksha-product-gallery,
			.woocommerce-product-gallery,
			.rudraksha-product-gallery .rudraksha-main-image-wrapper,
			.flex-viewport,
			.woocommerce div.product div.images,
			.product-gallery-wrapper {
				border-color: <?php echo esc_attr( $primary ); ?> !important;
			}
			
			.rudraksha-product-gallery {
				border: 2px solid <?php echo esc_attr( $primary ); ?> !important;
			}
			
			/* Product Gallery Slider - NO glow animation */
			.product-gallery-slider {
				border: 2px solid #e8d9c5 !important;
				animation: none !important;
				box-shadow: none !important;
			}
			
			/* Gallery Navigation Buttons - Keep them white */
			.gallery-nav-btn {
				background: rgba(255, 255, 255, 0.9) !important;
				border: none !important;
				color: #333 !important;
			}
			
			.gallery-nav-btn:hover {
				background: #ffffff !important;
			}
			
			/* Gallery Thumbnail Active */
			.rudraksha-gallery-thumb-btn.active,
			.product-gallery-thumbs .swiper-slide-thumb-active,
			.flex-control-thumbs li img.flex-active,
			.woocommerce-product-gallery .flex-control-thumbs li img:hover {
				border-color: <?php echo esc_attr( $primary ); ?> !important;
				box-shadow: 0 0 0 2px <?php echo esc_attr( $primary ); ?> !important;
			}
			
			/* Swatch Selection */
			.rudraksha-swatch-label.selected {
				border-color: var(--rudraksha-primary) !important;
				box-shadow: 0 0 0 2px <?php echo esc_attr( $this->hex_to_rgba( $primary, 0.2 ) ); ?>, 0 0 12px <?php echo esc_attr( $this->hex_to_rgba( $primary, 0.4 ) ); ?> !important;
			}
			
			.rudraksha-swatches.rudraksha-swatches-cards .rudraksha-swatch-label.selected {
				border-color: var(--rudraksha-primary) !important;
				box-shadow: 0 0 0 2px <?php echo esc_attr( $this->hex_to_rgba( $primary, 0.2 ) ); ?>, 0 0 12px <?php echo esc_attr( $this->hex_to_rgba( $primary, 0.4 ) ); ?> !important;
			}
			
			/* Star Ratings */
			.star-rating span::before,
			.woocommerce .star-rating span::before,
			.star-rating,
			.woocommerce .star-rating {
				color: var(--rudraksha-primary) !important;
			}
			
			/* WooCommerce Price */
			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			.price ins,
			.woocommerce-Price-amount {
				color: var(--rudraksha-primary) !important;
			}
			
			/* Footer */
			.site-footer,
			footer.site-footer {
				background-color: var(--rudraksha-primary) !important;
			}
			
			/* Breadcrumbs */
			.woocommerce .woocommerce-breadcrumb a {
				color: var(--rudraksha-primary) !important;
			}
			
			/* Product Tabs */
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {
				color: var(--rudraksha-primary) !important;
				border-bottom-color: var(--rudraksha-primary) !important;
			}
			
			/* Quantity Buttons */
			.quantity .plus,
			.quantity .minus {
				background-color: var(--rudraksha-secondary) !important;
				color: var(--rudraksha-primary) !important;
				border-color: var(--rudraksha-secondary-dark) !important;
			}
			
			/* Form Focus */
			input:focus,
			textarea:focus,
			select:focus {
				border-color: var(--rudraksha-primary) !important;
				outline-color: var(--rudraksha-primary) !important;
			}
			
			/* Badges */
			.onsale,
			.woocommerce span.onsale,
			.rudraksha-discount-badge {
				background-color: var(--rudraksha-primary) !important;
			}
			
			/* Widget Titles */
			.widget-title,
			.widgettitle {
				color: var(--rudraksha-primary) !important;
			}
			
			/* Mobile Menu Toggle */
			.menu-toggle,
			.mobile-menu-toggle {
				color: var(--rudraksha-primary) !important;
			}
			
			/* Shop Page Buttons */
			.products .button,
			ul.products li.product .button,
			.woocommerce ul.products li.product .button {
				background-color: var(--rudraksha-primary) !important;
				border-color: var(--rudraksha-primary) !important;
				color: #fff !important;
			}
			
			.products .button:hover,
			ul.products li.product .button:hover,
			.woocommerce ul.products li.product .button:hover {
				background-color: var(--rudraksha-primary-dark) !important;
				border-color: var(--rudraksha-primary-dark) !important;
			}
			
			/* Cart Page */
			.woocommerce-cart table.cart td.actions .coupon .button,
			.woocommerce-cart table.cart td.actions button[name="update_cart"],
			.woocommerce a.remove {
				background-color: var(--rudraksha-primary) !important;
				border-color: var(--rudraksha-primary) !important;
			}
			
			/* Pagination */
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current {
				background: var(--rudraksha-primary) !important;
				border-color: var(--rudraksha-primary) !important;
			}
			
			/* Notices */
			.woocommerce-message,
			.woocommerce-info {
				border-top-color: var(--rudraksha-primary) !important;
			}
			
			.woocommerce-message::before,
			.woocommerce-info::before {
				color: var(--rudraksha-primary) !important;
			}
		</style>
		<?php
	}

	/**
	 * Adjust color brightness
	 */
	private function adjust_brightness( $hex, $steps ) {
		$hex = ltrim( $hex, '#' );
		
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );
		
		return sprintf( '#%02x%02x%02x', $r, $g, $b );
	}

	/**
	 * Convert hex to rgba
	 */
	private function hex_to_rgba( $hex, $alpha = 1 ) {
		$hex = ltrim( $hex, '#' );
		
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		
		return sprintf( 'rgba(%d, %d, %d, %s)', $r, $g, $b, $alpha );
	}
}

new Rudraksha_Theme_Colors();
