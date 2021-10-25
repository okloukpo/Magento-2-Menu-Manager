define([
    'jquery',
    'mage/backend/tabs',
    'mage/cookies',
    'domReady!'
], function ($) {
    'use strict';

    return {
        /**
         * Initialize the component
         */
        init: function (fieldsets, menuId) {
            // Move the form content into  the tabs
            for (var i = 0; i < fieldsets.length; i++) {
                var index = i + 1;
                $('#tab_fieldset' + index + ' div').append(
                    $('#fieldset' + index)
                );
            }

            // Form tabs
            $('#mm-tabs-links').tabs({
                active: this.getActiveTab(),
                destination: '#mm-tabs-content',
                shadowTabs: []
            });

            // State cookie storage
            $('#mm-tabs-links > ul > li a').on('click touch', function (e) {
                $.cookie('naxero-mm-active-tab', $(e.currentTarget).attr('id'));
            });

            // Form multiselects
            $('#mm-tabs-content .multiselect').each(function () {
                // Adjust the height
                $(this).attr('size', function () {
                    return $(this).find('option').length + 1;
                });

                // Default value for new entities
                if (menuId == 0) {
                    $(this).prop('selectedIndex', 0);
                }
            });
        },

        /**
         * Get the active tab
         */
        getActiveTab: function () {
            return $.cookie('naxero-mm-active-tab') || 'tab_fieldset1';
        }
    };
});