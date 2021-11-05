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
 * Class Blocks source.
 */
class Blocks implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var BlockFactory
     */
    public $blockFactory;

    /**
     * HeaderMenu block class constructor.
     *
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        \Magento\Cms\Model\BlockFactory $blockFactory
    ) {
        $this->blockFactory = $blockFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        // Get the blocks
        $collection = $this->blockFactory->create()
        ->getCollection()
        ->setOrder('title', 'ASC');

        // Build the options
        $options = [];
        foreach ($collection as $item) {
            if ($item->isActive()) {
                $options[] = [
                    'value' => $item->getIdentifier(),
                    'label' => $item->getTitle()
                ];
            }
        }

        return $options;
    }
}
