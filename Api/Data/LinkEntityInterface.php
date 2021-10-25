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

interface LinkEntityInterface
{
    /**
     * @var String
     */
    const ENTITY_ID = 'entity_id';

    /**
     * @var String
     */
    const MENU_ID = 'menu_id';

    /**
     * @var String
     */
    const PARENT_ID = 'parent_id';

    /**
     * @var String
     */
    const LINK_TYPE = 'link_type';

    /**
     * @var String
     */
    const LINK_URL = 'link_url';

    /**
     * @var String
     */
    const LINK_TEXT = 'link_text';

    /**
     * @var String
     */
    const LINK_DATA = 'link_data';

    /**
     * @var String
     */
    const LINK_CONFIG = 'link_config';

    /**
     * @var String
     */
    const LINK_ORDER = 'link_order';

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
     * Get menu id
     *
     * @return int|null
     */
    public function getMenuId();

    /**
     * Get parent id
     *
     * @return int|null
     */
    public function getParentId();

    /**
     * Get link type
     *
     * @return string
     */
    public function getLinkType();

    /**
     * Get link URL
     *
     * @return string
     */
    public function getLinkUrl();

    /**
     * Get link text
     *
     * @return string
     */
    public function getLinkText();

    /**
     * Get link data
     *
     * @return string
     */
    public function getLinkData();

    /**
     * Get link config
     *
     * @return string
     */
    public function getLinkConfig();

    /**
     * Get order
     *
     * @return int|null
     */
    public function getLinkOrder();

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
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setId($id);

    /**
     * Set menu id
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setMenuId($id);

    /**
     * Set parent id
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setParentId($id);

    /**
     * Set link type
     *
     * @param string $type
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkType($type);

    /**
     * Set link URL
     *
     * @param string $url
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkUrl($url);

    /**
     * Set link text
     *
     * @param string $text
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkText($text);

    /**
     * Set link data
     *
     * @param string $data
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkData($data);

    /**
     * Set link config
     *
     * @param string $config
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkConfig($config);

    /**
     * Set order
     *
     * @param int $order
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setLinkOrder($order);

    /**
     * Set active
     *
     * @param int $active
     * @return \Naxero\MenuManager\Api\Data\LinkEntityInterface
     */
    public function setActive($active);
}
