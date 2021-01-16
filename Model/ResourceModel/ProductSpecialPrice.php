<?php

namespace Steven\ProductSpecialPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ProductSpecialPrice
 * @package Steven\ProductSpecialPrice\Model\ResourceModel
 */
class ProductSpecialPrice extends AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('customer_product_special_price', 'id');
    }
}

