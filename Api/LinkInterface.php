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
 * Link API interface class
 */
interface LinkInterface
{
    /**
     * Get a menu links
     * @return mixed
     */
    public function getLinks();

    /**
     * Get a menu link by ID
     * @param string $linkId
     * @return mixed
     */
    public function getLink($linkId);
}
