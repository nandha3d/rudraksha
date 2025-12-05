<?php
/**
 * Custom Product Image Template with Swiper and Zoom
 */

defined( 'ABSPATH' ) || exit;

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );

$attachment_ids = $product->get_gallery_image_ids();
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <div class="swiper-container product-gallery-slider">
        <div class="swiper-wrapper">
            <?php
            if ( $product->get_image_id() ) {
                $html  = '<div class="swiper-slide">';
                $html .= '<div class="woocommerce-product-gallery__image--placeholder">';
                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" data-large_image="%s" />', 
                    wp_get_attachment_image_url( $post_thumbnail_id, 'woocommerce_single' ),
                    esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ),
                    wp_get_attachment_image_url( $post_thumbnail_id, 'full' )
                );
                $html .= '</div>';
                $html .= '</div>';
            } else {
                $html  = '<div class="swiper-slide">';
                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
                $html .= '</div>';
            }
            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

            if ( $attachment_ids && $product->get_image_id() ) {
                foreach ( $attachment_ids as $attachment_id ) {
                    $full_src = wp_get_attachment_image_url( $attachment_id, 'full' );
                    $html  = '<div class="swiper-slide">';
                    $html .= '<div class="woocommerce-product-gallery__image">';
                    $html .= sprintf( '<img src="%s" alt="%s" data-large_image="%s" />', 
                        wp_get_attachment_image_url( $attachment_id, 'woocommerce_single' ),
                        esc_attr( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ),
                        $full_src
                    );
                    $html .= '</div>';
                    $html .= '</div>';
                    echo $html;
                }
            }
            ?>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <?php if ( $attachment_ids && $product->get_image_id() ) : ?>
    <div class="swiper-container product-gallery-thumbs" style="margin-top: 10px;">
        <div class="swiper-wrapper">
            <?php
            // Main Image Thumb
            echo '<div class="swiper-slide" style="cursor: pointer;">';
            echo wp_get_attachment_image( $post_thumbnail_id, 'woocommerce_gallery_thumbnail' );
            echo '</div>';

            foreach ( $attachment_ids as $attachment_id ) {
                echo '<div class="swiper-slide" style="cursor: pointer;">';
                echo wp_get_attachment_image( $attachment_id, 'woocommerce_gallery_thumbnail' );
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php endif; ?>
</div>
