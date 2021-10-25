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

namespace Naxero\MenuManager\Model\Config\Backend\Source;

/**
 * Class Sitemap source
 */
class Sitemap implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var SitemapFactory
     */
    public $sitemapFactory;

    /**
     * Sitemap source class constructor.
     */
    public function __construct(
        \Magento\Sitemap\Model\SitemapFactory $sitemapFactory
    ) {
        $this->sitemapFactory = $sitemapFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        // Prepare variables
        $options = [];
        $collection = $this->sitemapFactory->create()
        ->getCollection();

        // Default option
        $options[] = [
            'value' => 0,
            'label' => __('None')
        ];

        // Build the options
        foreach ($collection as $item) {
            $data = $item->getData();
            $options[] = [
                'value' => $data['sitemap_id'],
                'label' => $data['sitemap_filename']
            ];
        }

        return $options;
    }
}
