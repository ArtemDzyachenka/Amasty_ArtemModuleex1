<?php

namespace Amasty\SecondModule\Observer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;


class CheckCartAddObserver implements  ObserverInterface
{

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository,
        \Magento\Checkout\Model\Session                                $checkoutSession,
        ScopeConfigInterface $scopeConfig

    )
    {

        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->checkoutSession = $checkoutSession;
    }
    public function execute(Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $promoSku = $this->scopeConfig->getValue('second_config/all_sku/promo_sku');

        $promoProduct = $this->productRepository->get($promoSku);
        $promoType = $promoProduct->getTypeId();

        if ($promoType == 'simple'){
            $forSku= $this->scopeConfig->getValue('second_config/all_sku/standart_sku');
            $difSku = array_map('trim', explode(',', $forSku));
            $cart = $observer->getData('cart_to_check');
            $whichSku = $cart->getSku();
            $quote = $this->checkoutSession->getQuote();
            if (!$quote->getId()) {
                $quote->save();
            }
            if (in_array($whichSku,$difSku)) {
                $quote->addProduct($promoProduct, 1);
                $quote->save();

            }
        }
    }
}
