<?php

namespace Amasty\ArtemModule\Model;

use Magento\Framework\Model\AbstractModel;

class Blacklist extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Amasty\ArtemModule\Model\ResourceModel\Blacklist::class);
    }
}
