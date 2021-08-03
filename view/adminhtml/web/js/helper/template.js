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
    'mage/template',
    'text!Naxero_MenuManager/template/link/row.html',
    'text!Naxero_MenuManager/template/list/option.html',
    'text!Naxero_MenuManager/template/link/icon-preview.html',
    'text!Naxero_MenuManager/template/message/error.html'
], function (MageTemplate, LinkRowHtml, ListOptionHtml, IconPreviewHtml, ErrorMessageHtml) {
    'use strict';

    return {
        /**
         * Get a template.
         */
        getTemplate: function (name, data) {
            var template = this.getTemplateInstance(name);
            return MageTemplate(template)(data);
        },

        /**
         * Get a template instance.
         */
        getTemplateInstance: function (name) {
            switch (name) {
                case 'link_row':
                    return LinkRowHtml;
                    break;

                case 'list_option':
                    return ListOptionHtml;
                    break;

                case 'icon_preview':
                    return IconPreviewHtml;
                    break;
                    
                case 'error_message':
                    return ErrorMessageHtml;
                    break;
            }
        }
    };
});


