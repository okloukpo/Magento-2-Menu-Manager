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
 * Class LinkType source
 */
class LinkType implements \Magento\Framework\Option\ArrayInterface
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
                'value' => 'category',
                'label' => __('Category')
            ],
            [
                'value' => 'product',
                'label' => __('Product')
            ],
            [
                'value' => 'page',
                'label' => __('Page')
            ],
            [
                'value' => 'custom',
                'label' => __('Custom')
            ],
            [
                'value' => 'external',
                'label' => __('External')
            ],
            [
                'value' => 'store',
                'label' => __('Store')
            ]
        ];
    }
}
