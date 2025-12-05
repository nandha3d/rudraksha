jQuery(document).ready(function ($) {
    // Initialize Thumbs Swiper
    var galleryThumbs = new Swiper('.product-gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });

    // Initialize Main Swiper
    var galleryTop = new Swiper('.product-gallery-slider', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs
        }
    });

    // Fade in gallery when initialized
    $('.woocommerce-product-gallery').css('opacity', 1);

    // Zoom Functionality
    $('.product-gallery-slider .swiper-slide').each(function () {
        var $slide = $(this);
        var $img = $slide.find('img');
        var largeImageSrc = $img.data('large_image');

        if (largeImageSrc) {
            $slide.on('mouseenter', function () {
                // Simple zoom implementation or use a library if preferred
                // For now, let's use a simple background image zoom effect or just cursor
                $(this).css('cursor', 'zoom-in');
            });

            $slide.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if ($(this).hasClass('zoomed')) {
                    $(this).removeClass('zoomed');
                    $img.css('transform', 'scale(1)');
                } else {
                    $('.swiper-slide').removeClass('zoomed').find('img').css('transform', 'scale(1)');
                    $(this).addClass('zoomed');
                    $img.css('transform', 'scale(2)'); // Simple 2x zoom

                    // Set transform origin based on click position
                    var rect = this.getBoundingClientRect();
                    var x = e.clientX - rect.left;
                    var y = e.clientY - rect.top;
                    $img.css('transform-origin', x + 'px ' + y + 'px');
                }
            });

            // Move zoom
            $slide.on('mousemove', function (e) {
                if ($(this).hasClass('zoomed')) {
                    var width = $(this).width();
                    var height = $(this).height();
                    var mouseX = e.offsetX;
                    var mouseY = e.offsetY;

                    var xPercent = (mouseX / width) * 100;
                    var yPercent = (mouseY / height) * 100;

                    $img.css('transform-origin', xPercent + '% ' + yPercent + '%');
                }
            });

            $slide.on('mouseleave', function () {
                $(this).removeClass('zoomed');
                $img.css('transform', 'scale(1)');
            });
        }
    });
});
