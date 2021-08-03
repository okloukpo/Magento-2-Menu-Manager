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

interface SitemapEntityInterface
{
    /**
     * @var String
     */
    const ENTITY_ID = 'entity_id';

    /**
     * @var String
     */
    const SITEMAP_MENUS = 'sitemap_menus';

    /**
     * @var String
     */
    const FILE_NAME = 'file_name';

    /**
     * @var String
     */
    const FILE_PATH = 'file_path';

    /**
     * @var String
     */
    const FILE_URL = 'file_url';
    
    /**
     * @var String
     */
    const PRIORITY = 'priority';

    /**
     * @var String
     */
    const FREQUENCY = 'frequency';

    /**
     * @var String
     */
    const INCLUDE_IMAGE = 'include_image';

    /**
     * @var String
     */
    const LAST_UPDATE = 'last_update';
   
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get sitemap menus
     *
     * @return string
     */
    public function getSitemapMenus();

    /**
     * Get file name
     *
     * @return string
     */
    public function getFileName();

    /**
     * Get file path
     *
     * @return string
     */
    public function getFilePath();

    /**
     * Get file URL
     *
     * @return string
     */
    public function getFileUrl();

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority();

    /**
     * Get frequency
     *
     * @return string
     */
    public function getFrequency();

    /**
     * Get include image
     *
     * @return string
     */
    public function getIncludeImage();

    /**
     * Get last update
     *
     * @return string
     */
    public function getLastUpdate();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setId($id);

    /**
     * Set sitemap menus
     *
     * @param string $data
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setSitemapMenus($data);

    /**
     * Set filfe name
     *
     * @param string $fileName
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFileName($title);

    /**
     * Set file path
     *
     * @param string $filePath
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFilePath($filePath);

    /**
     * Set file URL
     *
     * @param string $fileUrl
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFileUrl($fileUrl);

    /**
     * Set priority
     *
     * @param string $priority
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setPriority($priority);

    /**
     * Set frequency
     *
     * @param string $frequency
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFrequency($frequency);

    /**
     * Set include image
     *
     * @param string $data
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setIncludeImage($data);

    /**
     * Set last update
     *
     * @param int $lastUpdate
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setLastUpdate($lastUpdate);
}
