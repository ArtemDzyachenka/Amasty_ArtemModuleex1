<?php

namespace Amasty\SecondModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;


class CheckCartAddObserver implements  ObserverInterface
{

    public function execute(Observer $observer)
    {
        $cart = $observer->getData('cart_to_check');

        if ($cart ==   ) {

        }
    }

}
