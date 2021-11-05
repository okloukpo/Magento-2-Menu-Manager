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
 * Class LinkEntity API model
 */
class LinkEntity implements \Naxero\MenuManager\Api\LinkInterface
{
    /**
     * @var Links
     */
    public $linksHelper;

    /**
     * Link API model class constructor
     *
     * @param Links $linksHelper
     */
    public function __construct(
        \Naxero\MenuManager\Helper\Links $linksHelper
    ) {
        $this->linksHelper = $linksHelper;
    }

    /**
     * Get menu links.
     */
    public function getLinks()
    {
        try {
            $response = $this->linksHelper->getLinks()->getData();
        } catch (\Exception $e) {
            $response = ['error' => $e->getMessage()];
        }
 
        return $response;
    }

    /**
     * Get a menu link.
     *
     * @param int $linkId
     * @return array
     */
    public function getLink($linkId)
    {
        try {
            $response = $this->linksHelper->getLink($linkId)->getData();
        } catch (\Exception $e) {
            $response = ['error' => $e->getMessage()];
        }
 
        return [$response];
    }
}
