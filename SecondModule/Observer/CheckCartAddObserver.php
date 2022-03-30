<?php

namespace Amasty\SecondModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

use Magento\Catalog\Api\ProductRepositoryInterface;



class CheckCartAddObserver implements  ObserverInterface
{


    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository,
        \Magento\Checkout\Model\Session                                $checkoutSession

    )
    {
        $this->productRepository = $productRepository;
        $this->checkoutSession = $checkoutSession;
    }
    public function execute(Observer $observer)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $promoSku = $objectManager
            ->get('Magento\Framework\App\Config\ScopeConfigInterface')
            ->getValue('second_config/all_sku/promo_sku');

        $forSku= $objectManager
            ->get('Magento\Framework\App\Config\ScopeConfigInterface')
            ->getValue('second_config/all_sku/standart_sku');

        $cart = $observer->getData('cart_to_check');
        $whichSku = $cart->getSku();
        $product = $this->productRepository->get($promoSku);

        $quote = $this->checkoutSession->getQuote();

        if (!$quote->getId()) {
            $quote->save();
        }

        if ($whichSku == $forSku  ) {
            $quote->addProduct($product, 1);
            $quote->save();

    public function execute(Observer $observer)
    {
        $cart = $observer->getData('cart_to_check');

        if ($cart ==   ) {


        }
    }

}
