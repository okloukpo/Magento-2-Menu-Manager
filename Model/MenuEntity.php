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
use Naxero\MenuManager\Api\Data\MenuEntityInterface;

class MenuEntity extends AbstractModel implements MenuEntityInterface, IdentityInterface
{
    /**
     * Page cache tag
     */
    const CACHE_TAG = 'menu_entity';

    /**
     * @var string
     */
    public $_cacheTag = 'menu_entity';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    public $_eventPrefix = 'menu_entity';

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Naxero\MenuManager\Model\ResourceModel\MenuEntity::class
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
     * Get menu title
     *
     * @return string
     */
    public function getTitle() {
        return $this->getData(self::TITLE);
    }

    /**
     * Get menu override
     *
     * @return string
     */
    public function getOverride() {
        return $this->getData(self::OVERRIDE);
    }

    /**
     * Get menu orientation
     *
     * @return string
     */
    public function getOrientation() {
        return $this->getData(self::ORIENTATION);
    }

    /**
     * Get menu z-index
     *
     * @return string
     */
    public function getZindex() {
        return $this->getData(self::ZINDEX);
    }

    /**
     * Get menu user groups
     *
     * @return string
     */
    public function getUserGroups() {
        return $this->getData(self::USER_GROUPS);
    }

    /**
     * Get store views
     *
     * @return string
     */
    public function getStoreViews() {
        return $this->getData(self::STORE_VIEWS);
    }
    
    /**
     * Get category images
     *
     * @return int
     */
    public function getCategoryImages() {
        return $this->getData(self::CATEGORY_IMAGES);
    }
    
    /**
     * Get product images
     *
     * @return int
     */
    public function getProductImages() {
        return $this->getData(self::PRODUCT_IMAGES);
    }

    /**
     * Get active
     *
     * @return int
     */
    public function getActive() {
        return $this->getData(self::ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setId($id) {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set menu title
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setTitle($title) {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set menu override
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setOverride($menu) {
        return $this->setData(self::OVERRIDE, $menu);
    }

    /**
     * Set menu orientation
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setOrientation($orientation) {
        return $this->setData(self::ORIENTATION, $orientation);
    }

    /**
     * Set menu z-index
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setZindex($zindex) {
        return $this->setData(self::ZINDEX, $zindex);
    }

    /**
     * Set user groups
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setUserGroups($data) {
        return $this->setData(self::USER_GROUPS, $data);
    }

    /**
     * Set store views
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setStoreViews($storeViews) {
        return $this->setData(self::STORE_VIEWS, $storeViews);
    }

    /**
     * Set category images
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setCategoryImages($data) {
        return $this->setData(self::CATEGORY_IMAGES, $data);
    }

    /**
     * Set product images
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setProductImages($data) {
        return $this->setData(self::PRODUCT_IMAGES, $data);
    }

    /**
     * Set active
     *
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setActive($active) {
        return $this->setData(self::ACTIVE, $active);
    }
}
