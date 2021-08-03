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

namespace Naxero\MenuManager\Api\Data;

interface MenuEntityInterface
{
    /**
     * @var String
     */
    const ENTITY_ID = 'entity_id';

    /**
     * @var String
     */
    const TITLE = 'title';

    /**
     * @var String
     */
    const OVERRIDE = 'override';

    /**
     * @var String
     */
    const ORIENTATION = 'orientation';

    /**
     * @var String
     */
    const ZINDEX = 'zindex';
    
    /**
     * @var String
     */
    const USER_GROUPS = 'user_groups';
   
    /**
     * @var String
     */
    const STORE_VIEWS = 'store_views';

    /**
     * @var String
     */
    const CATEGORY_IMAGES = 'category_images';

    /**
     * @var String
     */
    const PRODUCT_IMAGES = 'product_images';

    /**
     * @var int
     */
    const ACTIVE = 'active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get menu title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get menu override
     *
     * @return string
     */
    public function getOverride();

    /**
     * Get menu orientation
     *
     * @return string
     */
    public function getOrientation();

    /**
     * Get menu z-index
     *
     * @return string
     */
    public function getZindex();

    /**
     * Get menu user groups
     *
     * @return string
     */
    public function getUserGroups();

    /**
     * Get store views
     *
     * @return string
     */
    public function getStoreViews();

    /**
     * Get category images
     *
     * @return int
     */
    public function getCategoryImages();

    /**
     * Get product images
     *
     * @return int
     */
    public function getProductImages();

    /**
     * Get active
     *
     * @return int
     */
    public function getActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setId($id);

    /**
     * Set menu title
     *
     * @param string $title
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setTitle($title);

    /**
     * Set menu override
     *
     * @param string $menu
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setOverride($menu);

    /**
     * Set menu orientation
     *
     * @param string $orientation
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setOrientation($orientation);

    /**
     * Set menu z-index
     *
     * @param string $zindex
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setZindex($zindex);

    /**
     * Set menu user groups
     *
     * @param string $data
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setUserGroups($data);

    /**
     * Set store views
     *
     * @param string $storeViews
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setStoreViews($storeViews);

    /**
     * Set category images
     *
     * @param int $data
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setCategoryImages($data);

    /**
     * Set product images
     *
     * @param int $data
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setProductImages($data);

    /**
     * Set active
     *
     * @param int $active
     * @return \Naxero\MenuManager\Api\Data\MenuEntityInterface
     */
    public function setActive($active);
}
