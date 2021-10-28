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
 * Class Links helper.
 */
class Links extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var File
     */
    public $fileIo;

    /**
     * @var File
     */
    public $fileDriver;

    /**
     * @var PageFactory
     */
    public $pageFactory;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var LinkEntityFactory
     */
    public $linkEntityFactory;

    /**
     * Block helper class constructor.
     *
     * @param File $fileIo
     * @param File $fileDriver
     * @param PageFactory $pageFactory
     * @param Config $configHelper
     * @param LinkEntityFactory $linkEntityFactory
     */
    public function __construct(
        \Magento\Framework\Filesystem\Io\File $fileIo,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Model\LinkEntityFactory $linkEntityFactory
    ) {
        $this->fileIo = $fileIo;
        $this->fileDriver = $fileDriver;
        $this->pageFactory = $pageFactory;
        $this->configHelper = $configHelper;
        $this->linkEntityFactory = $linkEntityFactory;
    }

    /**
     * Get a links collection
     * 
     * @param array $filters
     * @return Collection
     */
    public function getLinks($filters = [])
    {
        // Get the collection
        $collection = $this->linkEntityFactory->create()
        ->getCollection();

        // Additional filters
        if (!empty($filters)) {
            foreach ($filters as $field => $value) {
                $collection->addFieldToFilter($field, $value);
            }
        }

        return $collection;
    }

    /**
     * Get a single link
     * 
     * @param int $id
     * @return LinkEntityFactory
     */
    public function getLink($id)
    {
        return $this->linkEntityFactory->create()->load($id);
    }

    /**
     * Get a link configuration data.
     * 
     * @param array $item
     * @return array
     */
    public function getLinkConfig($item)
    {
        if (isset($item['link_config']) && !empty($item['link_config'])) {
            $config = json_decode($item['link_config']);
            foreach ($config as $row) {
                $config[$row->name] = $row->value;
            }

            return $config;
        }

        return [];
    }

    /**
     * Get a single link by field
     * 
     * @param Collection $fields
     * @return int
     */
    public function getLinkIdByFields($fields)
    {
        // Get the collection
        $collection = $this->linkEntityFactory->create()->getCollection();

        // Add the filters
        foreach ($fields as $field => $value) {
            $collection->addFieldToFilter($field, $value);
        }
        
        // Additional constraints
        $collection->setPageSize(1)->setCurPage(1);

        // Return the entity data
        if ($collection->getSize() > 0) {
            return $collection->getData()[0]['entity_id'];
        }
            
        return 0;
    }

    /**
     * Check if a link needs a block sublayout display.
     * 
     * @param array $item
     * @return bool
     */
    public function needsBlockSublayout($item)
    {
        // Get the config
        $linkConfig = $this->getLinkConfig($item);

        // Retun the check
        return (int) $item['parent_id'] == 0
        && isset($linkConfig['sublayout'])
        && isset($linkConfig['block'])
        && $linkConfig['sublayout'] == 'block';
    }

    /**
     * Get the upload file path.
     * 
     * @param array $params
     * @return string
     */
    public function getUploadDir($params)
    {
        // Build the upload path
        $mediaDir = $this->configHelper->getUploadPath();
        $fileDir = 'menu'
        . DIRECTORY_SEPARATOR . $params['menu_id']
        . DIRECTORY_SEPARATOR . 'link'
        . DIRECTORY_SEPARATOR . $params['entity_id']
        . DIRECTORY_SEPARATOR . 'icon';

        // Full directory path
        $fullPath = $mediaDir . DIRECTORY_SEPARATOR . $fileDir;

        // Delete the directory if already exists
        if ($this->fileDriver->isDirectory($fullPath)) {
            $this->fileDriver->deleteDirectory($fullPath);
        }

        return $fullPath;
    }

    /**
     * Get the upload file URL.
     * 
     * @param array $params
     * @return string
     */
    public function getUploadUrl($params)
    {
        return $this->configHelper->getUploadUrl()
        . '/menu' . '/' . $params['menu_id']
        . '/link' . '/' . $params['entity_id']
        . '/icon';
    }

    /**
     * Update file paths for a link entity.
     * 
     * @param object $item
     * @param string $tmpId
     * @return object
     */
    public function updateFilePath($item, $tmpId)
    {
        if ($tmpId && !empty($tmpId)) {
            // Prepare variables
            $data = $item->getData();
            $uploadDir = $this->getUploadDir($data);
            $uploadUrl = $this->getUploadUrl($data);
            $linkConfig = $this->getLinkConfig($data);

            // Update the file path
            $i = 0;
            foreach ($linkConfig as $row) {
                $fieldName = 'icon_' . $tmpId;
                if (isset($row->name) && $row->name == $fieldName) {
                    // Prepare variables
                    $fileName = basename($row->value);
                    $newPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
                    $tmpDir = str_replace(
                        'link/' . $data['entity_id'],
                        'link/' . $tmpId,
                        $uploadDir
                    );
                    $tmpPath = $tmpDir . DIRECTORY_SEPARATOR . $fileName;

                    // Copy the file to the new location
                    $this->fileIo->mkdir($uploadDir);
                    $this->fileDriver->copy($tmpPath, $newPath);

                    // Remove old file and folder
                    $deleteDir = str_replace('/icon', '', $tmpDir);
                    $this->fileDriver->deleteDirectory($deleteDir);

                    // Update the entity link config values
                    $linkConfig[$i]->name = 'icon_' . $data['entity_id'];
                    $linkConfig[$i]->value = $uploadUrl . '/' . $fileName;
                    $item->setData('link_config', json_encode($linkConfig, true));
                    $item->save();

                    // Exit the loop
                    break;
                }

                // Increment
                $i++;
            }
        }

        return $item;
    }
}
