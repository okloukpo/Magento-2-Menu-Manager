/**
 * Naxero.com
 * Professional ecommerce integrations for Magento.
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Naxero
 * @author    Platforms Development Team <contact@naxero.com>
 * @copyright © Naxero.com all rights reserved
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://www.naxero.com
 */

define([
    'jquery',
    'Naxero_MenuManager/js/helper/template'
], function ($, MMTemplate) {
    'use strict';

    return {
        /**
         * Get a tree node data
         */
        getNodeData: function (node, config) {
            var data = {};
            var fields = config.entity.link;
            for (var i = 0; i < fields.length; i++) {
                data[fields[i]] = node[fields[i]];
            }

            return data;
        },

        /**
         * Build an HTTP request data
         */
        buildFormRequestData: function (form) {
            // Prepare variables
            var output = {};
            var data = form.serializeArray();

            // Process the single value fields
            for (var i = 0; i < data.length; i++) {
                if (!this.isFormArrayField(data[i].name)) {
                    output[data[i].name] = data[i].value;
                } 
            }
            
            // Process the multivalue fields
            form.find('select.multiselect').each(function() {
                var selectedOptions = Array.from(this.selectedOptions);
                var fieldName = this.getAttribute('name').replace('[]', '');
                var options = [];
                for (var i = 0; i < selectedOptions.length; i++) {
                    options.push(selectedOptions[i].value);
                }
                output[fieldName] = options.join(',');
            });

            return output;
        },

        /**
         * Check if a form field value is an array
         */
        isFormArrayField: function (fieldName) {
            return fieldName.endsWith('[]');
        },

        /**
         * Add an icon preview image
         */
        addIconPreview: function (entityId, imageUrl) {
            // Update the image preview
            var previewFieldSelector = '#icon_preview_' + entityId;
            var fileFieldSelector = '#icon_' + entityId;
            $(previewFieldSelector).empty().show().html(
                MMTemplate.getTemplate('icon_preview', {
                    data: { 
                        url: imageUrl,
                        entityId: entityId
                    }
                })
            );

            // Update the hidden image field
            $(fileFieldSelector).val(imageUrl);
        }
    };
});