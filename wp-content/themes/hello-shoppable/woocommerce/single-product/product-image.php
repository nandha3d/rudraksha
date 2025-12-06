<?php
/**
 * Custom Product Image Template with Swiper and Zoom
 * Overwritten by Antigravity to fix Styles & Features
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
<style>
/* 
 * CRITICAL STYLES - DO NOT REMOVE
 * Consolidated fixes for Title, Gallery, Buttons
 */

/* 1. Gallery Container & Glow Animation */
.product-gallery-slider {
    position: relative !important;
    background: #fefaf1 !important;
    border-radius: 30px !important;
    overflow: hidden !important;
    aspect-ratio: 1 / 1;
    border: 1px solid #6d2911 !important; /* 1px Border as requested */
    animation: brownGlow 3s ease-in-out infinite !important;
    box-shadow: none !important;
    margin-bottom: 20px !important;
}

@keyframes brownGlow {
    0%, 100% {
        box-shadow: 0 0 15px rgba(109, 41, 17, 0.3); /* Stronger Glow Start */
        border-color: #6d2911;
    }
    50% {
        box-shadow: 0 0 30px rgba(109, 41, 17, 0.6); /* Max Glow */
        border-color: #8a3c20; /* Slightly lighter border on pulse */
    }
}

/* Thumbnails 1px Border & Glow */
.product-gallery-thumbs .swiper-slide {
    border: 1px solid #6d2911 !important; /* 1px Border for thumbnails */
    border-radius: 10px !important;
    overflow: hidden !important;
    box-sizing: border-box !important;
}

.product-gallery-thumbs .swiper-slide-thumb-active {
    animation: brownGlow 3s ease-in-out infinite !important; /* Animate active thumb too */
}

/* 2. Full Image Cover - SLIGHTLY LARGER to ensure no gaps */
.product-gallery-slider .swiper-slide {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 30px !important;
    overflow: hidden !important;
    background: #fefaf1 !important;
    cursor: zoom-in;
}

.product-gallery-slider .swiper-slide img {
    width: 101% !important; /* 1% larger to cover gaps */
    height: 101% !important;
    object-fit: cover !important;
    margin: -0.5% !important; /* Center the slight overflow */
    padding: 0 !important;
    display: block !important;
    border-radius: 30px !important;
    transition: transform 0.4s ease !important;
}

.product-gallery-slider .swiper-slide.zoomed {
    cursor: zoom-out;
}

.product-gallery-slider .swiper-slide.zoomed img {
    transform: scale(2.5);
}

/* 3. Navigation Arrows - Clean White Circles */
.gallery-nav-btn {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: 44px !important;
    height: 44px !important;
    background: rgba(255, 255, 255, 0.9) !important;
    border: none !important;
    border-radius: 50% !important;
    cursor: pointer !important;
    z-index: 99 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.3s ease !important;
    opacity: 1 !important;
    padding: 0 !important;
}

.gallery-nav-btn:hover {
    background: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-50%) scale(1.05) !important;
}

.gallery-nav-btn svg {
    width: 22px !important;
    height: 22px !important;
    stroke: #333 !important;
    stroke-width: 2.5 !important;
    fill: none !important;
    stroke-linecap: round !important;
    stroke-linejoin: round !important;
}

.gallery-nav-prev { left: 15px !important; }
.gallery-nav-next { right: 15px !important; }

/* Hide ALL default Swiper arrows completely */
.product-gallery-slider .swiper-button-next,
.product-gallery-slider .swiper-button-prev,
.swiper-button-next,
.swiper-button-prev,
.product-gallery-slider > .swiper-button-next,
.product-gallery-slider > .swiper-button-prev {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
    width: 0 !important;
    height: 0 !important;
}

/* Inner wrapper styling */
.product-gallery-slider .swiper-slide .woocommerce-product-gallery__image,
.product-gallery-slider .swiper-slide .woocommerce-product-gallery__image--placeholder {
    width: 100% !important;
    height: 100% !important;
}

/* 4. Product Title - Serif H1 style (HUGE 65px) - AGGRESSIVE SELECTOR */
/* Targeting H1, H2, class, id - everything to ensure override */
body.single-product .product_title,
body.single-product h1.product_title, 
body.single-product h2.product_title,
body.single-product .entry-title, 
body.single-product h1,
.woocommerce-products-header__title.page-title,
.elementor-heading-title {
    font-family: 'Playfair Display', serif !important;
    font-weight: 700 !important;
    font-size: 65px !important; /* Forced Huge */
    color: #6d2911 !important; /* Theme Primary Brown */
    line-height: 1.1 !important;
    margin-bottom: 0.5em !important;
    letter-spacing: -1px !important;
}

/* 5. Add to Cart Button - OUTLINE STYLE */
button.single_add_to_cart_button, .single_add_to_cart_button.button {
    background-color: transparent !important;
    background: transparent !important;
    color: #6d2911 !important;
    border: 1px solid #6d2911 !important;
    box-shadow: none !important;
    text-shadow: none !important;
}
button.single_add_to_cart_button:hover {
    background-color: #6d2911 !important;
    color: #ffffff !important;
}

/* 6. Swatches & Variations Background - TRANSPARENT */
.rudraksha-swatches-wrapper,
.rudraksha-swatches,
.variations_form,
.variations,
div.product form.cart,
.summary.entry-summary,
.rudraksha-swatch-label {
    background-color: transparent !important;
}

/* Ensure individual swatches blend if they have bg */
.rudraksha-swatch-label {
    border-color: #6d2911 !important; /* Optional: Make borders theme color */
}

/* Ensure page background is cream */
.single-product .site-content,
.single-product .content-area,
.single-product #content {
    background-color: #fefaf1 !important;
}

/* 7. Hide Tooltips and Pagination */
.swiper-pagination,
.swiper-pagination-fraction {
    display: none !important;
}
</style>

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
        
        <!-- Modern SVG Arrows -->
        <button class="gallery-nav-btn gallery-nav-prev" aria-label="Previous">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <polyline points="15,18 9,12 15,6"></polyline>
            </svg>
        </button>
        <button class="gallery-nav-btn gallery-nav-next" aria-label="Next">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <polyline points="9,6 15,12 9,18"></polyline>
            </svg>
        </button>
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

<script>
jQuery(document).ready(function($) {
    console.log('Rudraksha Gallery Script 6.0 (Theme Fix + JS Force)');

    // ----------------------------------------------------
    // JS FORCE STYLES (Debug Solution)
    // ----------------------------------------------------
    function forceStyles() {
        console.log('Forcing Styles via JS...');

        // 1. Force Title Size
        var $titles = $('.product_title, h1.elementor-heading-title, .entry-title, .woocommerce-products-header__title.page-title');
        $titles.each(function() {
            $(this).css({
                'font-size': '65px',
                'font-family': "'Playfair Display', serif",
                'color': '#6d2911',
                'line-height': '1.1',
                'font-weight': '700'
            });
            // Also try to set important via pure JS
            this.style.setProperty('font-size', '65px', 'important');
            this.style.setProperty('font-family', "'Playfair Display', serif", 'important');
            this.style.setProperty('color', '#6d2911', 'important');
        });

        // 2. Force Add to Cart Outline
        var $btns = $('button.single_add_to_cart_button, .single_add_to_cart_button.button');
        $btns.each(function() {
            $(this).css({
                'background': 'transparent',
                'background-color': 'transparent',
                'border': '1px solid #6d2911',
                'color': '#6d2911',
                'box-shadow': 'none',
                'text-shadow': 'none'
            });
            this.style.setProperty('background', 'transparent', 'important');
            this.style.setProperty('background-color', 'transparent', 'important');
            this.style.setProperty('color', '#6d2911', 'important');
            this.style.setProperty('border', '1px solid #6d2911', 'important');
        });

        // Hover effect for button via JS (since inline styles override CSS hover)
        $btns.on('mouseenter', function() {
            this.style.setProperty('background-color', '#6d2911', 'important');
            this.style.setProperty('color', '#ffffff', 'important');
        }).on('mouseleave', function() {
            this.style.setProperty('background-color', 'transparent', 'important');
            this.style.setProperty('color', '#6d2911', 'important');
        });
    }

    // Run immediately, then every 500ms for 3 seconds
    forceStyles();
    var attempts = 0;
    var interval = setInterval(function() {
        forceStyles();
        attempts++;
        if (attempts > 6) clearInterval(interval);
    }, 500);

    // ----------------------------------------------------
    // GALLERY LOGIC
    // ----------------------------------------------------

    // Remove titles/alts to prevent tooltips
    $('.product-gallery-slider img').removeAttr('title').removeAttr('alt');

    // Initialize Thumbs Swiper
    var galleryThumbs = new Swiper('.product-gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        preventClicks: false,
        preventClicksPropagation: false
    });

    // Initialize Main Swiper
    var galleryTop = new Swiper('.product-gallery-slider', {
        spaceBetween: 0,
        thumbs: {
            swiper: galleryThumbs
        },
        preventClicks: false,
        preventClicksPropagation: false,
        touchStartPreventDefault: false
    });

    // Custom navigation buttons
    $(document).on('click', '.gallery-nav-prev', function(e) {
        e.preventDefault();
        e.stopPropagation();
        galleryTop.slidePrev();
    });

    $(document).on('click', '.gallery-nav-next', function(e) {
        e.preventDefault();
        e.stopPropagation();
        galleryTop.slideNext();
    });

    // Fade in gallery
    $('.woocommerce-product-gallery').css('opacity', 1);

    // IMPORTANT: Hide any default Swiper buttons that may have been created
    $('.swiper-button-next, .swiper-button-prev').remove();

    // Remove tooltip attributes again after Swiper init
    setTimeout(function() {
        $('.product-gallery-slider img').removeAttr('title').removeAttr('alt');
    }, 500);

    // Zoom functionality using Event Delegation
    // This works even if Swiper manipulates the DOM
    $(document).on('click', '.product-gallery-slider .swiper-slide', function(e) {
        // Don't zoom if clicking on nav buttons
        if ($(e.target).closest('.gallery-nav-btn').length || $(e.target).closest('.gallery-nav-prev').length || $(e.target).closest('.gallery-nav-next').length) {
            return;
        }

        e.preventDefault();
        e.stopPropagation();

        var $this = $(this);
        var $img = $this.find('img').first();
        
        if ($this.hasClass('zoomed')) {
            // Zoom out
            $this.removeClass('zoomed');
            $img.css({
                'transform': 'scale(1)',
                'transform-origin': 'center center'
            });
            $this.css('cursor', 'zoom-in');
        } else {
            // Remove zoom from all other slides first
            $('.product-gallery-slider .swiper-slide.zoomed').each(function() {
                $(this).removeClass('zoomed');
                $(this).find('img').first().css({
                    'transform': 'scale(1)',
                    'transform-origin': 'center center'
                });
                $(this).css('cursor', 'zoom-in');
            });

            // Zoom in on this slide
            $this.addClass('zoomed');
            $this.css('cursor', 'zoom-out');

            // Calculate click position relative to the image/slide
            var rect = this.getBoundingClientRect();
            var x = ((e.clientX - rect.left) / rect.width) * 100;
            var y = ((e.clientY - rect.top) / rect.height) * 100;
            
            $img.css({
                'transform': 'scale(2.5)',
                'transform-origin': x + '% ' + y + '%'
            });
        }
    });

    // Pan (Move) functionality
    $(document).on('mousemove', '.product-gallery-slider .swiper-slide.zoomed', function(e) {
        var $img = $(this).find('img').first();
        var rect = this.getBoundingClientRect();
        var x = Math.max(0, Math.min(100, ((e.clientX - rect.left) / rect.width) * 100));
        var y = Math.max(0, Math.min(100, ((e.clientY - rect.top) / rect.height) * 100));
        $img.css('transform-origin', x + '% ' + y + '%');
    });

    // Zoom out on mouseleave
    $(document).on('mouseleave', '.product-gallery-slider .swiper-slide.zoomed', function() {
        var $this = $(this);
        var $img = $this.find('img').first();
        
        $this.removeClass('zoomed');
        $img.css({
            'transform': 'scale(1)',
            'transform-origin': 'center center'
        });
        $this.css('cursor', 'zoom-in');
    });
    
    // Set initial cursor style
    $('.product-gallery-slider .swiper-slide').css('cursor', 'zoom-in');
});
</script>
