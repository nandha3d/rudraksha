<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rudraksha_Swatches {

	public function __construct() {
		// Enqueue assets
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		
		// Override variable template or hook into form
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'render_swatches' ), 10, 2 );

		// Add Admin Fields for Attributes
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		
		// Add Fields to Product Variations
		add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'add_variation_settings' ), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_settings' ), 10, 2 );

		// Filter Price HTML to add Percentage Off
		add_filter( 'woocommerce_format_sale_price', array( $this, 'add_percentage_to_sale_price' ), 10, 3 );

		// Redirect after add to cart to prevent form resubmission on refresh
		add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'redirect_after_add_to_cart' ) );

		// Hook into all attribute edit forms
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				$taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
				add_action( $taxonomy_name . '_add_form_fields', array( $this, 'add_attribute_fields' ) );
				add_action( $taxonomy_name . '_edit_form_fields', array( $this, 'edit_attribute_fields' ), 10, 2 );
				add_action( 'created_' . $taxonomy_name, array( $this, 'save_attribute_fields' ) );
				add_action( 'edited_' . $taxonomy_name, array( $this, 'save_attribute_fields' ) );
			}
		}
	}

	public function enqueue_admin_assets() {
		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'rudraksha-admin-js', RUDRAKSHA_WOO_ADDONS_URL . 'modules/swatches/assets/js/admin-swatches.js', array( 'jquery', 'wp-color-picker' ), RUDRAKSHA_WOO_ADDONS_VERSION, true );
	}

	public function add_attribute_fields( $taxonomy ) {
		?>
		<div class="form-field">
			<label for="rudraksha_swatch_type"><?php _e( 'Swatch Type', 'rudraksha-woo-addons' ); ?></label>
			<select name="rudraksha_swatch_type" id="rudraksha_swatch_type">
				<option value="text"><?php _e( 'Text', 'rudraksha-woo-addons' ); ?></option>
				<option value="color"><?php _e( 'Color', 'rudraksha-woo-addons' ); ?></option>
				<option value="image"><?php _e( 'Image', 'rudraksha-woo-addons' ); ?></option>
			</select>
		</div>
		<div class="form-field" id="rudraksha-color-swatch-field" style="display:none;">
			<label for="rudraksha_swatch_color"><?php _e( 'Color', 'rudraksha-woo-addons' ); ?></label>
			<input type="text" name="rudraksha_swatch_color" id="rudraksha_swatch_color" class="rudraksha-color-picker" value="" />
		</div>
		<div class="form-field" id="rudraksha-image-swatch-field" style="display:none;">
			<label><?php _e( 'Image', 'rudraksha-woo-addons' ); ?></label>
			<div id="rudraksha-image-preview" style="margin-bottom: 10px;"></div>
			<input type="hidden" name="rudraksha_swatch_image" id="rudraksha_swatch_image" value="" />
			<button type="button" class="button rudraksha-upload-image"><?php _e( 'Upload/Add Image', 'rudraksha-woo-addons' ); ?></button>
			<button type="button" class="button rudraksha-remove-image" style="display:none;"><?php _e( 'Remove Image', 'rudraksha-woo-addons' ); ?></button>
		</div>
		<?php
	}

	public function edit_attribute_fields( $term, $taxonomy ) {
		$type  = get_term_meta( $term->term_id, 'rudraksha_swatch_type', true );
		$color = get_term_meta( $term->term_id, 'rudraksha_swatch_color', true );
		$image = get_term_meta( $term->term_id, 'rudraksha_swatch_image', true );
		$image_url = $image ? wp_get_attachment_image_url( $image, 'thumbnail' ) : '';
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="rudraksha_swatch_type"><?php _e( 'Swatch Type', 'rudraksha-woo-addons' ); ?></label></th>
			<td>
				<select name="rudraksha_swatch_type" id="rudraksha_swatch_type">
					<option value="text" <?php selected( $type, 'text' ); ?>><?php _e( 'Text', 'rudraksha-woo-addons' ); ?></option>
					<option value="color" <?php selected( $type, 'color' ); ?>><?php _e( 'Color', 'rudraksha-woo-addons' ); ?></option>
					<option value="image" <?php selected( $type, 'image' ); ?>><?php _e( 'Image', 'rudraksha-woo-addons' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field" id="rudraksha-color-swatch-field" style="<?php echo 'color' !== $type ? 'display:none;' : ''; ?>">
			<th scope="row" valign="top"><label for="rudraksha_swatch_color"><?php _e( 'Color', 'rudraksha-woo-addons' ); ?></label></th>
			<td>
				<input type="text" name="rudraksha_swatch_color" id="rudraksha_swatch_color" class="rudraksha-color-picker" value="<?php echo esc_attr( $color ); ?>" />
			</td>
		</tr>
		<tr class="form-field" id="rudraksha-image-swatch-field" style="<?php echo 'image' !== $type ? 'display:none;' : ''; ?>">
			<th scope="row" valign="top"><label><?php _e( 'Image', 'rudraksha-woo-addons' ); ?></label></th>
			<td>
				<div id="rudraksha-image-preview" style="margin-bottom: 10px;">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" width="60px" height="60px" />
					<?php endif; ?>
				</div>
				<input type="hidden" name="rudraksha_swatch_image" id="rudraksha_swatch_image" value="<?php echo esc_attr( $image ); ?>" />
				<button type="button" class="button rudraksha-upload-image"><?php _e( 'Upload/Add Image', 'rudraksha-woo-addons' ); ?></button>
				<button type="button" class="button rudraksha-remove-image" style="<?php echo ! $image ? 'display:none;' : ''; ?>"><?php _e( 'Remove Image', 'rudraksha-woo-addons' ); ?></button>
			</td>
		</tr>
		<?php
	}

	public function save_attribute_fields( $term_id ) {
		if ( isset( $_POST['rudraksha_swatch_type'] ) ) {
			update_term_meta( $term_id, 'rudraksha_swatch_type', sanitize_text_field( $_POST['rudraksha_swatch_type'] ) );
		}
		if ( isset( $_POST['rudraksha_swatch_color'] ) ) {
			update_term_meta( $term_id, 'rudraksha_swatch_color', sanitize_hex_color( $_POST['rudraksha_swatch_color'] ) );
		}
		if ( isset( $_POST['rudraksha_swatch_image'] ) ) {
			update_term_meta( $term_id, 'rudraksha_swatch_image', absint( $_POST['rudraksha_swatch_image'] ) );
		}
	}

	public function add_variation_settings( $loop, $variation_data, $variation ) {
		$swatch_image_id = get_post_meta( $variation->ID, 'rudraksha_variation_swatch_image', true );
		$image_url = $swatch_image_id ? wp_get_attachment_image_url( $swatch_image_id, 'thumbnail' ) : '';
		?>
		<div class="rudraksha-variation-swatch-field form-row form-row-full">
			<h4><?php _e( 'Custom Swatch Image', 'rudraksha-woo-addons' ); ?></h4>
			<p class="description"><?php _e( 'Upload a specific image for this variation\'s swatch button. Overrides global attribute image.', 'rudraksha-woo-addons' ); ?></p>
			
			<div class="rudraksha-variation-image-preview" style="margin-bottom: 10px;">
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" width="60px" height="60px" />
				<?php endif; ?>
			</div>
			
			<input type="hidden" name="rudraksha_variation_swatch_image[<?php echo esc_attr( $loop ); ?>]" class="rudraksha_variation_swatch_image" value="<?php echo esc_attr( $swatch_image_id ); ?>" />
			
			<button type="button" class="button rudraksha-upload-variation-image"><?php _e( 'Upload Swatch Image', 'rudraksha-woo-addons' ); ?></button>
			<button type="button" class="button rudraksha-remove-variation-image" style="<?php echo ! $swatch_image_id ? 'display:none;' : ''; ?>"><?php _e( 'Remove', 'rudraksha-woo-addons' ); ?></button>
		</div>
		<?php
	}

	public function save_variation_settings( $variation_id, $i ) {
		if ( isset( $_POST['rudraksha_variation_swatch_image'][ $i ] ) ) {
			update_post_meta( $variation_id, 'rudraksha_variation_swatch_image', absint( $_POST['rudraksha_variation_swatch_image'][ $i ] ) );
		}
	}

	public function add_percentage_to_sale_price( $price, $regular_price, $sale_price ) {
		// Strip HTML tags and currency symbols to get raw numbers
		$regular_price_float = (float) strip_tags( $regular_price );
		$sale_price_float    = (float) strip_tags( $sale_price );

		if ( $regular_price_float > 0 && $sale_price_float > 0 && $regular_price_float > $sale_price_float ) {
			$percentage = round( ( ( $regular_price_float - $sale_price_float ) / $regular_price_float ) * 100 );
			$price .= ' <span class="rudraksha-discount-badge">' . $percentage . '% OFF</span>';
		}

		return $price;
	}

	public function redirect_after_add_to_cart( $url ) {
		// Redirect back to the same product page to prevent form resubmission
		if ( ! empty( $_REQUEST['add-to-cart'] ) ) {
			$product_id = absint( $_REQUEST['add-to-cart'] );
			return get_permalink( $product_id );
		}
		return $url;
	}

	public function enqueue_assets() {
		if ( ! is_product() ) {
			return;
		}
		wp_enqueue_style( 'rudraksha-swatches-css', RUDRAKSHA_WOO_ADDONS_URL . 'modules/swatches/assets/css/swatches.css', array(), RUDRAKSHA_WOO_ADDONS_VERSION );
		wp_enqueue_script( 'rudraksha-swatches-js', RUDRAKSHA_WOO_ADDONS_URL . 'modules/swatches/assets/js/swatches.js', array( 'jquery', 'wc-add-to-cart-variation' ), RUDRAKSHA_WOO_ADDONS_VERSION, true );
	}

	public function render_swatches( $html, $args ) {
		$wc_options = $args['options']; // WooCommerce's filtered options (available for current selection)
		$product    = $args['product'];
		$attribute  = $args['attribute'];
		
		// Get ALL options for this attribute from product (not just available ones)
		// Use menu_order to respect custom sort order set in WooCommerce
		$all_options = array();
		if ( ! empty( $product ) && ! empty( $attribute ) ) {
			$product_attributes = $product->get_attributes();
			if ( isset( $product_attributes[ $attribute ] ) ) {
				$product_attribute = $product_attributes[ $attribute ];
				if ( $product_attribute->is_taxonomy() ) {
					// Get terms with menu_order preserved
					$terms = wc_get_product_terms( $product->get_id(), $product_attribute->get_name(), array( 
						'fields' => 'all',
						'orderby' => 'menu_order',
						'order' => 'ASC'
					) );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						$all_options = wp_list_pluck( $terms, 'slug' );
					}
				} else {
					$all_options = $product_attribute->get_options();
				}
			}
		}
		
		// Use all options if we got them, otherwise fall back to WooCommerce's list
		$options = ! empty( $all_options ) ? $all_options : $wc_options;
		
		// Smart size ordering - automatically order common sizes logically
		if ( strpos( strtolower( $attribute ), 'size' ) !== false ) {
			$size_order = array( 'xs', 'extra-small', 'extrasmall', 's', 'small', 'm', 'medium', 'l', 'large', 'xl', 'extra-large', 'extralarge', 'xxl', '2xl', 'xxxl', '3xl' );
			usort( $options, function( $a, $b ) use ( $size_order ) {
				$a_lower = strtolower( $a );
				$b_lower = strtolower( $b );
				$a_pos = array_search( $a_lower, $size_order );
				$b_pos = array_search( $b_lower, $size_order );
				
				// If both found in size_order, sort by position
				if ( $a_pos !== false && $b_pos !== false ) {
					return $a_pos - $b_pos;
				}
				// If only one found, put the found one first
				if ( $a_pos !== false ) return -1;
				if ( $b_pos !== false ) return 1;
				// If neither found, keep original order
				return 0;
			});
		}

		if ( empty( $options ) ) {
			return $html;
		}

		// Determine Swatch Type based on Attribute Name or Settings
		$is_card_layout = ( strpos( strtolower( $attribute ), 'design' ) !== false );
		
		$wrapper_class = $is_card_layout ? 'rudraksha-swatches-cards' : 'rudraksha-swatches-buttons';
		$swatch_html   = '<div class="rudraksha-swatches ' . esc_attr( $wrapper_class ) . '" data-attribute="' . esc_attr( $attribute ) . '">';
		
		// Get ALL variations (including those without prices)
		$variation_ids = $product->get_children();
		$base_price = $product->get_price();

		foreach ( $options as $option ) {
			$checked = isset( $_REQUEST[ 'attribute_' . $attribute ] ) && checked( $_REQUEST[ 'attribute_' . $attribute ], sanitize_title( $option ), false ) ? 'selected' : '';
			
			// Check if this option is in WooCommerce's available list
			$is_available = in_array( $option, (array) $wc_options, true );
			$disabled_class = $is_available ? '' : 'disabled';
			
			// Get Term Meta - Try by slug first (standard), then name
			$term = get_term_by( 'slug', $option, $attribute );
			if ( ! $term ) {
				$term = get_term_by( 'name', $option, $attribute );
			}
			
			$swatch_type = 'text';
			$swatch_color = '';
			$swatch_image_id = '';
			$swatch_image_id = '';

			if ( $term && ! is_wp_error( $term ) ) {
				$swatch_type = get_term_meta( $term->term_id, 'rudraksha_swatch_type', true );
				$swatch_color = get_term_meta( $term->term_id, 'rudraksha_swatch_color', true );
				$swatch_image_id = get_term_meta( $term->term_id, 'rudraksha_swatch_image', true );
			}

			$content = esc_html( $option );
			
			// Calculate Price Difference
			$price_diff_html = '';
			if ( $is_card_layout ) {
				foreach ( $variation_ids as $var_id ) {
					$var_obj = wc_get_product( $var_id );
					if ( ! $var_obj ) continue;
					
					$var_attrs = $var_obj->get_attributes();
					$attr_val = isset( $var_attrs[ $attribute ] ) ? $var_attrs[ $attribute ] : '';
					
					if ( $attr_val === $option || $attr_val === sanitize_title( $option ) ) {
						$variation_price = $var_obj->get_price();
						if ( $variation_price && $base_price ) {
							$diff = floatval( $variation_price ) - floatval( $base_price );
							
							if ( $diff > 0 ) {
								$price_diff_html = '<span class="swatch-price">+ ' . wc_price( $diff ) . '</span>';
							} elseif ( $diff < 0 ) {
								$price_diff_html = '<span class="swatch-price">- ' . wc_price( abs( $diff ) ) . '</span>';
							} else {
								$price_diff_html = '<span class="swatch-price">+ ' . wc_price( 0 ) . '</span>';
							}
						} else {
							$price_diff_html = '<span class="swatch-price">+ ' . wc_price( 0 ) . '</span>';
						}
						break;
					}
				}
			}

			if ( $is_card_layout ) {
				// Card Layout (Image + Title + Price)
				$img_src = wc_placeholder_img_src();
				
				// Priority: 1. Variation Custom Swatch Image, 2. Global Term Meta Image, 3. Variation Main Image
				$variation_custom_swatch = '';
				$variation_main_image = '';

				foreach ( $variation_ids as $var_id ) {
					$var_obj = wc_get_product( $var_id );
					if ( ! $var_obj ) continue;
					
					$var_attrs = $var_obj->get_attributes();
					$attr_val = isset( $var_attrs[ $attribute ] ) ? $var_attrs[ $attribute ] : '';
					
					if ( $attr_val === $option || $attr_val === sanitize_title( $option ) ) {
						// Check for custom swatch image
						$custom_id = get_post_meta( $var_id, 'rudraksha_variation_swatch_image', true );
						if ( $custom_id ) {
							$variation_custom_swatch = wp_get_attachment_image_url( $custom_id, 'thumbnail' );
						}
						
						$var_image_id = $var_obj->get_image_id();
						if ( $var_image_id ) {
							$variation_main_image = wp_get_attachment_image_url( $var_image_id, 'thumbnail' );
						}
						break;
					}
				}

				if ( $variation_custom_swatch ) {
					$img_src = $variation_custom_swatch;
				} elseif ( $swatch_image_id ) {
					$img_src = wp_get_attachment_image_url( $swatch_image_id, 'thumbnail' );
				} elseif ( $variation_main_image ) {
					$img_src = $variation_main_image;
				}

				$content  = '<div class="swatch-image"><img src="' . esc_url( $img_src ) . '" alt="' . esc_attr( $option ) . '" /></div>';
				$content .= '<div class="swatch-info">';
				$content .= '<span class="swatch-title">' . esc_html( $option ) . '</span>';
				$content .= $price_diff_html;
				$content .= '</div>';

			} elseif ( 'color' === $swatch_type && $swatch_color ) {
				// Color Swatch
				$content = '<span class="swatch-color" style="background-color:' . esc_attr( $swatch_color ) . ';"></span>';
				$content .= '<span class="swatch-tooltip">' . esc_html( $option ) . '</span>';
				$wrapper_class .= ' has-colors'; // Helper for CSS
			} elseif ( 'image' === $swatch_type && $swatch_image_id ) {
				// Image Swatch (Small)
				$img_src = wp_get_attachment_image_url( $swatch_image_id, 'thumbnail' );
				$content = '<img src="' . esc_url( $img_src ) . '" alt="' . esc_attr( $option ) . '" class="swatch-img-small" />';
				$content .= '<span class="swatch-tooltip">' . esc_html( $option ) . '</span>';
			}
			
			$swatch_html .= sprintf(
				'<label class="rudraksha-swatch-label %s %s %s" data-value="%s" title="%s">%s<input type="radio" name="%s" value="%s" %s class="rudraksha-swatch-input" /></label>',
				$checked,
				esc_attr( $swatch_type ),
				$disabled_class,
				esc_attr( $option ),
				esc_attr( $option ),
				$content,
				esc_attr( 'attribute_' . $attribute ),
				esc_attr( $option ),
				$checked
			);
		}
		
		$swatch_html .= '</div>';

		$html = '<div class="rudraksha-swatches-wrapper">' . $swatch_html . '<div style="display:none;">' . $html . '</div></div>';

		return $html;
	}
}
