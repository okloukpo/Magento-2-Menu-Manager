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

namespace Naxero\MenuManager\Model\ResourceModel\LinkEntity;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    public $_idFieldName = 'entity_id';

    /**
     * Define the resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Naxero\MenuManager\Model\LinkEntity::class,
            \Naxero\MenuManager\Model\ResourceModel\LinkEntity::class
        );
    }
}
