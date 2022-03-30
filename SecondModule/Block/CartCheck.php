<?php

namespace Amasty\SecondModule\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\view\Element\Template;


class CartCheck extends Template
{

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getForSku()
    {
        return $this->scopeConfig->getValue('second_config/all_sku/promo_sku') ?: ' ';
    }
    public function getPromoSku()
    {
        return $this->scopeConfig->getValue('second_config/all_sku/standart_sku') ?: ' ';

    }
}
