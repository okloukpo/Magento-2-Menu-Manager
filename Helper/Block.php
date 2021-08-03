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

namespace Naxero\MenuManager\Helper;

use Naxero\MenuManager\Helper\Config;

/**
 * Class Block helper.
 */
class Block extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var PageFactory
     */
    public $pageFactory;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * Block helper class constructor.
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Naxero\MenuManager\Helper\Config $configHelper
    ) {
        $this->pageFactory = $pageFactory;
        $this->configHelper = $configHelper;
    }

    /**
     * Get the header menu HTML.
     */
    public function getHeaderMenuHtml($items, $menuData)
    {
        return $this->pageFactory->create()->getLayout()
        ->createBlock(\Naxero\MenuManager\Block\Menu\SwitcherMenu::class)
        ->setTemplate(Config::MODULE_NAME . '::menu/header-menu.phtml')
        ->setData('items', $items)
        ->setData('menu_data', $menuData)
        ->toHtml();
    }

    /**
     * Get the top menu HTML.
     */
    public function getTopMenuHtml($items, $menuData)
    {
        return $this->pageFactory->create()->getLayout()
        ->createBlock(\Naxero\MenuManager\Block\Menu\NavMenu::class)
        ->setTemplate(Config::MODULE_NAME . '::menu/top-menu.phtml')
        ->setData('items', $items)
        ->setData('menu_data', $menuData)
        ->toHtml();
    }

    /**
     * Get the footer menu HTML.
     */
    public function getFooterMenuHtml($items, $menuData)
    {
        return $this->pageFactory->create()->getLayout()
        ->createBlock(\Naxero\MenuManager\Block\Menu\SwitcherMenu::class)
        ->setTemplate(Config::MODULE_NAME . '::menu/footer-menu.phtml')
        ->setData('items', $items)
        ->setData('menu_data', $menuData)
        ->toHtml();
    }

    /**
     * Get a menu link config form HTML.
     */
    public function getLinkConfigFormHtml($data)
    {
        return $this->pageFactory->create()->getLayout()
        ->createBlock(\Naxero\MenuManager\Block\Adminhtml\Link\Edit\Fields\Config::class)
        ->setTemplate(Config::MODULE_NAME . '::menu/edit/form/fields/menu-links/link-config.phtml')
        ->setData('link_data', $data)
        ->toHtml();
    }

    /**
     * Render an error message.
     */
    public function getErrorHtml($msg)
    {
        return $this->pageFactory->create()->getLayout()
        ->createBlock(\Magento\Backend\Block\Template::class)
        ->setTemplate(Config::MODULE_NAME . '::message/error.phtml')
        ->setData('msg', $msg)
        ->toHtml();
    }

}
