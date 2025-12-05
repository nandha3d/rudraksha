jQuery(document).ready(function ($) {
    // Color Picker
    $('.rudraksha-color-picker').wpColorPicker();

    // Toggle Fields based on Type
    $('body').on('change', '#rudraksha_swatch_type', function () {
        var type = $(this).val();
        if (type === 'color') {
            $('#rudraksha-color-swatch-field').show();
            $('#rudraksha-image-swatch-field').hide();
        } else if (type === 'image') {
            $('#rudraksha-color-swatch-field').hide();
            $('#rudraksha-image-swatch-field').show();
        } else {
            $('#rudraksha-color-swatch-field').hide();
            $('#rudraksha-image-swatch-field').hide();
        }
    });

    // Media Uploader Logic
    var file_frame;

    // Generic function to open media uploader
    function openMediaUploader(title, onSelect) {
        if (file_frame) {
            file_frame.open();
        } else {
            file_frame = wp.media.frames.file_frame = wp.media({
                title: title,
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
        }

        // Unbind previous select handlers to avoid conflicts
        file_frame.off('select');

        // Bind new select handler
        file_frame.on('select', onSelect);

        // Ensure frame is opened
        file_frame.open();
    }

    // Term Meta Image Upload
    $('.rudraksha-upload-image').on('click', function (event) {
        event.preventDefault();

        openMediaUploader('Select Swatch Image', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#rudraksha_swatch_image').val(attachment.id);
            $('#rudraksha-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" width="60px" height="60px" />');
            $('.rudraksha-remove-image').show();
        });
    });

    $('.rudraksha-remove-image').on('click', function (event) {
        event.preventDefault();
        $('#rudraksha_swatch_image').val('');
        $('#rudraksha-image-preview').html('');
        $(this).hide();
    });

    // Variation Swatch Image Upload
    $(document).on('click', '.rudraksha-upload-variation-image', function (event) {
        event.preventDefault();
        var $button = $(this);
        var $wrapper = $button.closest('.rudraksha-variation-swatch-field');
        var $input = $wrapper.find('.rudraksha_variation_swatch_image');
        var $preview = $wrapper.find('.rudraksha-variation-image-preview');
        var $remove = $wrapper.find('.rudraksha-remove-variation-image');

        openMediaUploader('Select Swatch Image', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $input.val(attachment.id);
            $preview.html('<img src="' + attachment.sizes.thumbnail.url + '" width="60px" height="60px" />');
            $remove.show();

            // Trigger change for WooCommerce to detect changes
            $input.trigger('change');
        });
    });

    $(document).on('click', '.rudraksha-remove-variation-image', function (event) {
        event.preventDefault();
        var $button = $(this);
        var $wrapper = $button.closest('.rudraksha-variation-swatch-field');
        var $input = $wrapper.find('.rudraksha_variation_swatch_image');
        var $preview = $wrapper.find('.rudraksha-variation-image-preview');

        $input.val('');
        $preview.html('');
        $button.hide();
        $input.trigger('change');
    });
});
