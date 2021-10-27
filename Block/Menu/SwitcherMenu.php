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
 * SwitcherMenu block class.
 */
class SwitcherMenu extends \Magento\Framework\View\Element\Template
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
     * SwitcherMenu block class constructor.
     * 
     * @param Context $context
     * @param Menu $menuHelper
     * @param Links $linksHelper
     * @param array $data
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
    public function getMenuData()
    {
        return $this->getData('menu_data');
    }
    
    /**
     * Render a list menu.
     * 
     * @param array $items
     * @return string
     */
    public function renderMenu($items)
    {
        $html = '';
        foreach ($items as $item) {
            if ((int) $item['parent_id'] == 0) {
                $html .= $this->renderMenuLink($item);
            }
        }

        return $html;
    }

    /**
     * Render a menu link.
     * 
     * @param array $item
     * @return string
     */
    public function renderMenuLink($item)
    {
        // Prepare variables
        $children = $item['children'] ?? [];
        $hasChildren = !empty($children);

        // Build the top level items
        $html  = '<div class="switcher">';
        $html .= '<div class="actions dropdown options switcher-options">';

        // Top level container classes
        $html .= '<div class="';
        if ($hasChildren) {
            $html .= 'action toggle switcher-trigger';
        }
        $html .= '"';

        // Top level container attributes
        if ($hasChildren) {
            $html .= ' data-mage-init=\'{"dropdown":{}}\'';
            $html .= ' data-toggle="dropdown"';
            $html .= ' data-trigger-keypress-button="true"';
        }
        $html .= '>';

        // Top level item
        $html .= '<strong><span>';
        $html .= '<a href="';
        $html .= $hasChildren ? 'javascript:void(0);' : $item['path'];
        $html .= '">';
        $html .= $item['label'];
        $html .= '</a>';
        $html .= '</span></strong>';
        $html .= '</div>';

        // Hanlde the children
        if ($this->linksHelper->needsBlockSublayout($item)) {
            $html .= $this->renderBlockSublayout($item);
        } elseif ($hasChildren) {
            $html .= $this->getChildrenHtml($children, 1, true);
        }
        $html .= '</div></div>';

        return $html;
    }

    /**
     * Get a menu item children HTML.
     * 
     * @param array $items
     * @param int $level
     * @param bool $hasChildren
     * @return string
     */
    public function getChildrenHtml($items, $level, $hasChildren = false)
    {
        $menuData = $this->getMenuData();
        $html = '<ul ' . $this->getUlAttributes($level, $hasChildren) . '>';
        foreach ($items as $item) {
            // Prepare variables
            $children = $item['children'] ?? [];
            $hasChildren = !empty($children);

            // LI start
            $html .= '<li class="';
            $html .= $this->getLiClasses($level, $hasChildren);
            $html .= '">';
            $html .= '<a href="' . $item['path'] . '">';

            // Link image (categories and products)
            $imageUrl = $this->menuHelper->getMenuLinkImage($item);
            $needsImage = $this->menuHelper->linkNeedsImage($item, $menuData);
            if ($needsImage && $imageUrl) {
                $html .= '<span class="mm-link-image">';
                $html .= '<img src="' . $imageUrl . '">';
                $html .= '</span>';
            }

            // Item label
            $html .= '<span class="mm-link-label">';
            $html .= $item['label'];
            $html .= '</span>';

            // Arrow icon
            if ($hasChildren) {
                $html .= '<span class="ui-menu-icon ui-icon"></span>';
            }

            // Children
            $html .= '</a>';
            if ($hasChildren) {
                $html .= $this->getChildrenHtml($children, $level + 1, $hasChildren);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Render a parent link block sublayout.
     * 
     * @param array $item
     * @param int $level
     * @return string
     */
    public function renderBlockSublayout($item, $level = 1)
    {
        // Get the link config
        $linkConfig = $this->linksHelper->getLinkConfig($item);

        // Render the block
        $html = '<ul ' . $this->getUlAttributes($level) . '>';
        $html .= '<li claass="' . $this->getLiClasses($level) . '">';
        $html .= $this->getLayout()
            ->createBlock(\Magento\Cms\Block\Block::class)
            ->setBlockId($linkConfig['block'])
            ->toHtml();
        $html .= '</li>';
        $html .= '</ul>';

        return $html;
    }

    /**
     * Get the UL element attributes
     * 
     * @param int $level
     * @param bool $hasChildren
     * @return string
     */
    public function getUlAttributes($level, $hasChildren)
    {
        // CSS classes
        $attributes = 'class="';
        $attributes .= $this->getUlClasses($level, $hasChildren);
        $attributes .= '"';

        // Other attributes
        $attributes .= ' data-target="dropdown"';

        return $attributes;
    }

    /**
     * Get the UL element CSS classes.
     * 
     * @param int $level
     * @param bool $hasChildren
     * @return string
     */
    public function getUlClasses($level, $hasChildren = false)
    {
        $classes = '';
        // Parent classes
        if ($hasChildren) {
            $classes .= 'dropdown switcher-dropdown';
        }

        // Level classes
        if ($level > 1) {
            $classes .= ' mm-submenu mm-submenu-hidden';
        }

        return $classes;
    }

    /**
     * Get the LI element CSS classes.
     * 
     * @param int $level
     * @param bool $hasChildren
     * @return string
     */
    public function getLiClasses($level, $hasChildren = false)
    {
        $classes = '';
        $classes .= 'switcher-option';

        return $classes;
    }
}
