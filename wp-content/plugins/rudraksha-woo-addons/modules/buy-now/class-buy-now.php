<?php
/**
 * Buy Now Button Module
 *
 * @package Rudraksha_Woo_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rudraksha_Buy_Now {

	public function __construct() {
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'render_buy_now_button' ) );
		add_action( 'wp_footer', array( $this, 'buy_now_script' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

    public function enqueue_styles() {
        if ( is_product() ) {
            wp_enqueue_style( 'rudraksha-buy-now', plugin_dir_url( __FILE__ ) . 'assets/css/buy-now.css', array(), '1.0.0' );
        }
    }

	public function render_buy_now_button() {
		echo '<button type="button" class="button rudraksha-buy-now-button" name="rudraksha_buy_now" value="1">' . esc_html__( 'Buy Now', 'rudraksha-woo-addons' ) . '</button>';
	}

	public function buy_now_script() {
		if ( ! is_product() ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.rudraksha-buy-now-button').on('click', function(e) {
					e.preventDefault();
					
					var $form = $(this).closest('form.cart');
					var isVariable = $form.hasClass('variations_form');
					var productID = $form.find('button[name="add-to-cart"]').val();
                    var quantity = $form.find('input[name="quantity"]').val() || 1;
                    var checkoutUrl = '<?php echo esc_url( wc_get_checkout_url() ); ?>';

					if ( isVariable ) {
						var variationID = $form.find('input[name="variation_id"]').val();
						if ( ! variationID || variationID == 0 ) {
							alert('<?php echo esc_js( __( 'Please select some product options before adding this product to your cart.', 'woocommerce' ) ); ?>');
							return;
						}
                        // Redirect to checkout with add-to-cart and variation_id
                        window.location.href = checkoutUrl + '?add-to-cart=' + variationID + '&quantity=' + quantity;
					} else {
                        // Simple product
                        if ( ! productID ) {
                             // Fallback if button value is empty (sometimes happens)
                             productID = $form.find('input[name="add-to-cart"]').val();
                        }
                        window.location.href = checkoutUrl + '?add-to-cart=' + productID + '&quantity=' + quantity;
                    }
				});
			});
		</script>
		<?php
	}
}

new Rudraksha_Buy_Now();
