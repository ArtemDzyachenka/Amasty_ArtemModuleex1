<?php

namespace Amasty\SecondModule\Plugin;

use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class ChangeStandardModule
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
                                \Magento\Checkout\Model\Session $checkoutSession,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
                                CustomerCart $cart,
                                ProductRepositoryInterface $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    /**
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeExecute(
        \Magento\Checkout\Controller\Cart $subject
    )
    {
        $param = $subject->getRequest()->getParams();
        $product = $this->productRepository->get($param['sku']);
        $productId = $product->getId();
        $subject->getRequest()->setParams(['product' => $productId]);
        return null;
    }
}

