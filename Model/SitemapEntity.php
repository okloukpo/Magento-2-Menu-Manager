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
use Naxero\MenuManager\Api\Data\SitemapEntityInterface;

class SitemapEntity extends AbstractModel implements SitemapEntityInterface, IdentityInterface
{
    /**
     * Page cache tag
     */
    const CACHE_TAG = 'sitemap_entity';

    /**
     * @var string
     */
    public $_cacheTag = 'sitemap_entity';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    public $_eventPrefix = 'sitemap_entity';

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Naxero\MenuManager\Model\ResourceModel\SitemapEntity::class
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
     * Get sitemap menus
     *
     * @return string
     */
    public function getSitemapMenus() {
        return $this->getData(self::SITEMAP_MENUS);
    }

    /**
     * Get file name
     *
     * @return string
     */
    public function getFileName() {
        return $this->getData(self::FILE_NAME);
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function getFilePath() {
        return $this->getData(self::FILE_PATH);
    }

    /**
     * Get file URL
     *
     * @return string
     */
    public function getFileUrl() {
        return $this->getData(self::FILE_URL);
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority() {
        return $this->getData(self::PRIORITY);
    }

    /**
     * Get frequency
     *
     * @return string
     */
    public function getFrequency() {
        return $this->getData(self::FREQUENCY);
    }

    /**
     * Get include image
     *
     * @return string
     */
    public function getIncludeImage() {
        return $this->getData(self::INCLUDE_IMAGE);
    }

    /**
     * Get last update
     *
     * @return int
     */
    public function getLastUpdate() {
        return $this->getData(self::LAST_UPDATE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setId($id) {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set sitemap menus
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setSitemapMenus($data) {
        return $this->setData(self::SITEMAP_MENUS, $data);
    }

    /**
     * Set file name
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFileName($fileName) {
        return $this->setData(self::FILE_NAME, $fileName);
    }

    /**
     * Set file path
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFilePath($filePath) {
        return $this->setData(self::FILE_PATH, $filePath);
    }

    /**
     * Set file URL
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFileUrl($fileUrl) {
        return $this->setData(self::FILE_URL, $fileUrl);
    }

    /**
     * Set priority
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setPriority($priority) {
        return $this->setData(self::PRIORITY, $priority);
    }

    /**
     * Set frequency
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setFrequency($frequency) {
        return $this->setData(self::FREQUENCY, $frequency);
    }

    /**
     * Set include image
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setIncludeImage($data) {
        return $this->setData(self::INCLUDE_IMAGE, $data);
    }

    /**
     * Set last update
     *
     * @return \Naxero\MenuManager\Api\Data\SitemapEntityInterface
     */
    public function setLastUpdate($lastUpdate) {
        return $this->setData(self::LAST_UPDATE, $lastUpdate);
    }
}
