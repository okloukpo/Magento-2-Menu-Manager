define([
    'jquery',
    'mage/translate',
    'Naxero_MenuManager/js/helper/tools',
    'mage/backend/tabs',
    'domReady!'
], function ($, __, MMTools) {
    'use strict';

    return {
        /**
         * Initialize the component
         */
        init: function (entityId, menuId) {
            // Prepare variables
            var self = this;

            // Form tabs
            $('#mm-config-tabs-links-' + entityId).tabs({
                active: 'config_tab_content_1_' + entityId,
                destination: '#mm-config-tabs-content-' + entityId, 
                shadowTabs: []        
            });

            // Icon upload
            $('#icon_upload_' + entityId).on('change', function(e) { 
                // Prepare variables
                var fd = new FormData();
                var files = $(e.currentTarget)[0].files[0];
                var fileId = 'icon_' + entityId;

                // Append the form data
                fd.append(fileId, files);

                // AJAX request
                $.ajax({
                    url: self.getUploadUrl(fileId, menuId, entityId),  
                    type: 'POST',
                    mimeTypes: 'multipart/form-data',
                    data: fd,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('body').trigger('processStart');
                    },
                    success: function(data) {
                        self.handledResponse(data, entityId);
                        $('body').trigger('processStop');
                    },
                    error: function (request, status, error) {
                        console.log(error);
                    }
                });
            });
        },

        /**
         * Get the upload URL
         */
        getUploadUrl: function (fileId, menuId, entityId) {
            return window.BASE_URL
            + 'ajax/fileupload'
            + '?isAjax=true'
            + '&file_id=' + fileId
            + '&menu_id=' + menuId
            + '&entity_id=' + entityId
            + '&form_key=' + window.FORM_KEY;
        },

        /**
         * Handle the upload response
         */
        handledResponse: function (data, entityId) {
            if (data.success) {
                // Upload success
                MMTools.addIconPreview(entityId, data.file_url);
            }
            else {
                // Upload error
                $('#mm-link-config-messages-' + entityId)
                .append(data.msg);
            }
        }
    };
});