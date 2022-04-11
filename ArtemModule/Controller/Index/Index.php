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



    private $transportBuilder;

    private $templateFactory;

    public function __construct (
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Mail\Template\Factory $templateFactory,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist                   $blacklistResource,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist\CollectionFactory $blackCollectionFactory,
        \Amasty\ArtemModule\Model\BlacklistFactory $blaclistFactory

    )
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository =  $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->blaclistFactory = $blaclistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->blackCollectionFactory = $blackCollectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->templateFactory = $templateFactory;

    }

    public function execute()
    {
        if ($this->scopeConfig->isSetFlag('first_config/general/enabled'))
        {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            die ('Модуль выключен!!!');
        }
    }
}

