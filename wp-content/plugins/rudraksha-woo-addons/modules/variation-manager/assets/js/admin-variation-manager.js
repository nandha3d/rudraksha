jQuery(document).ready(function ($) {
    'use strict';

    const RVM = {
        init: function () {
            this.bindEvents();
        },

        bindEvents: function () {
            $('#rvm-load-variations').on('click', this.loadVariations);
            $('#rvm-add-variation').on('click', this.showAddVariationModal);
            $('#rvm-generate-variations').on('click', this.generateVariations);
            $('#rvm-create-variation-btn').on('click', this.createVariation);
            $('.rvm-modal-close, .rvm-modal-cancel').on('click', this.closeModal);
            $(document).on('click', '.rvm-upload-main-image', this.uploadMainImage);
            $(document).on('click', '.rvm-remove-main-image', this.removeMainImage);
            $(document).on('click', '.rvm-add-gallery-btn', this.addGalleryImages);
            $(document).on('click', '.rvm-gallery-remove', this.removeGalleryImage);
            $(document).on('click', '.rvm-upload-swatch-image', this.uploadSwatchImage);
            $(document).on('change', '.rvm-swatch-type', this.toggleSwatchType);
            $(document).on('change', '.rvm-variation-input', this.autoSave);
            $(document).on('click', '.rvm-btn-duplicate', this.duplicateVariation);
            $(document).on('click', '.rvm-btn-delete', this.deleteVariation);
        },

        loadVariations: function (e) {
            e.preventDefault();

            const productId = $('#rvm-product-select').val();

            if (!productId) {
                alert('Please select a product');
                return;
            }

            $('#rvm-loading').show();
            $('#rvm-variations-container').hide();

            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: {
                    action: 'rvm_load_variations',
                    nonce: rvmData.nonce,
                    product_id: productId
                },
                success: function (response) {
                    if (response.success) {
                        RVM.productAttributes = response.data.product_attributes || {};
                        RVM.renderVariations(response.data.variations, response.data.product_name);
                    } else {
                        alert(response.data.message || 'Error loading variations');
                    }
                },
                error: function () {
                    alert('AJAX error occurred');
                },
                complete: function () {
                    $('#rvm-loading').hide();
                }
            });
        },

        renderVariations: function (variations, productName) {
            const $container = $('#rvm-variations-list');
            const $header = $container.find('.rvm-table-header');

            // Remove all rows except header
            $container.find('.rvm-variation-row').remove();

            $('.rvm-product-info').text('Managing variations for: ' + productName);

            if (variations.length === 0) {
                $container.append('<p>No variations found for this product.</p>');
                $('#rvm-variations-container').show();
                return;
            }

            variations.forEach(function (variation) {
                const row = RVM.createVariationRow(variation);
                $container.append(row);
            });

            $('#rvm-variations-container').show();

            // Initialize color pickers
            $('.rvm-swatch-color-input').wpColorPicker({
                change: function (event, ui) {
                    const $input = $(event.target);
                    const $row = $input.closest('.rvm-variation-row');
                    RVM.saveVariation($row);
                }
            });
        },

        createVariationRow: function (variation) {
            // Create editable attribute dropdowns
            const attributesHtml = Object.entries(variation.attributes)
                .map(([key, value]) => {
                    const attrKey = key.replace('attribute_', '');
                    const attrConfig = RVM.productAttributes[attrKey] || RVM.productAttributes['pa_' + attrKey] || null;
                    const attrName = attrConfig ? attrConfig.name : attrKey.replace(/_/g, ' ');

                    if (attrConfig && attrConfig.options) {
                        // Create dropdown
                        const optionsHtml = attrConfig.options.map(opt =>
                            `<option value="${opt.slug}" ${value === opt.slug ? 'selected' : ''}>${opt.name}</option>`
                        ).join('');
                        return `
                            <div class="rvm-attr-row">
                                <label>${attrName}:</label>
                                <select class="rvm-variation-input rvm-attr-select" name="attribute_${attrKey}">
                                    ${optionsHtml}
                                </select>
                            </div>
                        `;
                    } else {
                        // Fallback to text display
                        return `<span>${attrName}: ${value}</span>`;
                    }
                })
                .join('');

            const galleryHtml = variation.gallery_images
                .map(img => `
                    <div class="rvm-gallery-thumb" data-image-id="${img.id}">
                        <img src="${img.url}" alt="Gallery">
                        <button type="button" class="rvm-gallery-remove">×</button>
                    </div>
                `)
                .join('');

            const swatchColorDisplay = variation.swatch_type === 'color' ? 'block' : 'none';
            const swatchImageDisplay = variation.swatch_type === 'image' ? 'has-image' : '';

            return $(`
                <div class="rvm-variation-row" data-variation-id="${variation.id}">
                    <!-- Image Column -->
                    <div class="rvm-col-image">
                        <img src="${variation.image_url}" alt="Main" class="rvm-main-image-preview rvm-upload-main-image">
                        <button type="button" class="button rvm-image-upload-btn rvm-upload-main-image">Upload</button>
                        <input type="hidden" class="rvm-main-image-id rvm-variation-input" name="image_id" value="${variation.image_id || ''}">
                    </div>

                    <!-- Variation Title Column -->
                    <div class="rvm-col-title">
                        <div class="rvm-variation-title">Variation #${variation.id}</div>
                        <div class="rvm-variation-attrs">${attributesHtml}</div>
                    </div>

                    <!-- Gallery Column -->
                    <div class="rvm-col-gallery">
                        <div class="rvm-gallery-preview">
                            ${galleryHtml}
                        </div>
                        <button type="button" class="button rvm-add-gallery-btn">+ Add</button>
                        <input type="hidden" class="rvm-gallery-ids rvm-variation-input" name="gallery_ids" value="${variation.gallery_ids.join(',')}">
                    </div>

                    <!-- Swatch Column -->
                    <div class="rvm-col-swatch">
                        <select class="rvm-swatch-type rvm-variation-input" name="swatch_type">
                            <option value="color" ${variation.swatch_type === 'color' ? 'selected' : ''}>Color</option>
                            <option value="image" ${variation.swatch_type === 'image' ? 'selected' : ''}>Image</option>
                        </select>
                        <div class="rvm-swatch-color-wrap" style="display: ${swatchColorDisplay};">
                            <input type="text" class="rvm-swatch-color-input rvm-variation-input" name="swatch_color" value="${variation.swatch_color || '#000000'}">
                        </div>
                        <div class="rvm-swatch-image-preview ${swatchImageDisplay}">
                            ${variation.swatch_image_url ? `<img src="${variation.swatch_image_url}" alt="Swatch">` : ''}
                        </div>
                        <button type="button" class="button rvm-upload-swatch-image" style="display: ${variation.swatch_type === 'image' ? 'block' : 'none'};">Upload</button>
                        <input type="hidden" class="rvm-swatch-image-id rvm-variation-input" name="swatch_image_id" value="${variation.swatch_image_id || ''}">
                    </div>

                    <!-- Regular Price -->
                    <div class="rvm-col-input">
                        <input type="text" class="rvm-variation-input" name="regular_price" value="${variation.regular_price || ''}" placeholder="0.00">
                    </div>

                    <!-- Sale Price -->
                    <div class="rvm-col-input">
                        <input type="text" class="rvm-variation-input" name="sale_price" value="${variation.sale_price || ''}" placeholder="0.00">
                    </div>

                    <!-- SKU -->
                    <div class="rvm-col-input">
                        <input type="text" class="rvm-variation-input" name="sku" value="${variation.sku || ''}" placeholder="SKU">
                    </div>

                    <!-- Stock Quantity -->
                    <div class="rvm-col-input">
                        <input type="number" class="rvm-variation-input" name="stock_quantity" value="${variation.stock_quantity || ''}" placeholder="0">
                    </div>

                    <!-- Stock Status -->
                    <div class="rvm-col-input">
                        <select class="rvm-variation-input" name="stock_status">
                            <option value="instock" ${variation.stock_status === 'instock' ? 'selected' : ''}>In Stock</option>
                            <option value="outofstock" ${variation.stock_status === 'outofstock' ? 'selected' : ''}>Out of Stock</option>
                            <option value="onbackorder" ${variation.stock_status === 'onbackorder' ? 'selected' : ''}>On Backorder</option>
                        </select>
                    </div>

                    <!-- Weight -->
                    <div class="rvm-col-input">
                        <input type="text" class="rvm-variation-input" name="weight" value="${variation.weight || ''}" placeholder="kg">
                    </div>

                    <!-- Dimensions -->
                    <div class="rvm-col-dimensions">
                        <div class="rvm-dim-row">
                            <span class="rvm-dim-label">L:</span>
                            <input type="text" class="rvm-variation-input rvm-dim-input" name="length" value="${variation.length || ''}" placeholder="cm">
                        </div>
                        <div class="rvm-dim-row">
                            <span class="rvm-dim-label">W:</span>
                            <input type="text" class="rvm-variation-input rvm-dim-input" name="width" value="${variation.width || ''}" placeholder="cm">
                        </div>
                        <div class="rvm-dim-row">
                            <span class="rvm-dim-label">H:</span>
                            <input type="text" class="rvm-variation-input rvm-dim-input" name="height" value="${variation.height || ''}" placeholder="cm">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="rvm-col-actions">
                        <button type="button" class="button rvm-btn-duplicate" title="Duplicate">
                            <span class="dashicons dashicons-admin-page"></span>
                        </button>
                        <button type="button" class="rvm-btn-delete" title="Delete">
                            <span class="dashicons dashicons-trash"></span>
                        </button>
                    </div>
                </div>
            `);
        },

        uploadMainImage: function (e) {
            e.preventDefault();
            const $btn = $(this);
            const $row = $btn.closest('.rvm-variation-row');

            const frame = wp.media({
                title: 'Select Main Image',
                button: { text: 'Use Image' },
                multiple: false
            });

            frame.on('select', function () {
                const attachment = frame.state().get('selection').first().toJSON();
                $row.find('.rvm-main-image-preview').attr('src', attachment.url);
                $row.find('.rvm-main-image-id').val(attachment.id);
                RVM.saveVariation($row);
            });

            frame.open();
        },

        removeMainImage: function (e) {
            e.preventDefault();
            const $row = $(this).closest('.rvm-variation-row');
            $row.find('.rvm-main-image-preview').attr('src', '');
            $row.find('.rvm-main-image-id').val('');
            RVM.saveVariation($row);
        },

        addGalleryImages: function (e) {
            e.preventDefault();
            const $btn = $(this);
            const $row = $btn.closest('.rvm-variation-row');
            const $gallery = $row.find('.rvm-gallery-preview');

            const frame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to Gallery' },
                multiple: true
            });

            frame.on('select', function () {
                const attachments = frame.state().get('selection').toJSON();

                attachments.forEach(function (attachment) {
                    const $item = $(`
						<div class="rvm-gallery-thumb" data-image-id="${attachment.id}">
							<img src="${attachment.url}" alt="Gallery">
							<button type="button" class="rvm-gallery-remove">×</button>
						</div>
					`);
                    $gallery.append($item);
                });

                RVM.updateGalleryIds($row);
                RVM.saveVariation($row);
            });

            frame.open();
        },

        removeGalleryImage: function (e) {
            e.preventDefault();
            const $item = $(this).closest('.rvm-gallery-thumb');
            const $row = $item.closest('.rvm-variation-row');
            $item.remove();
            RVM.updateGalleryIds($row);
            RVM.saveVariation($row);
        },

        updateGalleryIds: function ($row) {
            const ids = [];
            $row.find('.rvm-gallery-thumb').each(function () {
                ids.push($(this).data('image-id'));
            });
            $row.find('.rvm-gallery-ids').val(ids.join(','));
        },

        uploadSwatchImage: function (e) {
            e.preventDefault();
            const $btn = $(this);
            const $row = $btn.closest('.rvm-variation-row');

            const frame = wp.media({
                title: 'Select Swatch Image',
                button: { text: 'Use Image' },
                multiple: false
            });

            frame.on('select', function () {
                const attachment = frame.state().get('selection').first().toJSON();
                $row.find('.rvm-swatch-image-preview').addClass('has-image').html(
                    `<img src="${attachment.url}" alt="Swatch">`
                );
                $row.find('.rvm-swatch-image-id').val(attachment.id);
                RVM.saveVariation($row);
            });

            frame.open();
        },

        toggleSwatchType: function () {
            const $select = $(this);
            const $row = $select.closest('.rvm-variation-row');
            const type = $select.val();

            if (type === 'color') {
                $row.find('.rvm-swatch-color-wrap').show();
                $row.find('.rvm-upload-swatch-image').hide();
                $row.find('.rvm-swatch-image-preview').removeClass('has-image');
            } else {
                $row.find('.rvm-swatch-color-wrap').hide();
                $row.find('.rvm-upload-swatch-image').show();
            }

            RVM.saveVariation($row);
        },

        autoSave: function () {
            const $row = $(this).closest('.rvm-variation-row');
            clearTimeout($row.data('saveTimeout'));

            const timeout = setTimeout(function () {
                RVM.saveVariation($row);
            }, 1000);

            $row.data('saveTimeout', timeout);
        },

        saveVariation: function ($row) {
            const variationId = $row.data('variation-id');
            const data = {
                action: 'rvm_update_variation',
                nonce: rvmData.nonce,
                variation_id: variationId
            };

            $row.find('.rvm-variation-input').each(function () {
                const $input = $(this);
                const name = $input.attr('name');
                let value = $input.val();

                if (name === 'gallery_ids' && value) {
                    value = value.split(',').filter(id => id);
                }

                data[name] = value;
            });

            $row.addClass('rvm-saving');

            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response.success) {
                        RVM.showSaveIndicator($row, rvmData.i18n.saved);
                    } else {
                        RVM.showSaveIndicator($row, rvmData.i18n.error);
                    }
                },
                error: function () {
                    RVM.showSaveIndicator($row, rvmData.i18n.error);
                },
                complete: function () {
                    $row.removeClass('rvm-saving');
                }
            });
        },

        showSaveIndicator: function ($row, message) {
            const $indicator = $('<div class="rvm-save-indicator show">' + message + '</div>');
            $row.append($indicator);

            setTimeout(function () {
                $indicator.fadeOut(function () {
                    $indicator.remove();
                });
            }, 2000);
        },

        duplicateVariation: function (e) {
            e.preventDefault();

            if (!confirm(rvmData.i18n.confirm_duplicate)) {
                return;
            }

            const $btn = $(this);
            const $row = $btn.closest('.rvm-variation-row');
            const variationId = $row.data('variation-id');

            $btn.prop('disabled', true).text('Duplicating...');

            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: {
                    action: 'rvm_duplicate_variation',
                    nonce: rvmData.nonce,
                    variation_id: variationId
                },
                success: function (response) {
                    if (response.success) {
                        const newRow = RVM.createVariationRow(response.data.variation);
                        $row.after(newRow);

                        // Reinitialize color picker for new row
                        newRow.find('.rvm-swatch-color-input').wpColorPicker({
                            change: function (event, ui) {
                                const $input = $(event.target);
                                const $newRow = $input.closest('.rvm-variation-row');
                                RVM.saveVariation($newRow);
                            }
                        });

                        alert('Variation duplicated successfully!');
                    } else {
                        alert(response.data.message || 'Error duplicating variation');
                    }
                },
                error: function () {
                    alert('AJAX error occurred');
                },
                complete: function () {
                    $btn.prop('disabled', false).html('<span class="dashicons dashicons-admin-page"></span>');
                }
            });
        },

        deleteVariation: function (e) {
            e.preventDefault();

            if (!confirm(rvmData.i18n.confirm_delete)) {
                return;
            }

            const $btn = $(this);
            const $row = $btn.closest('.rvm-variation-row');
            const variationId = $row.data('variation-id');

            $btn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: {
                    action: 'rvm_delete_variation',
                    nonce: rvmData.nonce,
                    variation_id: variationId
                },
                success: function (response) {
                    if (response.success) {
                        $row.fadeOut(function () {
                            $row.remove();
                        });
                    } else {
                        alert(response.data.message || 'Error deleting variation');
                        $btn.prop('disabled', false).html('<span class="dashicons dashicons-trash"></span>');
                    }
                },
                error: function () {
                    alert('AJAX error occurred');
                    $btn.prop('disabled', false).html('<span class="dashicons dashicons-trash"></span>');
                }
            });
        },

        showAddVariationModal: function (e) {
            e.preventDefault();

            const productId = $('#rvm-product-select').val();
            if (!productId) {
                alert('Please select a product first');
                return;
            }

            // Load attributes for the product
            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: {
                    action: 'rvm_get_attributes',
                    nonce: rvmData.nonce,
                    product_id: productId
                },
                success: function (response) {
                    if (response.success) {
                        const attributes = response.data.attributes;
                        let html = '';

                        if (attributes.length === 0) {
                            html = '<p style="color: #d63638;">No variation attributes found. Please add attributes to the product first.</p>';
                        } else {
                            attributes.forEach(function (attr) {
                                html += '<div class="rvm-attr-row">';
                                html += '<label>' + attr.label + '</label>';
                                html += '<select class="rvm-attr-select" data-attribute="' + attr.name + '">';
                                html += '<option value="">— Select —</option>';
                                attr.options.forEach(function (opt) {
                                    html += '<option value="' + opt + '">' + opt + '</option>';
                                });
                                html += '</select>';
                                html += '</div>';
                            });
                        }

                        $('#rvm-attribute-selectors').html(html);
                        $('#rvm-add-variation-modal').show();
                    } else {
                        alert(response.data.message || 'Error loading attributes');
                    }
                },
                error: function () {
                    alert('AJAX error occurred');
                }
            });
        },

        createVariation: function (e) {
            e.preventDefault();

            const productId = $('#rvm-product-select').val();
            const attributes = {};
            let hasEmpty = false;

            $('.rvm-attr-select').each(function () {
                const attrName = $(this).data('attribute');
                const attrValue = $(this).val();
                if (!attrValue) {
                    hasEmpty = true;
                }
                attributes['attribute_' + attrName] = attrValue;
            });

            if (hasEmpty) {
                alert('Please select a value for all attributes');
                return;
            }

            const $btn = $('#rvm-create-variation-btn');
            $btn.prop('disabled', true).text('Creating...');

            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: {
                    action: 'rvm_create_variation',
                    nonce: rvmData.nonce,
                    product_id: productId,
                    attributes: attributes
                },
                success: function (response) {
                    if (response.success) {
                        const newRow = RVM.createVariationRow(response.data.variation);
                        $('.rvm-table-header').after(newRow);
                        RVM.closeModal();
                        alert(response.data.message);
                    } else {
                        alert(response.data.message || 'Error creating variation');
                    }
                },
                error: function () {
                    alert('AJAX error occurred');
                },
                complete: function () {
                    $btn.prop('disabled', false).text('Create Variation');
                }
            });
        },

        closeModal: function () {
            $('#rvm-add-variation-modal').hide();
        },

        generateVariations: function (e) {
            e.preventDefault();

            if (!confirm('Generate all possible variations from product attributes? This will create variations for all attribute combinations that don\'t already exist.')) {
                return;
            }

            const productId = $('#rvm-product-select').val();
            if (!productId) {
                alert('Please select a product first');
                return;
            }

            const $btn = $('#rvm-generate-variations');
            $btn.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Generating...');

            $.ajax({
                url: rvmData.ajax_url,
                type: 'POST',
                data: {
                    action: 'rvm_generate_variations',
                    nonce: rvmData.nonce,
                    product_id: productId
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.data.message);
                        // Reload variations
                        $('#rvm-load-variations').trigger('click');
                    } else {
                        alert(response.data.message || 'Error generating variations');
                    }
                },
                error: function () {
                    alert('AJAX error occurred');
                },
                complete: function () {
                    $btn.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Generate All Variations');
                }
            });
        }
    };

    RVM.init();
});
