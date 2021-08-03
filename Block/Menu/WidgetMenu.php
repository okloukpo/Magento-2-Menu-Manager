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

namespace Naxero\MenuManager\Block\Menu;

/**
 * WidgetMenu block class.
 */
class WidgetMenu extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * @var Links
     */
    public $linksHelper;
    
    /**
     * WidgetMenu block class constructor.
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        \Naxero\MenuManager\Helper\Links $linksHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->menuHelper = $menuHelper;
        $this->linksHelper = $linksHelper;
    }

    /**
     * Get a menu data
     */
    public function getMenuData() {
        return $this->getData('menu_data');
    }
    
    /**
     * Render a list menu.
     */
    public function renderMenu($items) {
        $html = '';
        foreach ($items as $item) {
            if ((int) $item['parent_id'] == 0) {
                $html .= $this->renderMenuLink($item);
            }
        }

        return $html;
    }

    /**
     * Render a submenu link.
     */
    public function renderMenuLink($item, $hasChildren = false) {
        // Link config
        $linkConfig = $this->linksHelper->getLinkConfig($item);

        // Build the link
        $html = $this->getItemHtml($item);
        $children = isset($item['children']) ? $item['children'] : [];

        // Hanlde the layout
        if ($this->linksHelper->needsBlockSublayout($item)) {
            $hasChildren = true;
            $html .= $this->renderBlockSublayout($item, $hasChildren);
        } 
        else if (!empty($children)) {
            $html .= $this->getChildrenHtml($item, $children);
        }

        $html .= '</div></div>';

        return $html;
    }

    /**
     * Get a menu item HTML.
     */
    public function getItemHtml($item) {
        $html  = '';
        $html .= '<div class="switcher">';
        $html .= '<div class="actions dropdown options switcher-options">';
        $html .= '<div';
        $html .= ' class="action toggle switcher-trigger"';
        $html .= ' data-mage-init=\'{"dropdown":{}}\'';
        $html .= ' data-toggle="dropdown"';
        $html .= ' data-trigger-keypress-button="true"';
        $html .= '>';
        $html .= '<strong><span>' . $item['label'] . '</span></strong>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Get a menu item children HTML.
     */
    public function getChildrenHtml($item, $children) {
        $hasChildren = true;
        $html = '';
        $html .= '<ul class="dropdown switcher-dropdown" data-target="dropdown">';
        foreach ($children as $child) {
            $html .= '<li class="switcher-option">';
            $html .= '<a href="' . $child['path'] . '">';
            $html .= $child['label'];
            $html .= '</a>';
            $html .= '</li>';
        } 

        $html .= '</ul>';

        return $html;
    }

    /**
     * Render a parent link block sublayout.
     */
    public function renderBlockSublayout($item, $level, $hasChildren = false) {
        // Prepare variables
        $ulClasses = $this->getUlClasses($item, $level);
        $liClasses = $this->getLiClasses($item, $level, $hasChildren);
        $aClasses = $this->getAClasses($item, $level, $hasChildren);
        $linkConfig = $this->linksHelper->getLinkConfig($item);

        // Render the sub layout
        $html = '';
        $html .= '<ul class="' . $ulClasses . '">';
        $html .= '<li class="' . $liClasses . '">';
        $html .= '<a class="' . $aClasses . '" href="javascript:void(0)">&nbsp;</a>';
        $html .= '<span>&nbsp;</span>';
        $html .= $this->getLayout()
            ->createBlock(\Magento\Cms\Block\Block::class)
            ->setBlockId($linkConfig['block']) 
            ->toHtml();
        $html .= '</li>';
        $html .= '</ul>';

        return $html;
    }
}
