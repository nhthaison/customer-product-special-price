<?php

namespace Steven\ProductSpecialPrice\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ProductSpecialPriceInterface
 * @package Steven\ProductSpecialPrice\Api\Data
 */
interface ProductSpecialPriceInterface extends ExtensibleDataInterface
{
    /**
     * Special price id
     */
    public const ID = 'id';

    /**
     * Customer id
     */
    public const CUSTOMER_ID = 'customer_id';

    /**
     * Product id
     */
    public const PRODUCT_ID = 'product_id';

    /**
     * Product special price
     */
    public const PRICE = 'price';

    /**
     * Start date
     */
    public const START_DATE = 'start_date';

    /**
     * End date
     */
    public const END_DATE = 'end_date';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return ProductSpecialPriceInterface
     */
    public function setId($id);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceExtensionInterface $extensionAttributes
    );

    /**
     * Get customer id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer id
     * @param string $customerId
     * @return ProductSpecialPriceInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get product id
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product id
     * @param string $productId
     * @return ProductSpecialPriceInterface
     */
    public function setProductId($productId);

    /**
     * Get special price
     * @return string|null
     */
    public function getPrice();

    /**
     * Set special price
     * @param string $price
     * @return ProductSpecialPriceInterface
     */
    public function setPrice($price);

    /**
     * Get start date
     * @return string|null
     */
    public function getStartDate();

    /**
     * Set start date
     * @param string $startDate
     * @return ProductSpecialPriceInterface
     */
    public function setStartDate($startDate);

    /**
     * Get end date
     * @return string|null
     */
    public function getEndDate();

    /**
     * Set end date
     * @param string $endDate
     * @return ProductSpecialPriceInterface
     */
    public function setEndDate($endDate);
}

