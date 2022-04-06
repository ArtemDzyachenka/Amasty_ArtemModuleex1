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

    public function __construct(ProductRepositoryInterface $productRepository)
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
        if ($product = $this->productRepository->get($param['sku']))
        {
            $productId = $product->getId();
            $subject->getRequest()->setParams(['product' => $productId]);
        }
        return null;
    }
}

