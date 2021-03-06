<?php

namespace Amasty\ArtemModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blacklist extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            'amasty_blacklist',
            'sku_id'
        );
    }
}
