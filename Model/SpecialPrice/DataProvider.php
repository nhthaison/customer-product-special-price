<?php

namespace Steven\ProductSpecialPrice\Model\SpecialPrice;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Api\Filter;

/**
 * Class DataProvider
 * @package Steven\ProductSpecialPrice\Model\SpecialPrice
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @param Filter $filter
     * @return null
     */
    public function addFilter(Filter $filter)
    {
        return null;
    }
}

