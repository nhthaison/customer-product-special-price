<?php

namespace Steven\ProductSpecialPrice\Model\ResourceModel\ProductSpecialPrice;

use Steven\ProductSpecialPrice\Model\ProductSpecialPrice;
use Steven\ProductSpecialPrice\Model\ResourceModel\ProductSpecialPrice as ProductSpecialPriceResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Steven\ProductSpecialPrice\Model\ResourceModel\ProductSpecialPrice
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            ProductSpecialPrice::class,
            ProductSpecialPriceResourceModel::class
        );
    }
}

