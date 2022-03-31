<?php

namespace Amasty\SecondModule\Plugin;

class ChangeAction {
    public function AroundGetFormAction(
        \Amasty\ArtemModule\Block\Index $subject,
        $getAction
    ) {
        $newAction = $getAction;
        $newAction = 'checkout/cart/add';
        return $newAction;
    }
}
