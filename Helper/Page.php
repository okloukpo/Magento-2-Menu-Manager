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
 * Class Page helper.
 */
class Page extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /**
     * @var PageRepositoryInterface
     */
    public $pageRepositoryInterface;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    public $searchCriteriaBuilderFactory;

    /**
     * @var Page
     */
    public $cmsPageModel;

    /**
     * @var Page
     */
    public $cmsPageHelper;

    /**
     * @var PageFactory
     */
    public $pageFactory;

    /**
     * @var LinkEntityFactory
     */
    public $linkEntityFactory;

    /**
     * Class Page helper constructor.
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        \Magento\Cms\Model\Page $cmsPageModel,
        \Magento\Cms\Helper\Page $cmsPageHelper,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Naxero\MenuManager\Model\LinkEntityFactory $linkEntityFactory
    ) {
        $this->storeManager = $storeManager;
        $this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->cmsPageModel = $cmsPageModel;
        $this->cmsPageHelper = $cmsPageHelper;
        $this->pageFactory = $pageFactory;
        $this->linkEntityFactory = $linkEntityFactory;
    }

    /**
     * Get a CMS pages collection.
     */
    public function getPages($entityId = 0)
    {
        // Search criteria builder
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();

        // Single entity filter
        if ((int) $entityId > 0) {
            $searchCriteriaBuilder->addFilter('page_id', $entityId, 'eq');
        }

        // Search criteria
        $searchCriteria = $searchCriteriaBuilder->create();

        // Pages collection
        $collection = $this->pageRepositoryInterface
        ->getList($searchCriteria)
        ->getItems();

        return $collection;
    }

    /**
     * Get a CMS page.
     */
    public function getPage($id)
    {
        return $this->pageFactory->create()->load($id);
    }

    /**
     * Get a pages URL array.
     */
    public function getPageOptions($entityId = 0)
    {
        $collection = $this->getPages($entityId);
        $data = [];
        foreach ($collection as $item) {
            $data[] = [
                'value' => $item->getId(),
                'text' => $item->getTitle()
            ];
        }

        return $data;
    }

    /**
     * Get a page URL.
     */
    public function getPageUrl($id)
    {
        return $this->cmsPageHelper->getPageUrl($id);
    }

    /**
     * Get the current page viewed.
     */
    public function getViewPageId()
    {
        return (int) $this->cmsPageModel->getId();
    }

    /**
     * Generate page links.
     */
    public function generatePageLinks($data, $parentId = 0, $parentLinkId = 0)
    {
        $collection = $this->getPages();
        $i = 1;
        foreach ($collection as $item) {
            // Prepare the entity
            $entity = $this->linkEntityFactory->create();
            $itemData = $item->getData();
                        
            // Set the fields
            $entity->setMenuId($data['entity_id']);
            $entity->setParentId(0);
            $entity->setLinkType('page');
            $entity->setLinkUrl($itemData['page_id']);
            $entity->setLinkText($itemData['title']);
            $entity->setLinkData(json_encode([
                'text' => $itemData['title'],
                'value' => $itemData['page_id']
            ]));
            $entity->setActive($itemData['is_active']);
            $entity->setLinkOrder($itemData['sort_order']);
            $entity->setLinkConfig('[]');
            $entity->setLinkOrder($i);

            // Save the entity
            $entity->save();

            // Increment
            $i++;
        }
    }
}
