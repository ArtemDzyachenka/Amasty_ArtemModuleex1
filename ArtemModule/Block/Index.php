<?php

namespace Amasty\ArtemModule\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\view\Element\Template;

class Index extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    public const FORM_ACTION = 'checkout/cart/add';

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function sayHiTo()
    {
        return 'Hello World!!! ' ;
    }

    public function getWelcomeText()
    {
        return $this->scopeConfig->getValue('first_config/general/welcome_text') ?: ' ';
    }
    public function getQtyStatus()
    {
        return $this->scopeConfig->getValue('first_config/more/qty_enabled',ScopeConfigInterface::SCOPE_TYPE_DEFAULT) ?: ' ';
    }
    public function getQtyNumber()
    {
        return $this->scopeConfig->getValue('first_config/more/qty_number',ScopeConfigInterface::SCOPE_TYPE_DEFAULT) ?: ' ';

    }

    public function getFormAction()
    {
        return $this->getUrl(self::FORM_ACTION);
    }

}
