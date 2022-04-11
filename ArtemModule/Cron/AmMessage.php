<?php

namespace Amasty\ArtemModule\Cron;

class AmMessage
{
//    /**
//     * @var \Amasty\ArtemModule\Model\BlacklistFactory
//     */
//    private $blaclistFactory;
//    /**
//     * @var \Amasty\ArtemModule\Model\ResourceModel\Blacklist
//     */
//    private $blacklistResource;
//    /**
//     * @var \Magento\Framework\Mail\Template\Factory
//     */
//    private $templateFactory;

    private $logger;

    public function __construct(
        \Amasty\ArtemModule\Model\BlacklistFactory $blaclistFactory,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist $blacklistResource,
        \Magento\Framework\Mail\Template\Factory $templateFactory,
        \Psr\Log\LoggerInterface $logger
    ){
        $this->blaclistFactory = $blaclistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->templateFactory = $templateFactory;
        $this->logger = $logger;
    }
    public function execute()
    {
        $black = $this->blaclistFactory->create();
        $this->blacklistResource->load(
            $black,
            2,
            'sku_id'
        );

        $getQty =  $black->getData('qty_blacklist');
        $templateId = 'amasty_artemmodule_qty_template';
        $templateVars = [
            'qty_blacklist' => $getQty,
        ];
        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => 0
        ];

        $template = $this->templateFactory->get($templateId);
        $template->setVars($templateVars)
            ->setOptions($templateOptions);

        $messageBody = $template->processTemplate();

        $black->setData('email', $messageBody);
        $this->blacklistResource->save($black);

    }
}
