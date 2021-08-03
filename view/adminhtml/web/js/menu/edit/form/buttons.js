define([
    'jquery',
    'mage/translate',
    'Naxero_MenuManager/js/helper/modal',
    'Naxero_MenuManager/js/helper/tools',
    'Naxero_MenuManager/js/menu/edit/form/fields/menu-links',
    'domReady!'
], function ($, __, MMModal, MMTools, MenuLinks) {
    'use strict';

    return {
        /**
         * Menu edit form ID
         */
        f: '#mm-menu-edit-form',

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
                // Prevent the default action
                e.preventDefault();

                // Form validation
                var form = $(self.f);
                form.validate();
                if (!form.valid()) {
                    return false;
                }

                // Update the menu links
                MenuLinks.updateLinksField();

                // Prepare parameters
                var params = MMTools.buildFormRequestData($(self.f));
                var url = window.BASE_URL + 'menu/save/?form_key=' + window.FORM_KEY;
                var entityId = parseInt(params.entity_id);
                
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
                        if (parseInt(res.entity_id) > 0) {
                            window.location.href = window.BASE_URL + 'menu/addrow/id/'
                            + res.entity_id;
                        }
                        else {
                            window.location.href = window.BASE_URL + 'menu/index';
                        }
                    },
                    error: function (request, status, error) {
                        $('body').trigger('processStop');
                        console.log(error);
                    }
                });
            });
        },

        /**
         * Delete button callback event
         */ 
        deleteAction: function () {
            // Prepare parameters
            var url = window.BASE_URL + 'menu/delete';
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
                    location.href = window.BASE_URL + 'menu/index';                    
                },
                error: function (request, status, error) {
                    $('body').trigger('processStop');
                    console.log(error);
                }
            });
        }
    };
});