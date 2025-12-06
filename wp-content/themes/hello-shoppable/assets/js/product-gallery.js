jQuery(document).ready(function ($) {
    console.log('Product Gallery JS Loaded');

    // Check if gallery exists
    if ($('.product-gallery-slider').length === 0) {
        console.log('No gallery slider found');
        return;
    }
    console.log('Gallery found, initializing...');

    // Initialize Thumbs Swiper
    var galleryThumbs = new Swiper('.product-gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });

    // Initialize Main Swiper - NO built-in navigation (using custom buttons)
    var galleryTop = new Swiper('.product-gallery-slider', {
        spaceBetween: 0,
        thumbs: {
            swiper: galleryThumbs
        }
    });

    // Custom navigation buttons
    $('.gallery-nav-prev').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        galleryTop.slidePrev();
    });

    $('.gallery-nav-next').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        galleryTop.slideNext();
    });

    // Fade in gallery when initialized
    $('.woocommerce-product-gallery').css('opacity', 1);

    // Hide any default swiper buttons that might have been created
    $('.swiper-button-next, .swiper-button-prev').hide();

    // Zoom Functionality - Works on ALL images
    var $slides = $('.product-gallery-slider .swiper-slide');
    console.log('Found ' + $slides.length + ' slides for zoom');

    $slides.each(function () {
        var $slide = $(this);

        // Set initial cursor
        $slide.css('cursor', 'zoom-in');
        console.log('Setting up zoom on slide');

        // Click to toggle zoom
        $slide.on('click', function (e) {
            // Don't zoom if clicking on nav buttons
            if ($(e.target).closest('.gallery-nav-btn').length) return;

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
                // Remove zoom from other slides first
                $('.swiper-slide.zoomed').each(function () {
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

                // Set initial transform origin based on click position
                var rect = this.getBoundingClientRect();
                var x = ((e.clientX - rect.left) / rect.width) * 100;
                var y = ((e.clientY - rect.top) / rect.height) * 100;

                $img.css({
                    'transform': 'scale(2.5)',
                    'transform-origin': x + '% ' + y + '%'
                });
            }
        });

        // Move zoom position on mouse move
        $slide.on('mousemove', function (e) {
            if ($(this).hasClass('zoomed')) {
                var $img = $(this).find('img').first();
                var rect = this.getBoundingClientRect();
                var x = Math.max(0, Math.min(100, ((e.clientX - rect.left) / rect.width) * 100));
                var y = Math.max(0, Math.min(100, ((e.clientY - rect.top) / rect.height) * 100));
                $img.css('transform-origin', x + '% ' + y + '%');
            }
        });

        // Zoom out on mouse leave
        $slide.on('mouseleave', function () {
            var $this = $(this);
            if ($this.hasClass('zoomed')) {
                var $img = $this.find('img').first();
                $this.removeClass('zoomed');
                $img.css({
                    'transform': 'scale(1)',
                    'transform-origin': 'center center'
                });
                $this.css('cursor', 'zoom-in');
            }
        });
    });
});
