<?php

namespace Amasty\ArtemModule\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable('amasty_blacklist'))
            ->addColumn(
                'sku_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Sku ID'
            ) ->addColumn(
                'sku_blaclist',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false,
                    'default' => ''
                ],
                'Sku Blacklist'
            ) ->addColumn(
                'qty_blacklist',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                [
                    'nullable' => false,
                    'unsigned' => true,
                    'default' => '0'
                ],
                'Qty Blacklist'
            )->setComment('Blaclist Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
