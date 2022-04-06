<?php

namespace Amasty\SecondModule\Plugin;



class ChangeAction
{
    public function aroundGetFormAction(
        \Amasty\ArtemModule\Block\Index $subject
    ) {
        $subject->getUrl('checkout/cart/add');
        return $subject;
    }
}
