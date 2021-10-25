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
 * Class MenuList
 */
class MenuList implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * HeaderMenu block class constructor.
     */
    public function __construct(
        \Naxero\MenuManager\Helper\Menu $menuHelper
    ) {
        $this->menuHelper = $menuHelper;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        // Get the blocks
        $collection = $this->menuHelper->getMenus();

        // Build the options
        $options = [];
        foreach ($collection as $item) {
            $options[] = [
                'value' => $item->getId(),
                'label' => $item->getTitle()
            ];
        }

        return $options;
    }
}
