<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rudraksha_Variation_Manager {

	public function __construct() {
		// Add admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		
		// Enqueue admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		
		// AJAX handlers
		add_action( 'wp_ajax_rvm_load_variations', array( $this, 'ajax_load_variations' ) );
		add_action( 'wp_ajax_rvm_update_variation', array( $this, 'ajax_update_variation' ) );
		add_action( 'wp_ajax_rvm_duplicate_variation', array( $this, 'ajax_duplicate_variation' ) );
		add_action( 'wp_ajax_rvm_delete_variation', array( $this, 'ajax_delete_variation' ) );
		add_action( 'wp_ajax_rvm_search_products', array( $this, 'ajax_search_products' ) );
		add_action( 'wp_ajax_rvm_create_variation', array( $this, 'ajax_create_variation' ) );
		add_action( 'wp_ajax_rvm_generate_variations', array( $this, 'ajax_generate_variations' ) );
		add_action( 'wp_ajax_rvm_get_attributes', array( $this, 'ajax_get_attributes' ) );
	}

	public function add_admin_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'Variation Manager', 'rudraksha-woo-addons' ),
			__( 'Variation Manager', 'rudraksha-woo-addons' ),
			'manage_woocommerce',
			'rudraksha-variation-manager',
			array( $this, 'render_admin_page' )
		);
	}

	public function enqueue_admin_assets( $hook ) {
		if ( 'woocommerce_page_rudraksha-variation-manager' !== $hook ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 
			'rudraksha-variation-manager-css', 
			RUDRAKSHA_WOO_ADDONS_URL . 'modules/variation-manager/assets/css/admin-variation-manager.css', 
			array(), 
			RUDRAKSHA_WOO_ADDONS_VERSION 
		);
		wp_enqueue_script( 
			'rudraksha-variation-manager-js', 
			RUDRAKSHA_WOO_ADDONS_URL . 'modules/variation-manager/assets/js/admin-variation-manager.js', 
			array( 'jquery', 'wp-color-picker' ), 
			RUDRAKSHA_WOO_ADDONS_VERSION, 
			true 
		);
		
		wp_localize_script( 'rudraksha-variation-manager-js', 'rvmData', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'rvm_nonce' ),
			'i18n' => array(
				'confirm_delete' => __( 'Are you sure you want to delete this variation?', 'rudraksha-woo-addons' ),
				'confirm_duplicate' => __( 'Duplicate this variation?', 'rudraksha-woo-addons' ),
				'saving' => __( 'Saving...', 'rudraksha-woo-addons' ),
				'saved' => __( 'Saved', 'rudraksha-woo-addons' ),
				'error' => __( 'Error occurred', 'rudraksha-woo-addons' ),
			)
		) );
	}

	public function render_admin_page() {
		?>
		<div class="wrap rvm-wrap">
			<h1><?php _e( 'Variation Manager', 'rudraksha-woo-addons' ); ?></h1>
			<p class="description"><?php _e( 'Manage product variations easily with image galleries, swatches, and pricing controls.', 'rudraksha-woo-addons' ); ?></p>
			
			<div class="rvm-product-selector">
				<h2><?php _e( 'Select Variable Product', 'rudraksha-woo-addons' ); ?></h2>
				<select id="rvm-product-select" style="width: 400px;">
					<option value=""><?php _e( 'Choose a product...', 'rudraksha-woo-addons' ); ?></option>
					<?php
					$args = array(
						'post_type' => 'product',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'product_type',
								'field'    => 'slug',
								'terms'    => 'variable',
							),
						),
					);
					$products = get_posts( $args );
					foreach ( $products as $product ) {
						echo '<option value="' . esc_attr( $product->ID ) . '">' . esc_html( $product->post_title ) . '</option>';
					}
					?>
				</select>
				<button type="button" id="rvm-load-variations" class="button button-primary"><?php _e( 'Load Variations', 'rudraksha-woo-addons' ); ?></button>
			</div>
			
			<div id="rvm-variations-container" style="display: none;">
				<div class="rvm-variations-header">
					<h2><?php _e( 'Product Variations', 'rudraksha-woo-addons' ); ?></h2>
					<p class="rvm-product-info"></p>
				</div>
				
				<!-- Variation Generation Tools -->
				<div class="rvm-generation-tools">
					<button type="button" id="rvm-add-variation" class="button">
						<span class="dashicons dashicons-plus-alt"></span> <?php _e( 'Add Variation', 'rudraksha-woo-addons' ); ?>
					</button>
					<button type="button" id="rvm-generate-variations" class="button button-primary">
						<span class="dashicons dashicons-update"></span> <?php _e( 'Generate All Variations', 'rudraksha-woo-addons' ); ?>
					</button>
					<span class="rvm-generation-info"><?php _e( 'Generate creates variations from all attribute combinations', 'rudraksha-woo-addons' ); ?></span>
				</div>
				
				<div id="rvm-variations-list" class="rvm-variations-table">
					<div class="rvm-table-header">
						<div>Image</div>
						<div>Variation</div>
						<div>Gallery</div>
						<div>Swatch</div>
						<div>Reg. Price</div>
						<div>Sale Price</div>
						<div>SKU</div>
						<div>Stock</div>
						<div>Status</div>
						<div>Weight</div>
						<div>Dimensions</div>
						<div>Actions</div>
					</div>
					<!-- Variation rows will be loaded here via AJAX -->
				</div>
			</div>
			
			<div id="rvm-loading" style="display: none;">
				<span class="spinner is-active"></span>
				<p><?php _e( 'Loading variations...', 'rudraksha-woo-addons' ); ?></p>
			</div>
			
			<!-- Add Variation Modal -->
			<div id="rvm-add-variation-modal" class="rvm-modal" style="display: none;">
				<div class="rvm-modal-content">
					<div class="rvm-modal-header">
						<h3><?php _e( 'Add New Variation', 'rudraksha-woo-addons' ); ?></h3>
						<button type="button" class="rvm-modal-close">&times;</button>
					</div>
					<div class="rvm-modal-body">
						<p><?php _e( 'Select attribute values for the new variation:', 'rudraksha-woo-addons' ); ?></p>
						<div id="rvm-attribute-selectors">
							<!-- Attribute dropdowns will be loaded here -->
						</div>
					</div>
					<div class="rvm-modal-footer">
						<button type="button" class="button rvm-modal-cancel"><?php _e( 'Cancel', 'rudraksha-woo-addons' ); ?></button>
						<button type="button" class="button button-primary" id="rvm-create-variation-btn"><?php _e( 'Create Variation', 'rudraksha-woo-addons' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function ajax_search_products() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
		
		$args = array(
			'post_type' => 'product',
			's' => $search,
			'posts_per_page' => 20,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'variable',
				),
			),
		);
		
		$products = get_posts( $args );
		$results = array();
		
		foreach ( $products as $product ) {
			$results[] = array(
				'id' => $product->ID,
				'text' => $product->post_title,
			);
		}
		
		wp_send_json_success( $results );
	}

	public function ajax_load_variations() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		
		if ( ! $product_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid product ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$product = wc_get_product( $product_id );
		
		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			wp_send_json_error( array( 'message' => __( 'Product is not a variable product', 'rudraksha-woo-addons' ) ) );
		}
		
		// Use get_children() to get ALL variations (including those without prices)
		$variation_ids = $product->get_children();
		$variation_data = array();
		
		foreach ( $variation_ids as $variation_id ) {
			$variation_obj = wc_get_product( $variation_id );
			
			if ( ! $variation_obj ) {
				continue;
			}
			
			// Get images
			$image_id = $variation_obj->get_image_id();
			$gallery_ids = $variation_obj->get_gallery_image_ids();
			
			// Get swatch data
			$swatch_type = get_post_meta( $variation_id, 'rudraksha_variation_swatch_type', true );
			$swatch_color = get_post_meta( $variation_id, 'rudraksha_variation_swatch_color', true );
			$swatch_image_id = get_post_meta( $variation_id, 'rudraksha_variation_swatch_image', true );
			
			$variation_data[] = array(
				'id' => $variation_id,
				'attributes' => $variation_obj->get_attributes(),
				'sku' => $variation_obj->get_sku(),
				'regular_price' => $variation_obj->get_regular_price(),
				'sale_price' => $variation_obj->get_sale_price(),
				'stock_quantity' => $variation_obj->get_stock_quantity(),
				'stock_status' => $variation_obj->get_stock_status(),
				'weight' => $variation_obj->get_weight(),
				'length' => $variation_obj->get_length(),
				'width' => $variation_obj->get_width(),
				'height' => $variation_obj->get_height(),
				'image_id' => $image_id,
				'image_url' => $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : wc_placeholder_img_src(),
				'gallery_ids' => $gallery_ids,
				'gallery_images' => $this->get_gallery_images( $gallery_ids ),
				'swatch_type' => $swatch_type ? $swatch_type : 'color',
				'swatch_color' => $swatch_color,
				'swatch_image_id' => $swatch_image_id,
				'swatch_image_url' => $swatch_image_id ? wp_get_attachment_image_url( $swatch_image_id, 'thumbnail' ) : '',
			);
		}
		
		// Get available attribute options for editing
		$product_attributes = array();
		$attributes = $product->get_attributes();
		foreach ( $attributes as $attribute ) {
			$attr_name = $attribute->get_name();
			$attr_taxonomy = $attribute->is_taxonomy() ? $attr_name : 'pa_' . sanitize_title( $attr_name );
			$options = array();
			
			if ( $attribute->is_taxonomy() ) {
				$terms = $attribute->get_terms();
				if ( $terms ) {
					foreach ( $terms as $term ) {
						$options[] = array(
							'slug' => $term->slug,
							'name' => $term->name,
						);
					}
				}
			} else {
				foreach ( $attribute->get_options() as $option ) {
					$options[] = array(
						'slug' => $option,
						'name' => $option,
					);
				}
			}
			
			$product_attributes[ $attr_taxonomy ] = array(
				'name' => wc_attribute_label( $attr_name ),
				'options' => $options,
			);
		}
		
		wp_send_json_success( array(
			'variations' => $variation_data,
			'product_name' => $product->get_name(),
			'product_attributes' => $product_attributes,
		) );
	}

	private function get_gallery_images( $gallery_ids ) {
		$images = array();
		foreach ( $gallery_ids as $image_id ) {
			$images[] = array(
				'id' => $image_id,
				'url' => wp_get_attachment_image_url( $image_id, 'thumbnail' ),
			);
		}
		return $images;
	}

	public function ajax_update_variation() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		
		if ( ! $variation_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid variation ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$variation = wc_get_product( $variation_id );
		
		if ( ! $variation ) {
			wp_send_json_error( array( 'message' => __( 'Variation not found', 'rudraksha-woo-addons' ) ) );
		}
		
		// Update prices
		if ( isset( $_POST['regular_price'] ) ) {
			$variation->set_regular_price( sanitize_text_field( $_POST['regular_price'] ) );
		}
		
		if ( isset( $_POST['sale_price'] ) ) {
			$variation->set_sale_price( sanitize_text_field( $_POST['sale_price'] ) );
		}
		
		// Update SKU
		if ( isset( $_POST['sku'] ) ) {
			$variation->set_sku( sanitize_text_field( $_POST['sku'] ) );
		}
		
		// Update stock
		if ( isset( $_POST['stock_quantity'] ) ) {
			$variation->set_stock_quantity( absint( $_POST['stock_quantity'] ) );
		}
		
		if ( isset( $_POST['stock_status'] ) ) {
			$variation->set_stock_status( sanitize_text_field( $_POST['stock_status'] ) );
		}
		
		// Update shipping dimensions
		if ( isset( $_POST['weight'] ) ) {
			$variation->set_weight( sanitize_text_field( $_POST['weight'] ) );
		}
		
		if ( isset( $_POST['length'] ) ) {
			$variation->set_length( sanitize_text_field( $_POST['length'] ) );
		}
		
		if ( isset( $_POST['width'] ) ) {
			$variation->set_width( sanitize_text_field( $_POST['width'] ) );
		}
		
		if ( isset( $_POST['height'] ) ) {
			$variation->set_height( sanitize_text_field( $_POST['height'] ) );
		}
		
		// Update main image
		if ( isset( $_POST['image_id'] ) ) {
			$variation->set_image_id( absint( $_POST['image_id'] ) );
		}
		
		// Update gallery images (store as post meta since variations don't have native gallery)
		if ( isset( $_POST['gallery_ids'] ) && is_array( $_POST['gallery_ids'] ) ) {
			$gallery_ids = array_filter( array_map( 'absint', $_POST['gallery_ids'] ) );
			update_post_meta( $variation_id, '_variation_gallery_ids', $gallery_ids );
		}
		
		// Update variation attributes
		$new_attributes = array();
		foreach ( $_POST as $key => $value ) {
			if ( strpos( $key, 'attribute_' ) === 0 ) {
				$attr_key = str_replace( 'attribute_', '', $key );
				$new_attributes[ $attr_key ] = sanitize_text_field( $value );
			}
		}
		if ( ! empty( $new_attributes ) ) {
			$variation->set_attributes( $new_attributes );
		}
		
		// Save variation
		$variation->save();
		
		// Sync parent product to update variation data cache
		$parent_id = $variation->get_parent_id();
		if ( $parent_id ) {
			$parent = wc_get_product( $parent_id );
			if ( $parent ) {
				// Clear transients
				wc_delete_product_transients( $parent_id );
				
				// Sync the variable product data
				WC_Product_Variable::sync( $parent_id );
			}
		}
		
		// Update swatch meta
		if ( isset( $_POST['swatch_type'] ) ) {
			update_post_meta( $variation_id, 'rudraksha_variation_swatch_type', sanitize_text_field( $_POST['swatch_type'] ) );
		}
		
		if ( isset( $_POST['swatch_color'] ) ) {
			update_post_meta( $variation_id, 'rudraksha_variation_swatch_color', sanitize_hex_color( $_POST['swatch_color'] ) );
		}
		
		if ( isset( $_POST['swatch_image_id'] ) ) {
			update_post_meta( $variation_id, 'rudraksha_variation_swatch_image', absint( $_POST['swatch_image_id'] ) );
		}
		
		wp_send_json_success( array( 'message' => __( 'Variation updated successfully', 'rudraksha-woo-addons' ) ) );
	}

	public function ajax_duplicate_variation() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		
		if ( ! $variation_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid variation ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$variation = wc_get_product( $variation_id );
		
		if ( ! $variation ) {
			wp_send_json_error( array( 'message' => __( 'Variation not found', 'rudraksha-woo-addons' ) ) );
		}
		
		$parent_id = $variation->get_parent_id();
		
		// Create new variation
		$new_variation = new WC_Product_Variation();
		$new_variation->set_parent_id( $parent_id );
		
		// Copy attributes (we'll need to modify these manually after creation)
		$attributes = $variation->get_attributes();
		$new_variation->set_attributes( $attributes );
		
		// Copy prices
		$new_variation->set_regular_price( $variation->get_regular_price() );
		$new_variation->set_sale_price( $variation->get_sale_price() );
		
		// Copy SKU (append -copy to make it unique)
		$new_sku = $variation->get_sku() ? $variation->get_sku() . '-copy' : '';
		$new_variation->set_sku( $new_sku );
		
		// Copy stock
		$new_variation->set_stock_quantity( $variation->get_stock_quantity() );
		$new_variation->set_stock_status( $variation->get_stock_status() );
		
		// Copy dimensions
		$new_variation->set_weight( $variation->get_weight() );
		$new_variation->set_length( $variation->get_length() );
		$new_variation->set_width( $variation->get_width() );
		$new_variation->set_height( $variation->get_height() );
		
		// Copy images
		$new_variation->set_image_id( $variation->get_image_id() );
		$new_variation->set_gallery_image_ids( $variation->get_gallery_image_ids() );
		
		// Save new variation
		$new_variation_id = $new_variation->save();
		
		// Copy swatch meta
		$swatch_type = get_post_meta( $variation_id, 'rudraksha_variation_swatch_type', true );
		$swatch_color = get_post_meta( $variation_id, 'rudraksha_variation_swatch_color', true );
		$swatch_image_id = get_post_meta( $variation_id, 'rudraksha_variation_swatch_image', true );
		
		if ( $swatch_type ) {
			update_post_meta( $new_variation_id, 'rudraksha_variation_swatch_type', $swatch_type );
		}
		if ( $swatch_color ) {
			update_post_meta( $new_variation_id, 'rudraksha_variation_swatch_color', $swatch_color );
		}
		if ( $swatch_image_id ) {
			update_post_meta( $new_variation_id, 'rudraksha_variation_swatch_image', $swatch_image_id );
		}
		
		// Get data for the new variation
		$new_obj = wc_get_product( $new_variation_id );
		$image_id = $new_obj->get_image_id();
		$gallery_ids = $new_obj->get_gallery_image_ids();
		
		$response_data = array(
			'id' => $new_variation_id,
			'attributes' => $new_obj->get_attributes(),
			'sku' => $new_obj->get_sku(),
			'regular_price' => $new_obj->get_regular_price(),
			'sale_price' => $new_obj->get_sale_price(),
			'stock_quantity' => $new_obj->get_stock_quantity(),
			'stock_status' => $new_obj->get_stock_status(),
			'weight' => $new_obj->get_weight(),
			'length' => $new_obj->get_length(),
			'width' => $new_obj->get_width(),
			'height' => $new_obj->get_height(),
			'image_id' => $image_id,
			'image_url' => $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : wc_placeholder_img_src(),
			'gallery_ids' => $gallery_ids,
			'gallery_images' => $this->get_gallery_images( $gallery_ids ),
			'swatch_type' => $swatch_type ? $swatch_type : 'color',
			'swatch_color' => $swatch_color,
			'swatch_image_id' => $swatch_image_id,
			'swatch_image_url' => $swatch_image_id ? wp_get_attachment_image_url( $swatch_image_id, 'thumbnail' ) : '',
		);
		

		wp_send_json_success( array( 
			'message' => __( 'Variation duplicated successfully', 'rudraksha-woo-addons' ),
			'variation' => $response_data,
		) );
	}

	public function ajax_delete_variation() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		
		if ( ! $variation_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid variation ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$variation = wc_get_product( $variation_id );
		
		if ( ! $variation ) {
			wp_send_json_error( array( 'message' => __( 'Variation not found', 'rudraksha-woo-addons' ) ) );
		}
		
		// Delete variation
		$variation->delete( true );
		
		wp_send_json_success( array( 'message' => __( 'Variation deleted successfully', 'rudraksha-woo-addons' ) ) );
	}

	public function ajax_get_attributes() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		
		if ( ! $product_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid product ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$product = wc_get_product( $product_id );
		
		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			wp_send_json_error( array( 'message' => __( 'Product is not a variable product', 'rudraksha-woo-addons' ) ) );
		}
		
		$attributes = $product->get_attributes();
		$attr_data = array();
		
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}
			
			$options = array();
			if ( $attribute->is_taxonomy() ) {
				$terms = $attribute->get_terms();
				foreach ( $terms as $term ) {
					$options[] = $term->name;
				}
			} else {
				$options = $attribute->get_options();
			}
			
			$attr_data[] = array(
				'name' => $attribute->get_name(),
				'label' => wc_attribute_label( $attribute->get_name() ),
				'options' => $options,
			);
		}
		
		wp_send_json_success( array( 'attributes' => $attr_data ) );
	}

	public function ajax_create_variation() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$attributes = isset( $_POST['attributes'] ) ? $_POST['attributes'] : array();
		
		if ( ! $product_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid product ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$product = wc_get_product( $product_id );
		
		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			wp_send_json_error( array( 'message' => __( 'Product is not a variable product', 'rudraksha-woo-addons' ) ) );
		}
		
		// Create new variation
		$variation = new WC_Product_Variation();
		$variation->set_parent_id( $product_id );
		
		// Set attributes
		$sanitized_attributes = array();
		foreach ( $attributes as $key => $value ) {
			$sanitized_attributes[ sanitize_text_field( $key ) ] = sanitize_text_field( $value );
		}
		$variation->set_attributes( $sanitized_attributes );
		
		// Save variation
		$variation_id = $variation->save();
		
		// Sync parent product cache
		wc_delete_product_transients( $product_id );
		WC_Product_Variable::sync( $product_id );
		
		// Get fresh data
		$variation_obj = wc_get_product( $variation_id );
		$image_id = $variation_obj->get_image_id();
		$gallery_ids = $variation_obj->get_gallery_image_ids();
		
		$response_data = array(
			'id' => $variation_id,
			'attributes' => $variation_obj->get_attributes(),
			'sku' => $variation_obj->get_sku(),
			'regular_price' => $variation_obj->get_regular_price(),
			'sale_price' => $variation_obj->get_sale_price(),
			'stock_quantity' => $variation_obj->get_stock_quantity(),
			'stock_status' => $variation_obj->get_stock_status(),
			'weight' => $variation_obj->get_weight(),
			'length' => $variation_obj->get_length(),
			'width' => $variation_obj->get_width(),
			'height' => $variation_obj->get_height(),
			'image_id' => $image_id,
			'image_url' => $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : wc_placeholder_img_src(),
			'gallery_ids' => $gallery_ids,
			'gallery_images' => $this->get_gallery_images( $gallery_ids ),
			'swatch_type' => 'color',
			'swatch_color' => '',
			'swatch_image_id' => '',
			'swatch_image_url' => '',
		);
		
		wp_send_json_success( array( 
			'message' => __( 'Variation created successfully', 'rudraksha-woo-addons' ),
			'variation' => $response_data,
		) );
	}

	public function ajax_generate_variations() {
		check_ajax_referer( 'rvm_nonce', 'nonce' );
		
		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		
		if ( ! $product_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid product ID', 'rudraksha-woo-addons' ) ) );
		}
		
		$product = wc_get_product( $product_id );
		
		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			wp_send_json_error( array( 'message' => __( 'Product is not a variable product', 'rudraksha-woo-addons' ) ) );
		}
		
		// Get product attributes
		$attributes = $product->get_attributes();
		$variation_attributes = array();
		
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}
			
			$attribute_name = $attribute->get_name();
			$options = array();
			
			if ( $attribute->is_taxonomy() ) {
				$terms = $attribute->get_terms();
				foreach ( $terms as $term ) {
					$options[] = $term->slug;
				}
			} else {
				$options = $attribute->get_options();
			}
			
			if ( ! empty( $options ) ) {
				$variation_attributes[ $attribute_name ] = $options;
			}
		}
		
		if ( empty( $variation_attributes ) ) {
			wp_send_json_error( array( 'message' => __( 'No variation attributes found. Please add attributes to the product first.', 'rudraksha-woo-addons' ) ) );
		}
		
		// Generate all combinations
		$combinations = $this->get_attribute_combinations( $variation_attributes );
		
		// Get existing variations to avoid duplicates
		$existing_variations = $product->get_children();
		$existing_combos = array();
		foreach ( $existing_variations as $existing_id ) {
			$existing_var = wc_get_product( $existing_id );
			if ( $existing_var ) {
				$existing_combos[] = $existing_var->get_attributes();
			}
		}
		
		$created_count = 0;
		foreach ( $combinations as $combination ) {
			// Check if combination already exists
			$exists = false;
			foreach ( $existing_combos as $existing_combo ) {
				if ( $combination === $existing_combo ) {
					$exists = true;
					break;
				}
			}
			
			if ( $exists ) {
				continue;
			}
			
			// Create variation
			$variation = new WC_Product_Variation();
			$variation->set_parent_id( $product_id );
			$variation->set_attributes( $combination );
			$variation->save();
			$created_count++;
		}
		
		// Sync parent product cache after all variations created
		wc_delete_product_transients( $product_id );
		WC_Product_Variable::sync( $product_id );
		
		wp_send_json_success( array( 
			'message' => sprintf( __( 'Generated %d new variations', 'rudraksha-woo-addons' ), $created_count ),
			'created_count' => $created_count,
		) );
	}

	private function get_attribute_combinations( $attributes ) {
		$result = array( array() );
		
		foreach ( $attributes as $attribute_name => $values ) {
			$tmp = array();
			foreach ( $result as $result_item ) {
				foreach ( $values as $value ) {
					$tmp[] = array_merge( $result_item, array( 'attribute_' . $attribute_name => $value ) );
				}
			}
			$result = $tmp;
		}
		
		return $result;
	}
}
