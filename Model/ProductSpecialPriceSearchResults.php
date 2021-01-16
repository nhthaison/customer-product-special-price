<?php

declare(strict_types=1);

namespace Steven\ProductSpecialPrice\Model;

use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Class ProductSpecialPriceSearchResults
 * @package Steven\ProductSpecialPrice\Model
 */
class ProductSpecialPriceSearchResults extends SearchResults implements ProductSpecialPriceSearchResultsInterface
{
}
