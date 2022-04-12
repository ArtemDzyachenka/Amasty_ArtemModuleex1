<?php

namespace Amasty\SecondModule\Block;

use Amasty\ArtemModule\Controller\Index\Index as ArtemIndex;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;


class Index extends ArtemIndex
{
    protected $_customerSession;

    public function __construct(Context $context,
    ScopeConfigInterface $scopeConfig,
    \Magento\Checkout\Model\Session $checkoutSession,
    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
    \Magento\Customer\Model\Session $session,
    \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
    \Magento\Framework\Mail\Template\Factory $templateFactory,
    \Amasty\ArtemModule\Model\ResourceModel\Blacklist                   $blacklistResource,
    \Amasty\ArtemModule\Model\ResourceModel\Blacklist\CollectionFactory $blackCollectionFactory,
    \Amasty\ArtemModule\Model\BlacklistFactory $blaclistFactory

    )
    {
        $this->_customerSession = $session;
        parent::__construct($context,
            $scopeConfig,
            $checkoutSession,
            $productRepository,
            $collectionFactory,
            $transportBuilder,
            $templateFactory,
            $blacklistResource,
            $blackCollectionFactory,
            $blaclistFactory
        );
    }

    public function execute()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return parent::execute();
        } else {
            die ('Зарегестрируйтесь на сайте!');
        }
    }

}
