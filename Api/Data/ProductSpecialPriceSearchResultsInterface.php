<?php

namespace Steven\ProductSpecialPrice\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ProductSpecialPriceSearchResultsInterface
 * @package Steven\ProductSpecialPrice\Api\Data
 */
interface ProductSpecialPriceSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get special price list.
     * @return ProductSpecialPriceInterface[]
     */
    public function getItems();

    /**
     * Set special price list.
     * @param ProductSpecialPriceInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

