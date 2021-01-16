<?php

namespace Steven\ProductSpecialPrice\Api;

use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface ProductSpecialPriceRepositoryInterface
 * @package Steven\ProductSpecialPrice\Api
 */
interface ProductSpecialPriceRepositoryInterface
{
    /**
     * Save special price
     * @param ProductSpecialPriceInterface $specialPrice
     * @return ProductSpecialPriceInterface
     * @throws LocalizedException
     */
    public function save(ProductSpecialPriceInterface $specialPrice);

    /**
     * Retrieve special price
     * @param string $specialPriceId
     * @return ProductSpecialPriceInterface
     * @throws LocalizedException
     */
    public function get($specialPriceId);

    /**
     * Retrieve special price matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete special price
     * @param ProductSpecialPriceInterface $specialPrice
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(ProductSpecialPriceInterface $specialPrice);

    /**
     * Delete special price by ID
     * @param string $specialPriceId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($specialPriceId);
}

