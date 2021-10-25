<?php
/**
 * Naxero.com
 * Professional ecommerce integrations for Magento
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Naxero
 * @author    Platforms Development Team <contact@naxero.com>
 * @copyright Naxero.com
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://www.naxero.com
 */

namespace Naxero\MenuManager\Plugin;

use Magento\Framework\View\Element\Html\Links;

/**
 * Class FooterMenu plugin
 */
class FooterMenu
{
    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var Block
     */
    public $blockHelper;

    /**
     * @var User
     */
    public $userHelper;

    /**
     * @var Object
     */
    public $overrideMenu;
    
    /**
     * HeaderMenu class constructor
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Block $blockHelper,
        \Naxero\MenuManager\Helper\User $userHelper
    ) {
        $this->registry = $registry;
        $this->menuHelper = $menuHelper;
        $this->configHelper = $configHelper;
        $this->blockHelper = $blockHelper;
        $this->userHelper = $userHelper;
    }
    
    /**
     * Render the menu nodes
     */
    public function aroundToHtml($subject, callable $proceed)
    {
        if ($this->canDisplay()) {
            // Set the processed flag
            $this->registry->register('mm_footer_menu_processed', true);

            // Get the menu items
            $items = $this->menuHelper->getMenuLinksArray(
                $this->overrideMenu['entity_id']
            );

            // Render the menu HTML
            return $this->blockHelper->getFooterMenuHtml(
                $items,
                $this->overrideMenu
            );
        }

        return $proceed();
    }
    
    /**
     * Check if a custom menu can be displayed
     */
    public function canDisplay()
    {
        // Get the override menu
        $overrideMenu = $this->menuHelper->getMenus([
            'override' => ['eq' => 'footer_menu'],
            'active' => ['eq' => 1]
        ]);

        // Handle the logic
        if ($overrideMenu->getSize() > 0) {
            // Load the menu data
            $this->overrideMenu = $overrideMenu->getData()[0];

            // Return the display check
            return $this->configHelper->moduleEnabled()
            && $this->userIsAllowed()
            && $this->menuHelper->canDisplayForStore($this->overrideMenu)
            && !$this->registry->registry('mm_footer_menu_processed');
        }

        return false;
    }

    /**
     * Check if a user is allowed to view the menu.
     */
    public function userIsAllowed()
    {
        return $this->userHelper->userHasGroup(
            $this->overrideMenu['user_groups']
        );
    }
}
