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
 * NavMenu block class.
 */
class NavMenu extends \Magento\Framework\View\Element\Template
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
     * NavMenu block class constructor.
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
     */
    public function renderMenu($items)
    {
        $html = '';
        $i = 0;
        $j = 0;
        foreach ($items as $item) {
            if ((int) $item['parent_id'] == 0) {
                $html .= $this->renderMenuLink($item, $i, $j);
                $i++;
            }
        }

        return $html;
    }

    /**
     * Render a submenu link.
     */
    public function renderMenuLink($item, $i = 0, $j = 0, $level = 0, $hasChildren = false)
    {
        // Prepare variables
        $children = isset($item['children']) ? $item['children'] : [];
        $hasChildren = !empty($children);
        $classes = [
            'ul' => $this->getUlClasses($item, $level, $hasChildren, $i, $j),
            'li' => $this->getLiClasses($item, $level, $hasChildren, $i, $j),
            'a' => $this->getAClasses($item)
        ];

        // Build the link
        $config = $this->linksHelper->getLinkConfig($item);
        $html = $this->getItemHtml($classes, $item, $config, $hasChildren);

        // Hanlde the layout
        if ($this->linksHelper->needsBlockSublayout($item)) {
            $hasChildren = true;
            $html .= $this->renderBlockSublayout($item);
        } elseif (!empty($children)) {
            $html .= $this->getChildrenHtml($classes, $level, $i, $children);
        }

        // Link end
        $html .= '</li>';

        return $html;
    }

    /**
     * Get a menu item HTML.
     */
    public function getItemHtml($classes, $item, $config, $hasChildren)
    {
        $html = '';
        $html .= '<li class="' . $classes['li'] . '">';
        $html .= '<a class="' . $classes['a']  . '" ';
        
        // Href attribute
        $html .= 'href="';
        $html .= $hasChildren ? 'javascript:void(0);' : $item['path'];
        $html .= '" ';

        // Title attribute
        if (isset($config['title'])) {
            $html .= 'title="' . $config['title'] . '" ';
        }

        // Target attribute
        if (isset($config['target'])) {
            $html .= 'target="' . $config['target'] . '" ';
        }
        $html .= '>';

        // Link icon
        if (isset($config['icon']) && !empty($config['icon'])) {
            $html .= '<span class="mm-link-icon">';
            $html .= '<img src="' . $config['icon'] . '">';
            $html .= '</span>';
        }

        // Link image (categories and products)
        $menuData = $this->getMenuData();
        $imageUrl = $this->menuHelper->getMenuLinkImage($item);
        $needsImage = $this->menuHelper->linkNeedsImage($item, $menuData);
        if ($needsImage && $imageUrl) {
            $html .= '<span class="mm-link-image">';
            $html .= '<img src="' . $imageUrl . '">';
            $html .= '</span>';
        }

        // Link label
        $html .= '<span class="ui-menu-icon ui-icon"></span>';
        $html .= '<span class="mm-link-label">' . $item['label'] . '</span>';
        $html .= '</a>';

        return $html;
    }

    /**
     * Get a menu item children HTML.
     */
    public function getChildrenHtml($classes, $level, $i, $children)
    {
        $hasChildren = true;
        $html = '';
        $html .= '<ul class="' . $classes['ul'] . '">';
        $j = 0;
        foreach ($children as $child) {
            $html .= $this->renderMenuLink($child, $i, $j, $level + 1, $hasChildren);
            $j++;
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Render a parent link block sublayout.
     */
    public function renderBlockSublayout($item)
    {
        // Prepare variables
        $ulClasses = $this->getUlClasses($item);
        $liClasses = $this->getLiClasses($item);
        $aClasses = $this->getAClasses($item);
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

    /**
     * Get the UL element CSS classes.
     */
    public function getUlClasses($item, $level = 0, $hasChildren = false, $i = 0, $j = 0)
    {
        // Base classes
        $classes = '';
        $classes .= ' ui-menu ui-widget ui-widget-content ui-corner-all';
        $classes .= ' level' . $level;
        $classes .= ' submenu';

        // Level classes
        if ((int) $item['parent_id'] > 0) {
            $classes .= ' level' . ($level);
        }
        
        // Parent classes
        if ($hasChildren) {
            $classes .= ' parent';
        }

        return $classes;
    }

    /**
     * Get the LI element CSS classes.
     */
    public function getLiClasses($item, $level = 0, $hasChildren = false, $i = 0, $j = 0)
    {
        // General classes
        $classes = '';
        $classes .= 'level' . $level;
        $classes .= ' ui-menu-item';

        // Level classes
        if ((int) $item['parent_id'] == 0) {
            $classes .= ' level-top';
            $classes .= ' nav-' . ($i + 1);
        } else {
            $classes .= ' nav-' . ($i + 1) . '-' . ($j + 1);
        }

        // Item with children
        if ($hasChildren) {
            $classes .= ' parent';
        }
        
        // Category classes
        if ($item['link_type'] == 'category') {
            $classes .= ' category-item';
        }

        return $classes;
    }

    /**
     * Get the A element CSS classes.
     */
    public function getAClasses($item)
    {
        $classes = '';
        $classes .= ' ui-corner-all';
        if ((int) $item['parent_id'] == 0) {
            $classes .= ' level-top';
        }

        return $classes;
    }
}
