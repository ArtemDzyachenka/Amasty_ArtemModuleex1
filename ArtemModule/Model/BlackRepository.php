<?php

namespace Amasty\ArtemModule\Model;

class BlackRepository
{
    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var ResourceModel\Blacklist
     */
    private $blackResource;

    public function __construct(
        \Amasty\ArtemModule\Model\BlacklistFactory $blacklistFactory,
        \Amasty\ArtemModule\Model\ResourceModel\Blacklist $blackResource
    )
    {
        $this->blackResource = $blackResource;
        $this->blacklistFactory = $blacklistFactory;
    }

    public function getById( $id): \Amasty\ArtemModule\Model\Blacklist
    {
        $blacklist = $this->blacklistFactory->create();
        $this->blackResource->load(
            $blacklist,
            $id
        );
        return $blacklist;
    }
}
