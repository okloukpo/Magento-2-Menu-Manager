<?php
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

namespace Naxero\MenuManager\Model\Config\Backend\Source;

/**
 * Class Override source.
 */
class Override implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 'none',
                'label' => __('None')
            ],
            [
                'value' => 'header_menu',
                'label' => __('Header menu')
            ],
            [
                'value' => 'top_menu',
                'label' => __('Top menu')
            ],
            [
                'value' => 'footer_menu',
                'label' => __('Footer menu')
            ]
        ];
    }
}
