define([
    'jquery',
    'mage/translate',
    'Naxero_MenuManager/js/helper/modal',
    'domReady!'
], function ($, __, MMModal) {
    'use strict';

    return {
        /**
         * Menu edit form ID
         */
        f: '#mm-sitemap-edit-form',

        /**
         * Set the menu edit form buttons actions
         */ 
        setEvents: function() {
            // Prepare variables
            var self = this;
            
            // Delete button event
            $('#mm-delete-button').on('click touch', function () {
                MMModal.confirmation('#mm-delete-confirmation', self.deleteAction);
                MMModal.showModal();
            });

            // Save button event 
            $('#save').on('click touch', function (e) {
                // Form validation
                var form = $(self.f);
                form.validate();
                if (!form.valid()) {
                    return false;
                }

                $(self.f).submit();
            });

            // Generate button event 
            $('#mm-generate-button').on('click touch', function (e) {
                var entityId = $('#entity_id').val();
                if (parseInt(entityId) > 0) {
                    location.href = window.BASE_URL + 'sitemap/generate'
                    + '/?form_key=' + window.FORM_KEY
                    + '&id=' + $('#entity_id').val();
                }
                else {
                    MMModal.info('#mm-generate-info');
                    MMModal.showModal();
                }
            });
        },

        /**
         * Delete button callback event
         */ 
        deleteAction: function () {
            // Prepare parameters
            var url = window.BASE_URL + 'sitemap/delete';
            var params = {
                entity_id: $('#entity_id').val(),
                form_key: window.FORM_KEY
            };

            // AJAX request
            $.ajax({
                url: url,  
                type: 'POST',
                data: params,
                dataType: 'json',
                beforeSend: function() {
                    $('body').trigger('processStart');
                },
                success: function(res) {
                    location.href = window.BASE_URL + 'sitemap/index';                    
                },
                error: function (request, status, error) {
                    $('body').trigger('processStop');
                    console.log(error);
                }
            });
        }
    };
});