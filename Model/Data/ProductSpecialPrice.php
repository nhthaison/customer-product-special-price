<?php

namespace Steven\ProductSpecialPrice\Model\Data;

use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceExtensionInterface;
use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

/**
 * Class ProductSpecialPrice
 * @package Steven\ProductSpecialPrice\Model\Data
 */
class ProductSpecialPrice extends AbstractExtensibleObject implements ProductSpecialPriceInterface
{
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(
        \Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return $this->_get(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function getStartDate()
    {
        return $this->_get(self::START_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setStartDate($startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * @inheritDoc
     */
    public function getEndDate()
    {
        return $this->_get(self::END_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setEndDate($endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }

    /**
     * @inheritDoc
     */
    public function getPrice()
    {
        return $this->_get(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }
}
