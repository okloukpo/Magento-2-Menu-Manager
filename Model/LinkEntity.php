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

namespace Naxero\MenuManager\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Naxero\MenuManager\Api\Data\LinkEntityInterface;

class LinkEntity extends AbstractModel implements LinkEntityInterface, IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'link_entity';

    /**
     * @var string
     */
    // phpcs:ignore
    public $_cacheTag = 'link_entity';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    // phpcs:ignore
    public $_eventPrefix = 'link_entity';

    /**
     * Initialize resource model
     *
     * @return void
     */
    // phpcs:ignore
    public function _construct()
    {
        $this->_init(
            \Naxero\MenuManager\Model\ResourceModel\LinkEntity::class
        );
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Get menu id
     *
     * @return int|null
     */
    public function getMenuId()
    {
        return $this->getData(self::MENU_ID);
    }

    /**
     * Get parent id
     *
     * @return int|null
     */
    public function getParentId()
    {
        return $this->getData(self::PARENT_ID);
    }

    /**
     * Get link type
     *
     * @return string
     */
    public function getLinkType()
    {
        return $this->getData(self::LINK_TYPE);
    }

    /**
     * Get link URL
     *
     * @return string
     */
    public function getLinkUrl()
    {
        return $this->getData(self::LINK_URL);
    }

    /**
     * Get link text
     *
     * @return string
     */
    public function getLinkText()
    {
        return $this->getData(self::LINK_TEXT);
    }

    /**
     * Get link data
     *
     * @return string
     */
    public function getLinkData()
    {
        return $this->getData(self::LINK_DATA);
    }

    /**
     * Get link config
     *
     * @return string
     */
    public function getLinkConfig()
    {
        return $this->getData(self::LINK_CONFIG);
    }

    /**
     * Get order
     *
     * @return int|null
     */
    public function getLinkOrder()
    {
        return $this->getData(self::LINK_ORDER);
    }

    /**
     * Get active
     *
     * @return int
     */
    public function getActive()
    {
        return $this->getData(self::ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set menu id
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setMenuId($id)
    {
        return $this->setData(self::MENU_ID, $id);
    }

    /**
     * Set parent id
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setParentId($id)
    {
        return $this->setData(self::PARENT_ID, $id);
    }

    /**
     * Set link type
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkType($type)
    {
        return $this->setData(self::LINK_TYPE, $type);
    }

    /**
     * Set link URL
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkUrl($url)
    {
        return $this->setData(self::LINK_URL, $url);
    }

    /**
     * Set link text
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkText($text)
    {
        return $this->setData(self::LINK_TEXT, $text);
    }

    /**
     * Set link data
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkData($data)
    {
        return $this->setData(self::LINK_DATA, $data);
    }

    /**
     * Set link config
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkConfig($config)
    {
        return $this->setData(self::LINK_CONFIG, $config);
    }

    /**
     * Set order
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkOrder($order)
    {
        return $this->setData(self::LINK_ORDER, $order);
    }

    /**
     * Set active
     *
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setActive($active)
    {
        return $this->setData(self::ACTIVE, $active);
    }
}
