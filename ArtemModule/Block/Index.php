<?php

namespace Amasty\ArtemModule\Block;

use Magento\Framework\view\Element\Template;

class Index extends Template
{
    public function sayHiTo()
    {
        return 'Hello World!!! ' ;
    }
}
