<?php

namespace Amasty\ArtemModule\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Event\ManagerInterface as Manager;


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




    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    private $eventManager;

    /**
     * @var \Amasty\ArtemModule\Model\BlacklistFactory
     */
    private $blaclistFactory;

    /**
     * @var \Amasty\ArtemModule\Model\ResourceModel\Blacklist
     */
    private $blaclistResource;

    /**
     * @var \Amasty\ArtemModule\Model\ResourceModel\Blacklist\CollectionFactory
     */
    private $blackCollectionFactory;

    /**
     * @var \Amasty\ArtemModule\Model\BlackRepository
     */
    private $blackRepository;

    public function __construct(
        Context                                                        $context,
        ScopeConfigInterface                                           $scopeConfig,
        \Magento\Checkout\Model\Session                                $checkoutSession,
        \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\Message\ManagerInterface                    $messageManager,
        Manager $eventManager,
        \Amasty\ArtemModule\Model\BlacklistFactory $blacklistFactory,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist $blacklistResource,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist\CollectionFactory $blackCollectionFactory,
        \Amasty\ArtemModule\Model\BlackRepository $blackRepository

    )
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->messageManager = $messageManager;
        $this->eventManager = $eventManager;
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->blackCollectionFactory = $blackCollectionFactory;
        $this->blackRepository = $blackRepository;
    }

    public function execute()
    {

        /**@var \Amasty\ArtemModule\Model\ResourceModel\Blacklist\Collection $blackCollection */
        $blackCollection = $this->blackCollectionFactory->create();

        $blackCollection->addFieldToFilter('sku_id', ['gteq' => 1]);

        $rep = [];
        foreach ($blackCollection as $black) {
            $listSku = $this->blackRepository->getById($black->getsku_id());
            $rep[] =  [
                'sku_black'=> $listSku->getsku_blaclist(),
                'qty_black'=> $black->getqty_blacklist()
            ];
        }

        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter('sku', ['like' => '%']);
        $collection->addAttributeToFilter('type_id', ['like' => 'Simple Product']);
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
            $product = $this->productRepository->get($params['sku']);
            $type = $product->getTypeId();
            $sku1 = $product->getData('sku');
            for ($i=0;$i < count($rep);$i++) {
                if ($type == 'simple' && $params['sku'] != $rep[$i]['sku_black']) {
                    $quote->addProduct($product, $params['qty']);
                    $quote->save();
                    $this->eventManager->dispatch(
                        'cart_event',
                        ['cart_to_check' => $product]
                    );
                    echo('успех!');
                    break;
                } elseif ($params['sku'] == $rep[0]['sku_black'] && $params['qty'] <= $rep[$i]['qty_black']){
                    $quote->addProduct($product, $params['qty']);
                    $quote->save();
                    $this->eventManager->dispatch(
                        'cart_event',
                        ['cart_to_check' => $product]
                    );
                    echo('успех вновь!');
                    break;
                } elseif ($params['sku'] == $rep[0]['sku_black'] && $params['qty'] > $rep[$i]['qty_black']) {
                    $finalQty = $params['qty'] - $rep[$i]['qty_black'];
                    $quote->addProduct($product, $finalQty );
                    $quote->save();
                    $this->eventManager->dispatch(
                        'cart_event',
                        ['cart_to_check' => $product]
                    );
                    $this->messageManager->addErrorMessage("к сожалению, прошла/и только $finalQty продукта");
                    break;
                }

                if ($qty < 1) {
                    $this->messageManager->addErrorMessage(__('Надо добавить хотя бы один предмет.'));
                }
                if ($type != 'simple') {
                    $this->messageManager->addErrorMessage('Это не simple предмет.');
                }
                if ($product != $sku) {
                    $this->messageManager->addErrorMessage(('Такого предмета не существует.'));
               }
            }
        }
    }
}





































