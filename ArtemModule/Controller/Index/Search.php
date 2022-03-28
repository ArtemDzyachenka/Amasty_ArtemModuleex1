<?php

namespace Amasty\ArtemModule\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;



class Search extends Action
{
    /**
     * Result constructor.
     * @param Context $context
     */

    public function __construct(Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
         JsonFactory $resultJsonFactory)
    {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {

        $getValue = $this->getRequest()->getParam('value');
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter('sku',['like' => '%'.$getValue.'%']);
        $collection->addAttributeToSelect('sku')
                    ->addAttributeToSelect('name');


        $resultJson = $this->resultJsonFactory->create();

        $result = [];
        foreach ($collection as $product) {
            $result[] = [
                'sku' => $product->getSku(),
                'name' => $product->getName()
            ];
        }
//        var_dump($collection->getSelectSql(true));
//        die();
        return $resultJson->setData($result);
    }
}



