<?php

namespace Amasty\SecondModule\Plugin;

use Magento\Framework\view\Element\Template;

class ChangeAction extends Template
{
    public function aroundGetFormAction(
        \Amasty\ArtemModule\Block\Index $subject
    ) {
        $this->getUrl('checkout/cart/add') ;
        return $this;
    }
}
