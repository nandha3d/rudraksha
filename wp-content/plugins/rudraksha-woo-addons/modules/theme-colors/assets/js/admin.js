jQuery(document).ready(function ($) {
    // Initialize color pickers
    $('.rudraksha-color-picker').wpColorPicker({
        change: function (event, ui) {
            var color = ui.color.toString();
            var $input = $(event.target);
            var $preview = $input.closest('.rudraksha-color-card').find('.color-preview');
            $preview.css('background-color', color);
        }
    });

    // Reset to default colors
    $('.rudraksha-reset-colors').on('click', function (e) {
        e.preventDefault();

        if (confirm('Reset colors to default?')) {
            $('input[name="rudraksha_theme_colors[primary_color]"]')
                .val('#6d2911')
                .wpColorPicker('color', '#6d2911');

            $('input[name="rudraksha_theme_colors[secondary_color]"]')
                .val('#f5e6d3')
                .wpColorPicker('color', '#f5e6d3');

            $('.primary-preview').css('background-color', '#6d2911');
            $('.secondary-preview').css('background-color', '#f5e6d3');
        }
    });
});
