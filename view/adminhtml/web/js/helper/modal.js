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
    'mage/translate',
    'Magento_Ui/js/modal/modal',
    'Naxero_MenuManager/js/helper/tools'
], function ($, __, modal, MMTools) {
    'use strict';

    return {
        /**
         * Modal window instance
         */
        modalWindow: null,

        /**
         * Get the modal window options
         */
        getOptions: function () {
            return {
                'type': 'popup',
                'responsive': true,
                'modalClass': 'mm-modal',
                'innerScroll': true,
                'buttons': []
            };
        },

        /**
         * Create a link generator modal form
         */
        generateLinksForm: function (element, callback) {
            var options = this.getOptions();
            options.buttons = [
               {
                    text: __('Confirm'),
                    class: '',
                    click: function () {
                        callback();
                    }
            },
               {
                    text: __('Cancel'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
            }
            ];

            this.createModal(element, options);
        },

        /**
         * Create a information modal window
         */
        info: function (element) {
            var options = this.getOptions();
            options.buttons = [
                {
                    text: __('OK'),
                    class: ''
            }
            ];
            this.createModal(element, options);
        },

        /**
         * Create a confirmation modal form
         */
        confirmation: function (element, callback) {
            var options = this.getOptions();
            options.buttons = [
                {
                    text: __('Confirm'),
                    class: '',
                    click: function () {
                        callback();
                    }
            },
                {
                    text: __('Cancel'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
            }
            ];
            this.createModal(element, options);
        },

        /**
         * Create a row config modal form
         */
        linkConfigForm: function (element, entityId) {
            var options = this.getOptions();
            options.opened = function () {
                // Prepare variables
                var row = window.parent.document.getElementById('mm-tree-row-' + entityId);
                var linkConfigField = $(row).find('input[data-field="link_config"]');
                var configData = linkConfigField.val();

                // Set the config form values
                if (configData) {
                    var lines = JSON.parse(configData);
                    for (var i in lines) {
                        if (lines[i].name == 'icon_' + entityId && lines[i].value) {
                            MMTools.addIconPreview(entityId, lines[i].value);
                        } else {
                            $('[name="' + lines[i].name + '"]').val(lines[i].value);
                        }
                    }
                }
            },
            options.buttons = [
                {
                    text: __('Confirm'),
                    class: '',
                    click: function () {
                        // Get the row parameters
                        var form = $('#link-config-form-' + entityId);
                        var formData = JSON.stringify(form.serializeArray());
                        var row = window.parent.document.getElementById('mm-tree-row-' + entityId);
                        var linkConfigField = $(row).find('input[data-field="link_config"]');

                        // Update the link config hidden field with data
                        linkConfigField.val(formData).trigger('change');
                        this.closeModal();
                    }
            },
                {
                    text: __('Cancel'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
            }
            ];
            this.createModal(element, options);
        },

        /**
         * Create the modal window
         */
        createModal: function (element, options) {
            this.modalWindow = element;
            modal(options, $(this.modalWindow));
        },

        /**
         * Show the modal window
         */
        showModal: function (content) {
            content = content || null;
            $(this.modalWindow).modal('openModal').trigger('contentUpdated');
            if (content) {
                $(this.modalWindow).html(content);
            }
        }
    };
});