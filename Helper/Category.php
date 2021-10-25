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

/**
 * Class Category helper.
 */
class Category extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Category
     */
    public $categoryHelper;

    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /**
     * @var CollectionFactory
     */
    public $categoryCollectionFactory;

    /**
     * @var CategoryRepository
     */
    public $categoryRepository;

    /**
     * @var LinkEntityFactory
     */
    public $linkEntityFactory;

    /**
     * @var Links
     */
    public $linksHepler;

    /**
     * @var Stores
     */
    public $storesHepler;

    /**
     * Class Category helper constructor.
     */
    public function __construct(
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Naxero\MenuManager\Model\LinkEntityFactory $linkEntityFactory,
        \Naxero\MenuManager\Helper\Links $linksHepler,
        \Naxero\MenuManager\Helper\Stores $storesHepler
    ) {
        $this->categoryHelper = $categoryHelper;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryRepository = $categoryRepository;
        $this->linkEntityFactory = $linkEntityFactory;
        $this->linksHepler = $linksHepler;
        $this->storesHepler = $storesHepler;
    }

    /**
     * Get the catalog root categories.
     */
    public function getCategories($filters = [])
    {
        // Prepare the collection
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        // Additional filters
        if (!empty($filters)) {
            foreach ($filters as $field => $value) {
                $collection->addAttributeToFilter($field, $value);
            }
        }

        return $collection;
    }

    /**
     * Get a catalog category.
     */
    public function getCategory($id)
    {
        return $this->categoryRepository->get($id);
    }

    /**
     * Get categories URL array.
     */
    public function getCategoryOptions()
    {
        $collection = $this->getCategories();
        $data = [];
        foreach ($collection as $item) {
            $data[] = [
                'value' => $item->getId(),
                'text' => $item->getName()
            ];
        }

        return $data;
    }

    /**
     * Get a category URL.
     */
    public function getCategoryUrl($id)
    {
        $category = $this->getCategory($id);
        
        return $this->categoryHelper->getCategoryUrl($category);
    }

    /**
     * Get a category image.
     */
    public function getCategoryImage($id)
    {
        // Prepare variables
        // Todo - remove test
        //$url = $this->getCategory($id)->getImageUrl();
        $url = $this->getCategory(38)->getImageUrl();

        // Create URL if the data is a path
        if ($url && !filter_var($url, FILTER_VALIDATE_URL)) {
            $url = $this->storesHepler->getStoreMediaUrl()
            . 'catalog/tmp/category/' . basename($url);
        }

        return $url;
    }

    /**
     * Get the current category viewed.
     */
    public function getViewCategoryId()
    {
        $category = $this->registry->registry('current_category');

        return $category ? $category->getId() : 0;
    }

    /**
     * Generate category links.
     */
    public function generateCategoryLinks($data, $parentId = 0, $parentLinkId = 0)
    {
        // Prepare the level
        $level = isset($data['start_level']) && (int) $data['start_level'] > 0
        ? $data['start_level'] : 1;

        // Get the categories collection
        $parentIdCheck = $parentId > 0 ? ['eq' => $parentId] : ['gt' => 0];
        $collection = $this->getCategories([
            'level' => $level,
            'parent_id' => $parentIdCheck
        ]);

        // Process the collection
        foreach ($collection as $row) {
            // Prepare the entity
            $entity = $this->linkEntityFactory->create();
            $item = $row->getData();

            // Set the fields
            $entity->setMenuId($data['entity_id']);
            $entity->setParentId($parentLinkId);
            $entity->setLinkType('category');
            $entity->setLinkUrl($item['entity_id']);
            $entity->setLinkText($item['name']);
            $entity->setLinkData(json_encode([
                'text' => $item['name'],
                'value' => $item['entity_id']
            ]));
            $entity->setLinkConfig('[]');
            $entity->setActive(1);
            $entity->setLinkOrder(0);

            // Save the entity
            $entity->save();
            
            // Handle Children
            if ((int) $item['children_count'] > 0) {
                $data['start_level'] = $level + 1;
                $this->generateCategoryLinks(
                    $data,
                    $item['entity_id'],
                    $entity->getId()
                );
            }
        }
    }
}
