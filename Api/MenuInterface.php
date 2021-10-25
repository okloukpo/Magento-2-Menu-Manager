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

namespace Naxero\MenuManager\Api;

/**
 * Menu API interface class
 */
interface MenuInterface
{
    /**
     * Get menus
     * @return mixed
     */
    public function getMenus();

    /**
     * Get a menu
     * @param string $menuId
     * @return mixed
     */
    public function getMenu($menuId);
}
