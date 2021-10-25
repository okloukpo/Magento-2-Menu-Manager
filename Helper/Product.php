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

use Magento\Catalog\Model\Product\Attribute\Source\Status;

/**
 * Class Product helper.
 */
class Product extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var Image
     */
    public $imageHelper;

    /**
     * @var Data
     */
    public $priceHelper;

    /**
     * @var ProductFactory
     */
    public $productFactory;

    /**
     * @var CollectionFactory
     */
    public $productCollectionFactory;

    /**
     * @var LinkEntityFactory
     */
    public $linkEntityFactory;

    /**
     * Class Product helper constructor.
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Naxero\MenuManager\Model\LinkEntityFactory $linkEntityFactory
    ) {
        $this->registry = $registry;
        $this->imageHelper = $imageHelper;
        $this->priceHelper = $priceHelper;
        $this->productFactory = $productFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->linkEntityFactory = $linkEntityFactory;
    }

    /**
     * Check if a product is free.
     */
    public function isFree($productId)
    {
        return $this->getProduct($productId)->getFinalPrice() == 0;
    }

    /**
     * Check if a product has options.
     */
    public function hasOptions($productId)
    {
        return $this->getProduct($productId)->getData('has_options');
    }


    /**
     * Check if a product has parent products.
     */
    public function hasParents($product)
    {
        return !empty($product->getTypeInstance()->getParentIdsByChild($product->getId()));
    }

    /**
     * Get a product instance.
     */
    public function getProduct($productId)
    {
        return $this->productFactory->create()->load($productId);
    }

    /**
     * Get a product collection.
     */
    public function getProducts($filters = [])
    {
        // Get the product collection
        $collection = $this->productCollectionFactory->create();
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
     * Get a product options array.
     */
    public function getProductOptions($entityId = 0)
    {
        // Prepare the output
        $data = [];

        // Get the product collection
        $collection = $this->getProducts(
            ['entity_id' => $entityId]
        );

        // Build the options
        foreach ($collection as $item) {
            $data[] = [
                'value' => $item->getId(),
                'text' => $item->getName()
            ];
        }

        return $data;
    }

    /**
     * Get a product URL.
     */
    public function getProductUrl($id)
    {
        return $this->getProduct($id)->getProductUrl();
    }

    /**
     * Get a product image url.
     */
    public function getProductImage($productId, $size = 'product_page_image_small')
    {
        return $this->imageHelper
            ->init($this->getProduct($productId), $size)
            ->getUrl();
    }

    /**
     * Get a product images.
     */
    public function getProductImages($productId)
    {
        // Get the product
        $product = $this->getProduct($productId);
        
        // Add the media gallery images data
        $output = [];
        $galleryImages = $product->getMediaGalleryImages();
        if ($galleryImages && !empty($galleryImages)) {
            foreach ($galleryImages as $galleryImage) {
                $output[] = $galleryImage->getData();
            }
        }

        return $output;
    }

    /**
     * Get the current product viewed.
     */
    public function getViewProductId()
    {
        $product = $this->registry->registry('current_product');

        return $product ? $product->getId() : 0;
    }

    /**
     * Generate product links.
     */
    public function generateProductLinks($data, $parentId = 0, $parentLinkId = 0)
    {
        // Get the products
        $collection = $this->getProducts([
            'status' => Status::STATUS_ENABLED
        ]);

        // Process the collection
        $i = 1;
        foreach ($collection as $item) {
            // Prepare the entity
            $entity = $this->linkEntityFactory->create();
            $itemData = $item->getData();

            // Set the fields
            $entity->setMenuId($data['entity_id']);
            $entity->setParentId(0);
            $entity->setLinkType('product');
            $entity->setLinkUrl($itemData['entity_id']);
            $entity->setLinkText($itemData['name']);
            $entity->setLinkData(json_encode([
                'text' => $itemData['name'],
                'value' => $itemData['entity_id']
            ]));
            $entity->setActive($itemData['status']);
            $entity->setLinkOrder($i);
            $entity->setLinkConfig('[]');

            // Save the entity
            $entity->save();

            // Increment
            $i++;
        }
    }
}
