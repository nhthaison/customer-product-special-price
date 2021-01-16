<?php

declare(strict_types=1);

namespace Steven\ProductSpecialPrice\Controller\Adminhtml\Price;

use Magento\Framework\Controller\ResultInterface;
use Steven\ProductSpecialPrice\Controller\Adminhtml\ProductSpecialPrice;

/**
 * Class Add
 * @package Steven\ProductSpecialPrice\Controller\Adminhtml\Price
 */
class Add extends ProductSpecialPrice
{
    /**
     * Action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Steven_ProductSpecialPrice::product_special_price');
        $resultPage->getConfig()->getTitle()->prepend(__('Select Product and Customer'));

        return $resultPage;
    }
}

