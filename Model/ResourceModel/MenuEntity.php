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

namespace Naxero\MenuManager\Model\ResourceModel;

/**
 * MenuEntity resource model
 */
class MenuEntity extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model.
     *
     * @return void
     */
    // phpcs:ignore
    public function _construct()
    {
        $this->_init('naxero_menumanager_menus', 'entity_id');
    }
}
