<?php

namespace Amasty\ArtemModule\Model\ResourceModel\Blacklist;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Amasty\ArtemModule\Model\Blacklist::class,
            \Amasty\ArtemModule\Model\ResourceModel\Blacklist::class
        );
    }
}
