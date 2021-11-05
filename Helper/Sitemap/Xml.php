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

namespace Naxero\MenuManager\Helper\Sitemap;

use Magento\Sitemap\Model\Source\Product\Image\IncludeImage;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Directory\WriteInterface;

/**
 * Class Sitemap XML helper.
 */
class Xml extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var File
     */
    public $fileDriver;
 
    /**
     * @var Filesystem
     */
    public $filesystem;

    /**
     * @var DateTime
     */
    public $datetime;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var Product
     */
    public $productHelper;

    /**
     * @var Category
     */
    public $categoryHelper;

    /**
     * @var Links
     */
    public $linksHelper;

    /**
     * @var Stores
     */
    public $storesHelper;

    /**
     * @var SitemapEntityFactory
     */
    public $sitemapEntityFactory;

    /**
     * Sitemap XML helper class constructor.
     *
     * @param File $fileDriver
     * @param Filesystem $filesystem
     * @param DateTime $datetime
     * @param Menu $menuHelper
     * @param Config $configHelper
     * @param Product $productHelper
     * @param Category $categoryHelper
     * @param Links $linksHelper
     * @param Stores $storesHelper
     * @param SitemapEntityFactory $sitemapEntityFactory
     */
    public function __construct(
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Product $productHelper,
        \Naxero\MenuManager\Helper\Category $categoryHelper,
        \Naxero\MenuManager\Helper\Links $linksHelper,
        \Naxero\MenuManager\Helper\Stores $storesHelper,
        \Naxero\MenuManager\Model\SitemapEntityFactory $sitemapEntityFactory
    ) {
        $this->fileDriver = $fileDriver;
        $this->filesystem = $filesystem;
        $this->datetime = $datetime;
        $this->menuHelper = $menuHelper;
        $this->configHelper = $configHelper;
        $this->productHelper = $productHelper;
        $this->categoryHelper = $categoryHelper;
        $this->linksHelper = $linksHelper;
        $this->storesHelper = $storesHelper;
        $this->sitemapEntityFactory = $sitemapEntityFactory;
    }

    /**
     * Load an XML sitemap collection
     *
     * @param array $filters
     * @return Collection
     */
    public function getSitemaps($filters = [])
    {
        // Get the collection
        $collection = $this->sitemapEntityFactory->create()
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
     * Load an XML sitemap
     *
     * @param int $id
     */
    public function getSitemap($id)
    {
        return $this->sitemapEntityFactory
            ->create()->load($id);
    }

    /**
     * Generate an XML sitemap
     *
     * @param array $data
     */
    public function generateSitemap($data)
    {
        // Get the sitemap entity
        $item = $this->getSitemap($data['id']);

        // Create the file
        $this->createFile($item, $this->createSitemapContent($item));
    }

    /**
     * Generate multiple XML sitemaps
     *
     * @param array $filters
     */
    public function generateSitemaps($filters = [])
    {
        $collection = $this->getSitemaps($filters);
        foreach ($collection as $item) {
            $this->generateSitemap([
                'id' => $item->getId()
            ]);
        }
    }

    /**
     * Create the XML sitemap file
     *
     * @param array $item
     * @param string $content
     */
    public function createFile($item, $content)
    {
        // Base path
        $basePath = $this->filesystem->getDirectoryWrite(
            DirectoryList::ROOT
        );

        // File path
        $filePath = $item['file_path'] . $item['file_name'];
 
        // Write Content
        $this->write($basePath, $filePath, $content);

        // Update the URL
        $sitemap = $this->getSitemap($item['entity_id']);
        $fileUrl = $this->storesHelper->getStoreUrl() . $filePath;
        $sitemap->setData('file_url', $fileUrl);
        $sitemap->save();
    }

    /**
     * Write to the XML sitemap file.
     *
     * @param object $writeDirectory
     * @param string $filePath
     * @param string $content
     * @return bool
     */
    public function write($writeDirectory, $filePath, $content)
    {
        $stream = $writeDirectory->openFile($filePath, 'w+');
        $stream->lock();
        $stream->write($content);
        $stream->unlock();
        $stream->close();
 
        return true;
    }

    /**
     * Save an XML sitemap
     *
     * @param array $data
     * @return int $id
     */
    public function saveSitemap($data)
    {
        // Get the sitemap entity fields
        $sitemapEntityFields = $this->configHelper->getEntityFields(
            $this->configHelper::SITEMAP_ENTITY_TABLE,
            false
        );

        // Create a sitemap entity
        $item = $this->sitemapEntityFactory->create();

        // Set the entity ID
        if ((int) $data['entity_id'] > 0) {
            // Load the entity
            $item->load($data['entity_id']);

            // File location handling
            $this->updateFileLocation($item, $data);
        }

        // Update the data
        foreach ($sitemapEntityFields as $field) {
            if (is_array($data[$field])) {
                $item->setData(
                    $field,
                    implode(',', $data[$field])
                );
            } else {
                $item->setData($field, $data[$field]);
            }
        }

        // Update the date field
        $item->setData('last_update', $this->datetime->gmtDate());
        
        // Save the entity
        $item->save();

        return $item->getId();
    }

    /**
     * Update an XML sitemap file location on the server
     *
     * @param array $item
     * @param array $data
     */
    public function updateFileLocation($item, $data)
    {
        // Current file path
        $curPath = BP . DIRECTORY_SEPARATOR
        . $item['file_path'] . DIRECTORY_SEPARATOR
        . $item['file_name'];

        // New fifle path
        $newPath = BP . DIRECTORY_SEPARATOR
        . $data['file_path'] . DIRECTORY_SEPARATOR
        . $data['file_name'];

        // Handle location
        $isFile = $this->fileDriver->isFile($curPath);
        if ($newPath != $curPath && $isFile) {
            // Get the file content
            $content = $this->fileDriver->fileGetContents($curPath);

            // Create the new file
            $this->createFile($data, $content);

            // Delete the old file
            $this->fileDriver->deleteFile($curPath);
        }
    }
    
    /**
     * Get an XML sitemap links
     *
     * @param array $item
     */
    public function getSitemapLinks($item)
    {
        // Get the menus IDs
        $idArray = explode(',', $item['sitemap_menus']);

        // Load the menus
        $menuIds = $this->menuHelper->getMenus([
            'entity_id' => ['in' => $idArray],
            'active' => ['eq' => 1]
        ])->getAllIds();

        // Get the links
        $links = $this->linksHelper->getLinks([
            'active' => ['eq' => 1],
            'menu_id' => ['in' => $menuIds]
        ]);

        return $links;
    }

    /**
     * Create an XML sitemap links content
     *
     * @param array $item
     * @return string
     */
    public function createSitemapContent($item)
    {
        // Prepare variables
        $output = '';
        $output .= $this->getXmlFileHeader();

        // File content
        $collection =  $this->getSitemapLinks($item);
        foreach ($collection as $row) {
            // Open tag
            $output .= '<url>';

            // Url
            $output .= $this->getSitemapItemUrl($row);

            // Images
            $images = $this->getSitemapItemImages($row, $item);
            foreach ($images as $image) {
                $output .= $this->getXmlFileImage($image);
            }

            // Other tags
            $output .= '<changefreq>' . $item['frequency']. '</changefreq>';
            $output .= '<priority>' . $item['priority']. '</priority>';
            $output .= '<lastmod>' . $item['last_update']. '</lastmod>';
            $output .= '</url>';
        }

        // File end
        $output .= '</urlset>';

        return $output;
    }

    /**
     * Get an XML sitemap item images
     *
     * @param array $item
     * @param array $sitemap
     * @return string
     */
    public function getSitemapItemImages($item, $sitemap)
    {
        // Prepare variables
        $output = [];

        // Get the images
        if ($sitemap['include_image'] != IncludeImage::INCLUDE_NONE) {
            $images = $this->productHelper->getProductImages($item['link_url']);
            if ($item['link_type'] == 'product') {
                if ($sitemap['include_image'] == IncludeImage::INCLUDE_ALL) {
                    $output = $images;
                } elseif ($sitemap['include_image'] == IncludeImage::INCLUDE_BASE) {
                    $output = $images[0];
                }
            } elseif ($item['link_type'] == 'category') {
                $output[] = $this->categoryHelper->getCategoryImage($item['link_url']);
            }
        }

        return $output;
    }

    /**
     * Get an XML sitemap file header
     */
    public function getXmlFileHeader()
    {
        $output = '';
        $output .= '<?xml version="1.0" encoding="UTF-8" ?>';
        $output .= "\n";
        $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $output .= " ";
        $output .= 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"';
        $output .= " >'";
        $output .= "\n";

        return $output;
    }

    /**
     * Get an XML sitemap file image
     *
     * @param array $image
     * @return string
     */
    public function getXmlFileImage($image)
    {
        $output = '';
        $output .= '<image:image>' . "\n";
        $output .= '<image:loc>' . $image['url'] . '</image:loc>' . "\n";
        $output .= '<image:caption>' . $image['label'] . '</image:caption>' . "\n";
        $output .= '<image:title>' . $image['label'] . '</image:title>' . "\n";
        $output .= '</image:image>' . "\n";

        return $output;
    }

    /**
     * Get an XML sitemap item URL
     *
     * @param array $item
     * @return string
     */
    public function getSitemapItemUrl($item)
    {
        $output = '';
        $output .= '<loc>';
        $output .= $this->menuHelper->getMenuLinkUrl(
            $item['link_type'],
            $item['link_url']
        );
        $output .= '</loc>';

        return $output;
    }

    /**
     * Delete an XML sitemap
     *
     * @param int $id
     */
    public function deleteSitemap($id)
    {
        // Load the entity and data
        $item = $this->getSitemap($id);

        // Get the file path
        $curPath = BP . DIRECTORY_SEPARATOR
        . $item['file_path'] . DIRECTORY_SEPARATOR
        . $item['file_name'];

        // Delete the file
        if ($this->fileDriver->isFile($curPath)) {
            $this->fileDriver->deleteFile($curPath);
        }

        // Delete the entity
        $item->delete();
    }
}
