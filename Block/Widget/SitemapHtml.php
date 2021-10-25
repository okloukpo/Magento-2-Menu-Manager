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

namespace Naxero\MenuManager\Block\Widget;

/**
 * SitemapHtml widget class.
 */
class SitemapHtml extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var String
     */
    // phpcs:ignore
    public $_template = 'widget/sitemap-html.phtml';

    /**
     * @var WidgetMenu
     */
    public $widgetMenuBlock;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * Sitemap widget class constructor.
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Naxero\MenuManager\Block\Menu\WidgetMenu $widgetMenuBlock,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->widgetMenuBlock = $widgetMenuBlock;
        $this->menuHelper = $menuHelper;
    }

    /**
     * Get the HTML sitemap menus.
     */
    public function getMenus()
    {
        // Get the menu IDs
        $idArray = explode(',', $this->getData('sitemap_menus'));

        // Load the menus
        $collection = $this->menuHelper->getMenus([
            'entity_id' => ['in' => $idArray],
            'active' => ['eq' => 1]
        ]);

        if ($collection->getSize() > 0) {
            return $collection->getData();
        }
        
        return [];
    }
}
