<?php

namespace Amasty\ArtemModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;


class Index extends Action
{
    /**
     * @var ScopeConfigInterface
     */
    /**
     * @var \Amasty\ArtemModule\Block\Index $block
     */
    private $scopeConfig;

    public function __construct (
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory

    )
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository =  $productRepository;
        $this->collectionFactory = $collectionFactory;

    }


    public function execute()
    {



//        $collection = $this->collectionFactory->create();
//        $collection->addAttributeToFilter('sku',['like' => '%']);
//        $collection->addAttributeToSelect('sku');
//
//
//        $collection1 = $this->collectionFactory->create();
//        $collection1->addAttributeToFilter('sku', ['like' => '%']);
//        $collection1->addAttributeToFilter('type_id', ['like' => 'Simple Product']);
//        $collection1->addAttributeToSelect('sku');
//        $collection_sku = $this->collectionFactory->create();
//        $collection_sku->addAttributeToFilter('sku',['like' => '%']);
//        $collection_sku->addAttributeToSelect('sku')
//            ->addAttributeToSelect('name');
//        foreach ($collection_sku as $product){
//            echo 'Name  =  '.$product->getName().'<br>';
//            echo 'sku =  '.$product->getSku().'<br>';
//        }

        if ($this->scopeConfig->isSetFlag('first_config/general/enabled'))
        {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            die ('Модуль выключен!!!');
        }
    }
}

