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
 * Class Menu helper.
 */
class Menu extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var UrlInterface
     */
    public $urlInterface;

    /**
     * @var MenuEntityFactory
     */
    public $menuEntityFactory;

    /**
     * @var LinkEntityFactory
     */
    public $linkEntityFactory;

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
     * @var Page
     */
    public $pageHelper;

    /**
     * @var Links
     */
    public $linksHelper;

    /**
     * @var Stores
     */
    public $storesHelper;

    /**
     * @var Tools
     */
    public $toolsHelper;
    
    /**
     * Class Menu helper constructor.
     *
     * @param UrlInterface $urlInterface
     * @param MenuEntityFactory $menuEntityFactory
     * @param LinkEntityFactory $linkEntityFactory
     * @param Config $configHelper
     * @param Product $productHelper
     * @param Category $categoryHelper
     * @param Page $pageHelper
     * @param Links $linksHelper
     * @param Stores $storesHelper
     * @param Tools $toolsHelper
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlInterface,
        \Naxero\MenuManager\Model\MenuEntityFactory $menuEntityFactory,
        \Naxero\MenuManager\Model\LinkEntityFactory $linkEntityFactory,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Product $productHelper,
        \Naxero\MenuManager\Helper\Category $categoryHelper,
        \Naxero\MenuManager\Helper\Page $pageHelper,
        \Naxero\MenuManager\Helper\Links $linksHelper,
        \Naxero\MenuManager\Helper\Stores $storesHelper,
        \Naxero\MenuManager\Helper\Tools $toolsHelper
    ) {
        $this->urlInterface = $urlInterface;
        $this->menuEntityFactory = $menuEntityFactory;
        $this->linkEntityFactory = $linkEntityFactory;
        $this->configHelper = $configHelper;
        $this->productHelper = $productHelper;
        $this->categoryHelper = $categoryHelper;
        $this->pageHelper = $pageHelper;
        $this->linksHelper = $linksHelper;
        $this->storesHelper = $storesHelper;
        $this->toolsHelper = $toolsHelper;
    }

    /**
     * Get a menu collection
     * 
     * @param array $filters
     * @return Collection
     */
    public function getMenus($filters = [])
    {
        // Get the collection
        $collection = $this->menuEntityFactory->create()
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
     * Get a menu
     * 
     * @param int $id
     * @return MenuEntityFactory
     */
    public function getMenu($id)
    {
        return $this->menuEntityFactory->create()->load($id);
    }

    /**
     * Get a menu links
     * 
     * @param int $menuId
     * @return Collection
     */
    public function getMenuLinks($menuId)
    {
        // Get the collection
        $collection = $this->linksHelper->getLinks([
            'menu_id' => ['eq' => $menuId]
        ]);

        // Set the order
        $collection->setOrder('link_order', 'ASC');

        return $collection;
    }

    /**
     * Generate a menu links
     * 
     * @param array $data
     * @return bool
     */
    public function generateMenuLinks($data)
    {
        switch ($data['link_type']) {
            case 'category':
                $this->categoryHelper->generateCategoryLinks($data);
                break;

            case 'product':
                $this->productHelper->generateProductLinks($data);
                break;

            case 'page':
                $this->pageHelper->generatePageLinks($data);
                break;

            case 'store':
                $this->storesHelper->generateStoreLinks($data);
                break;
        }

        return true;
    }

    /**
     * Get a menu links array
     * 
     * @param int $menuId
     * @return array
     */
    public function getMenuLinksArray($menuId)
    {
        // Get the items data
        $items = $this->getMenuLinks($menuId)->getData();

        // Format the data
        $output = [];
        if (!empty($items)) {
            foreach ($items as $data) {
                // Build the row array recursively
                if ((int) $data['parent_id'] == 0) {
                    $output[] = $this->buildMenuLinkArray($data, $items);
                }
            }
        }

        return $output;
    }

    /**
     * Build a menu link array recursively
     * 
     * @param array $data
     * @param array $items
     * @return array
     */
    public function buildMenuLinkArray($data, $items)
    {
        // Additional columns needed for backend display
        $addFields = [
            'id' => $data['entity_id'],
            'name' => $data['link_text'],
            'alias' => Config::MODULE_TAG . '-' . $data['entity_id'],
            'children' => []
        ];

        // Update the data
        $data = $addFields + $data;

        // Decode the link data field
        $data['link_data'] = json_decode($data['link_data']);
        $data['link_config'] = json_decode($data['link_config']);

        // Add a the link content URL key
        $data['url_key'] = $this->getMenuLinkUrl(
            $data['link_type'],
            $data['link_url']
        );

        // Add fields for frontend display
        $data['path'] = $data['url_key'];
        $data['label'] = $data['link_text'];

        // Get child rows
        $childKeys = array_keys(
            array_column($items, 'parent_id'),
            $data['entity_id']
        );

        // Process children if any
        foreach ($childKeys as $key) {
            $data['children'][] = $this->buildMenuLinkArray($items[$key], $items);
        }

        return $data;
    }

    /**
     * Save a menu data
     * 
     * @param array $data
     * @return int
     */
    public function saveMenu($data)
    {
        // Get the menu entity fields
        $menuEntityFields = $this->configHelper->getEntityFields(
            $this->configHelper::MENU_ENTITY_TABLE,
            false
        );

        // Create a menu entity
        $item = $this->menuEntityFactory->create();

        // Load entity if exists
        if ((int) $data['entity_id'] > 0) {
            $item->load($data['entity_id']);
        }

        // Update the data
        foreach ($menuEntityFields as $field) {
            if (isset($data[$field])) {
                $item->setData($field, $data[$field]);
            }
        }

        // Save the entity
        $item->save();

        // Update the menu links data
        $this->updateMenuLinks($data);

        return $item->getId();
    }

    /**
     * Update a menu links
     * 
     * @param array $data
     */
    public function updateMenuLinks($data)
    {
        // Decode the data
        $menuLinks = json_decode($data['menu_links']);

        // Delete all links
        if (isset($data['entity_id']) && (int) $data['entity_id'] > 0) {
            if (empty($menuLinks)) {
                $linkIds = $this->getMenuLinks($data['entity_id'])->getAllIds();
                $this->deleteMenuLinks($data['entity_id'], $linkIds);
            }
        }

        // Update the menu links
        if (!empty($menuLinks)) {
            $this->saveMenuLinks($menuLinks);
        }
    }
    
    /**
     * Check if a menu link needs an image.
     * 
     * @param array $item
     * @param array $menuData
     * @return bool
     */
    public function linkNeedsImage($item, $menuData)
    {
        $linkTypes = ['category', 'product'];
        $condition1 = in_array($item['link_type'], $linkTypes);
        $condition2 = (int) $item['parent_id'] > 0;
        $condition3 = (int) $menuData['category_images'] == 1;
        $condition4 = (int) $menuData['product_images'] == 1;

        return $condition1 && $condition2 && ($condition3 || $condition4);
    }

    /**
     * Get the active menu ovrride positions
     */
    public function getActiveOverrides()
    {
        $output = [];
        $collection = $this->getMenus(['active' => 1]);
        if ($collection->getSize() > 0) {
            foreach ($collection as $item) {
                $output[] = $item->getData('override');
            }
        }

        return $output;
    }

    /**
     * Get a menu link image.
     * 
     * @param array $item
     * @return string
     */
    public function getMenuLinkImage($item)
    {
        if ($item['link_type'] == 'category') {
            return $this->categoryHelper->getCategoryImage(
                $item['entity_id']
            );
        } elseif ($item['link_type'] == 'product') {
            return $this->productHelper->getProductImage(
                $item['entity_id']
            );
        }

        return null;
    }

    /**
     * Save a menu links recursively
     * 
     * @param array $tableData
     */
    public function saveMenuLinks($tableData)
    {
        $i = 0;
        foreach ($tableData as $row) {
            $this->saveMenuLink($row, $i);
            if (isset($row->children) && !empty($row->children)) {
                $this->saveMenuLinks($row->children);
            }

            $i++;
        }
    }

    /**
     * Save a menu link data
     * 
     * @param object $row
     * @param int $i
     */
    public function saveMenuLink($row, $i = 0)
    {
        // Prepare variables
        $tmpId = null;
        $item = $this->linkEntityFactory->create();
        $linkEntityFields = $this->configHelper->getEntityFields(
            $this->configHelper::LINK_ENTITY_TABLE,
            false
        );

        // Load the row if exists
        if ((int) $row->entity_id > 0) {
            $item->load($row->entity_id);
        } else {
            $tmpId = $row->entity_id;
        }

        // Update the data
        foreach ($linkEntityFields as $field) {
            if ($field == 'link_data') {
                $item->setData($field, json_encode($row->$field));
            } else {
                $item->setData($field, $row->$field);
            }
        }

        // Update the order
        $item->setData('link_order', $i + 1);

        // Save the item
        $item->save();

        // Uptate uploaded files path
        $item = $this->linksHelper->updateFilePath($item, $tmpId);
    }

    /**
     * Get a menu link URL
     * 
     * @param string $linkType
     * @param int $id
     * @return int
     */
    public function getMenuLinkUrl($linkType, $id)
    {
        switch ($linkType) {
            case 'category':
                return $this->categoryHelper->getCategoryUrl($id);

            case 'product':
                return $this->productHelper->getProductUrl($id);

            case 'page':
                return $this->pageHelper->getPageUrl($id);

            case 'store':
                return $this->storesHelper->getStoreUrl($id);

            case 'custom':
                return $this->urlInterface->getUrl($id);

            case 'external':
                return $id;
        }

        return $id;
    }

    /**
     * Get the link url options
     * 
     * @param array $data
     * @return array
     */
    public function getLinkUrlOptions($data)
    {
        // Prepare variables
        $id = isset($data['link_url']) ? (int) $data['link_url'] : 0;
        $linkType = isset($data['link_type']) ? $data['link_type'] : 'custom';

        // Check if options can be loaded
        $canLoad = $linkType != 'custom';

        // Load the otions
        if ($canLoad) {
            switch ($linkType) {
                case 'category':
                    return $this->categoryHelper->getCategoryOptions();

                case 'product':
                    return $this->productHelper->getProductOptions();

                case 'page':
                    return $this->pageHelper->getPageOptions();
            
                case 'store':
                    return $this->storesHelper->getStoreOptions();
            }

            return [];
        }

        return [];
    }
  
    /**
     * Check if the menu can be displayed for a store.
     */
    public function canDisplayForStore($menu)
    {
        // Prepare variables
        $storeId = $this->storesHelper->getStoreId();
        $validStores = explode(',', $menu['store_views']);
        
        // Return the check
        return in_array($storeId, $validStores)
        || in_array(0, $validStores)
        || empty($menu['store_views']);
    }

    /**
     * Check if the current link is being viewed
     * 
     * @param object $item
     * @return bool
     */
    public function isCurrentLink($item)
    {
        // Prepare variables
        $id = 0;
        $linkType = $item->getLinkType();
        $linkUrl = $item->getLinkUrl();

        // Handle the logic
        if ($linkType == 'category') {
            $id = $this->categoryHelper->getViewCategoryId();
        } elseif ($linkType == 'product') {
            $id = $this->productHelper->getViewProductId();
        } elseif ($linkType == 'page') {
            $id = $this->pageHelper->getViewPageId();
        }

        // Check the condition
        return (int) $id > 0 && (int) $id == (int) $linkUrl;
    }

    /**
     * Delete a menu
     * 
     * @param int $id
     */
    public function deleteMenu($id)
    {
        $this->menuEntityFactory->create()
        ->load($id)->delete();
    }

    /**
     * Delete a menu links
     * 
     * @param int $menuId
     * @param array $linkIds
     */
    public function deleteMenuLinks($menuId, $linkIds)
    {
        foreach ($linkIds as $id) {
            // Delete the link record
            $this->linksHelper->getLink($id)->delete();

            // Handle children
            $children = $this->linksHelper->getLinks([
                'menu_id' => $menuId,
                'parent_id' => $id
            ]);
            if ($children->getSize() > 0) {
                $this->deleteMenuLinks($menuId, $children->getAllIds());
            }
        }
    }
}
