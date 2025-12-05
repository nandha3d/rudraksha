jQuery(document).ready(function ($) {
    // Auto-dismiss WooCommerce notices after 5 seconds
    setTimeout(function () {
        $('.woocommerce-message, .woocommerce-error, .woocommerce-info').fadeOut(400, function () {
            $(this).remove();
        });
    }, 5000);

    // Remove add-to-cart parameter from URL
    if (window.location.href.indexOf('add-to-cart=') > -1) {
        if ($('body').hasClass('single-product')) {
            var cleanUrl = window.location.href.split('?')[0];
            window.history.replaceState({}, document.title, cleanUrl);
        }
    }

    // Store the current unit price for quantity calculations
    var currentUnitPrice = 0;
    var currentRegularPrice = 0;

    // Function to update price display based on quantity
    function updatePriceByQuantity() {
        var $qtyInput = $('form.variations_form input.qty, form.cart input.qty');
        var quantity = parseInt($qtyInput.val()) || 1;

        if (currentUnitPrice > 0) {
            var totalPrice = currentUnitPrice * quantity;
            var totalRegular = currentRegularPrice * quantity;

            // Format prices
            var formattedTotal = formatPrice(totalPrice);
            var formattedRegular = formatPrice(totalRegular);

            // Update price display
            var $priceArea = $('.woocommerce-variation-price .price, .summary .woocommerce-variation-price .price');
            if ($priceArea.length) {
                var newPriceHtml = '';

                if (totalRegular > totalPrice) {
                    // Has sale price
                    newPriceHtml = '<del><span class="woocommerce-Price-amount amount">' + formattedRegular + '</span></del> ';
                    newPriceHtml += '<ins><span class="woocommerce-Price-amount amount">' + formattedTotal + '</span></ins>';

                    // Calculate and add discount badge
                    var discount = Math.round(((totalRegular - totalPrice) / totalRegular) * 100);
                    newPriceHtml += ' <span class="rudraksha-discount-badge">' + discount + '% OFF</span>';
                } else {
                    newPriceHtml = '<span class="woocommerce-Price-amount amount">' + formattedTotal + '</span>';
                }

                // Only add quantity info if quantity > 1
                if (quantity > 1) {
                    newPriceHtml += '<span class="quantity-price-info">(₹' + formatNumber(currentUnitPrice) + ' × ' + quantity + ')</span>';
                }

                $priceArea.html(newPriceHtml);
            }
        }
    }

    // Format price with currency symbol
    function formatPrice(amount) {
        return '<span class="woocommerce-Price-currencySymbol">₹</span>' + formatNumber(amount);
    }

    // Format number with commas (Indian format)
    function formatNumber(num) {
        num = parseFloat(num).toFixed(2);
        var parts = num.split('.');
        var intPart = parts[0];
        var decPart = parts[1];

        // Indian number format
        var lastThree = intPart.slice(-3);
        var otherNumbers = intPart.slice(0, -3);
        if (otherNumbers !== '') {
            lastThree = ',' + lastThree;
        }
        var formatted = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + lastThree;

        return formatted + '.' + decPart;
    }

    // Listen for variation found event to capture unit price
    $('form.variations_form').on('found_variation', function (event, variation) {
        // Store unit prices
        currentUnitPrice = parseFloat(variation.display_price) || 0;
        currentRegularPrice = parseFloat(variation.display_regular_price) || currentUnitPrice;

        // Reset quantity to 1 when variation changes
        var $qtyInput = $(this).find('input.qty');
        if ($qtyInput.length && parseInt($qtyInput.val()) !== 1) {
            $qtyInput.val(1).trigger('change');
        }

        // Update price based on current quantity (which is now 1)
        setTimeout(updatePriceByQuantity, 50);
    });

    // Listen for quantity changes
    $(document).on('change input', 'form.variations_form input.qty, form.cart input.qty', function () {
        updatePriceByQuantity();
    });

    // Handle plus/minus buttons if they exist
    $(document).on('click', '.quantity .plus, .quantity .minus', function () {
        setTimeout(updatePriceByQuantity, 50);
    });

    // Reset prices when variation is reset
    $('form.variations_form').on('reset_data', function () {
        currentUnitPrice = 0;
        currentRegularPrice = 0;
    });

    // Handle swatch selection
    $(document).on('click', '.rudraksha-swatch-label', function (e) {
        e.preventDefault();

        var $this = $(this);
        var $swatchGroup = $this.closest('.rudraksha-swatches');
        var attribute = $swatchGroup.data('attribute');
        var value = $this.data('value');
        var $form = $this.closest('form.variations_form');

        // If clicking a disabled swatch, reset OTHER attributes first
        if ($this.hasClass('disabled')) {
            $form.find('select').each(function () {
                var $select = $(this);
                var selectAttr = $select.attr('name');
                if (selectAttr !== 'attribute_' + attribute) {
                    $select.val('');
                }
            });

            $form.find('.rudraksha-swatches').each(function () {
                var $group = $(this);
                if ($group.data('attribute') !== attribute) {
                    $group.find('.rudraksha-swatch-label').removeClass('selected');
                }
            });
        }

        // Update selected state for this group
        $swatchGroup.find('.rudraksha-swatch-label').removeClass('selected');
        $this.addClass('selected');

        // Update radio
        $this.find('input').prop('checked', true);

        // Update the select dropdown and trigger change
        var $select = $form.find('select[name="attribute_' + attribute + '"]');
        if ($select.length) {
            if ($select.find('option[value="' + value + '"]').length === 0) {
                $select.append('<option value="' + value + '">' + value + '</option>');
            }
            $select.val(value).trigger('change');
        }

        // Trigger WooCommerce variation update
        $form.trigger('woocommerce_variation_select_change');
        $form.trigger('check_variations');
    });

    // Listen for WooCommerce to update available options
    $('form.variations_form').on('woocommerce_update_variation_values', function () {
        var $form = $(this);

        $form.find('.rudraksha-swatches').each(function () {
            var $group = $(this);
            var attribute = $group.data('attribute');
            var $select = $form.find('select[name="attribute_' + attribute + '"]');

            $group.find('.rudraksha-swatch-label').each(function () {
                var $swatch = $(this);
                var value = $swatch.data('value');

                var $option = $select.find('option[value="' + value + '"]');
                if ($option.length && !$option.is(':disabled')) {
                    $swatch.removeClass('disabled');
                } else {
                    $swatch.addClass('disabled');
                }
            });
        });
    });

    // Sync swatch selection with WooCommerce select changes
    $('form.variations_form').on('woocommerce_variation_select_change', function () {
        var $form = $(this);

        $form.find('.rudraksha-swatches').each(function () {
            var $group = $(this);
            var attribute = $group.data('attribute');
            var $select = $form.find('select[name="attribute_' + attribute + '"]');
            var selectedValue = $select.val();

            $group.find('.rudraksha-swatch-label').each(function () {
                var $swatch = $(this);
                if ($swatch.data('value') === selectedValue) {
                    $swatch.addClass('selected');
                } else {
                    $swatch.removeClass('selected');
                }
            });
        });
    });
});
