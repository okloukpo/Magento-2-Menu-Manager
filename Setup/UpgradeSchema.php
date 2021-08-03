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

namespace Naxero\MenuManager\Setup;

use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for the module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        $tableName1 = 'naxero_menumanager_menus';
        $tableName2 = 'naxero_menumanager_links';
        $tableName3 = 'naxero_menumanager_sitemaps';

        // Table 1
        if (!$installer->getConnection()->isTableExists($tableName1)) {
            $table1 = $installer->getConnection()
                ->newTable($installer->getTable($tableName1))
                ->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Record ID'
                )
                ->addColumn('title', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('override', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('orientation', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('zindex', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('user_groups', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('store_views', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('category_images', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 0])
                ->addColumn('product_images', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 0])
                ->addColumn('active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 0])
                ->addIndex($installer->getIdxName(
                    'entity_id_index', ['entity_id']), ['entity_id']
                );

            $installer->getConnection()->createTable($table1);
        }

        // Table 2
        if (!$installer->getConnection()->isTableExists($tableName2)) {
            $table2 = $installer->getConnection()
                ->newTable($installer->getTable($tableName2))
                ->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Record ID'
                )
                ->addColumn('menu_id', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => 0])
                ->addColumn('parent_id', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => 0])
                ->addColumn('link_type', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('link_url', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('link_text', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('link_data', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('link_config', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('link_order', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => 0])
                ->addColumn('active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 0])
                ->addIndex($installer->getIdxName(
                    'entity_id_index', ['entity_id']), ['entity_id']
                )
                ->addIndex($installer->getIdxName(
                    'menu_id_index', ['menu_id']), ['menu_id']
                )
                ->addIndex($installer->getIdxName(
                    'parent_id_index', ['parent_id']), ['parent_id']
                )
                ->addForeignKey(
                    $installer->getFkName($tableName2, 'menu_id', $tableName1, 'entity_id'),
                    'menu_id',
                    $installer->getTable($tableName1),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                );

            // Create the table
            $installer->getConnection()->createTable($table2);
        }

        // Table 3
        if (!$installer->getConnection()->isTableExists($tableName3)) {
            $table3 = $installer->getConnection()
                ->newTable($installer->getTable($tableName3))
                ->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Record ID'
                )
                ->addColumn('sitemap_menus', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('file_name', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null])
                ->addColumn('file_path', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null])
                ->addColumn('file_url', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null])
                ->addColumn('priority', Table::TYPE_TEXT, 10, ['nullable' => true, 'default' => null])
                ->addColumn('frequency', Table::TYPE_TEXT, 10, ['nullable' => true, 'default' => null])
                ->addColumn('include_image', Table::TYPE_TEXT, 10, ['nullable' => true, 'default' => null])
                ->addColumn('last_update', Table::TYPE_TIMESTAMP, null, []);    

            // Create the table
            $installer->getConnection()->createTable($table3);
        }

        // End the setup
        $installer->endSetup();
    }
}