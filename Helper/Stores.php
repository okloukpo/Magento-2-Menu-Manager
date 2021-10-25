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
 * Class Stores helper.
 */
class Stores extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /**
     *  @var LinkEntityFactory
     */
    public $linkEntityFactory;

    /**
     * Stores helper class constructor.
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Naxero\MenuManager\Model\LinkEntityFactory $linkEntityFactory
    ) {
        $this->storeManager = $storeManager;
        $this->linkEntityFactory = $linkEntityFactory;
    }

    /**
     * Get all stores.
     */
    public function getStores()
    {
        return $this->storeManager->getStores();
    }

    /**
     * Get the current store.
     */
    public function getStore($id = null)
    {
        return $this->storeManager->getStore($id);
    }

    /**
     * Get a store URL.
     */
    public function getStoreUrl($id = null)
    {
        return $this->getStore($id)->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_LINK
        );
    }

    /**
     * Get a store media URL.
     */
    public function getStoreMediaUrl($id = null)
    {
        return $this->getStore($id)->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        );
    }

    /**
     * Get the current store id.
     */
    public function getStoreId()
    {
        return $this->getStore()->getId();
    }

    /**
     * Get the stores options.
     */
    public function getStoreOptions()
    {
        $data = [];
        foreach ($this->getStores() as $store) {
            $data[] = [
                'value' => $store->getId(),
                'text' => $store->getName()
            ];
        }

        return $data;
    }

    /**
     * Generate page links.
     */
    public function generateStoreLinks($data, $parentId = 0, $parentLinkId = 0)
    {
        $collection = $this->getStores();
        foreach ($collection as $item) {
            // Prepare the entity
            $entity = $this->linkEntityFactory->create();
            $itemData = $item->getData();

            // Set the fields
            $entity->setMenuId($data['entity_id']);
            $entity->setParentId(0);
            $entity->setLinkType('store');
            $entity->setLinkUrl($itemData['store_id']);
            $entity->setLinkText($itemData['name']);
            $entity->setLinkData(json_encode([
                'text' => $itemData['name'],
                'value' => $itemData['store_id']
            ]));
            $entity->setLinkConfig('[]');
            $entity->setActive($itemData['is_active']);
            $entity->setLinkOrder($itemData['sort_order']);

            // Save the entity
            $entity->save();
        }
    }
}
