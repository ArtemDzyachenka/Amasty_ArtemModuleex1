<?php

namespace Amasty\ArtemModule\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;


class Add extends Action
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $collectionFactory;
    private $_config;


    /**
     * Get product types
     *
     * @return array
     */

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    public function __construct(
        Context                                                        $context,
        ScopeConfigInterface                                           $scopeConfig,
        \Magento\Checkout\Model\Session                                $checkoutSession,
        \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\Message\ManagerInterface                    $messageManager
    )
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {



        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter('sku', ['like' => '%']);
        $t = $collection->addAttributeToFilter('type_id', ['like' => 'Simple Product']);
        $collection->addAttributeToSelect('sku');

        $params = $this->getRequest()->getParams();

        print_r($params);

        $quote = $this->checkoutSession->getQuote();

        if (!$quote->getId()) {
            $quote->save();
        }


        $sku = $params['sku'];
        $qty = $params['qty'];

        if ($sku) {
            {
                $product = $this->productRepository->get($params['sku']);
                $type = $product->getTypeId();
                $sku1 = $product->getData('sku');
                if ($type == 'simple') {
                    $quote->addProduct($product, $params['qty']);
                    $quote->save();
                    echo('успех');
                }
                if ($qty < 1) {
                    $this->messageManager->addErrorMessage(__('Надо добавить хотя бы один предмет.'));
                    echo('rpkg');
                }
                if ($type != 'simple') {
                    $this->messageManager->addErrorMessage('Это не simple предмет.');
                }
                if ($product != $sku) {
                    $this->messageManager->addErrorMessage(('Такого предмета не существует.'));
                    die('efg');
                }
            }
        }
    }
}




































//    public function getTypes()
//    {
//        if ($this->_types === null) {
//            $productTypes = $this->_config->getAll();
//            foreach ($productTypes as $productTypeKey => $productTypeConfig) {
//                $productTypes[$productTypeKey]['label'] = __($productTypeConfig['label']);
//            }
//            $this->_types = $productTypes;
//        }
//        return $this->_types;
//    }
