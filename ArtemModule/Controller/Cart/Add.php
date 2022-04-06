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
        Context                                                             $context,
        ScopeConfigInterface                                                $scopeConfig,
        \Magento\Checkout\Model\Session                                     $checkoutSession,
        \Magento\Catalog\Api\ProductRepositoryInterface                     $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory      $collectionFactory,
        \Magento\Framework\Message\ManagerInterface                         $messageManager,
        Manager                                                             $eventManager,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist                   $blacklistResource,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist\CollectionFactory $blackCollectionFactory,
        \Amasty\ArtemModule\Model\BlackRepository                           $blackRepository

    )
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->messageManager = $messageManager;
        $this->eventManager = $eventManager;
        $this->blacklistResource = $blacklistResource;
        $this->blackCollectionFactory = $blackCollectionFactory;
        $this->blackRepository = $blackRepository;
    }

    public function execute()
    {

        /**@var \Amasty\ArtemModule\Model\ResourceModel\Blacklist\Collection $blackCollection */

        $params = $this->getRequest()->getParams();

        $blackCollection = $this->blackCollectionFactory->create();
        $blackCollection->addFieldToFilter('sku_blaclist', ['eq' => $params['sku']]);
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter('sku', ['like' => '%']);
        $collection->addAttributeToFilter('type_id', ['like' => 'Simple Product']);
        $collection->addAttributeToSelect('sku');

        $quote = $this->checkoutSession->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        $sku = $params['sku'];
        $qty = $params['qty'];
        $listSku = $blackCollection->getFirstItem();

        if ($sku) {
            $product = $this->productRepository->get($params['sku']);
            $type = $product->getTypeId();
            $sku1 = $product->getData('sku');
            $listSku = $blackCollection->getFirstItem();
            if ($blackCollection->getSize() === 0) {
                if ($type == 'simple') {
                    $quote->addProduct($product, $params['qty']);
                    $quote->save();
                    $this->eventManager->dispatch(
                        'cart_event',
                        ['cart_to_check' => $product]
                    );
                    echo('успех!');
                }
            } elseif ($blackCollection->getSize() > 0) {

                if ($listSku['sku_blaclist'] == $params['sku'] && $listSku['qty_blacklist'] >= $params['qty']) {
                    $quote->addProduct($product, $params['qty']);
                    $quote->save();
                    $this->eventManager->dispatch(
                        'cart_event',
                        ['cart_to_check' => $product]
                    );
                    echo('успех вновь!');
                }else {
                    if ($listSku['sku_blaclist'] == $params['sku'] && $listSku['qty_blacklist'] < $params['qty']) {
                        $finalQty = $params['qty'] - $listSku['qty_blacklist'];
                        $quote->addProduct($product, $finalQty );
                        $quote->save();
                        $this->eventManager->dispatch(
                            'cart_event',
                            ['cart_to_check' => $product]
                        );
                        echo ('wefor');
                        $this->messageManager->addErrorMessage("к сожалению, прошла/и только $finalQty продукта");
                    }
                }
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






































