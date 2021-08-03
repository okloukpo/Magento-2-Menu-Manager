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

namespace Naxero\MenuManager\Model\Api;

/**
 * Class Menu API model
 */
class MenuEntity implements \Naxero\MenuManager\Api\MenuInterface
{ 
    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * Menu API model class constructor
     */
    public function __construct(
        \Naxero\MenuManager\Helper\Menu $menuHelper
    ) {
        $this->menuHelper = $menuHelper;
    }

    /**
     * Get menus.
     */
    public function getMenus()
    {
        try {
            $response = $this->menuHelper->getMenus()->getData();
        } catch(\Exception $e) {
            $response = ['error' => $e->getMessage()];
        }
 
        return $response;
    }

    /**
     * Get a menu by ID.
     */
    public function getMenu($menuId)
    {
        try {
            $response = $this->menuHelper->getMenu($menuId)->getData();
        } catch(\Exception $e) {
            $response = ['error' => $e->getMessage()];
        }
 
        return [$response];
    }
}