<?php

namespace Steven\ProductSpecialPrice\Model;

use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterface;
use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterfaceFactory;
use Steven\ProductSpecialPrice\Model\ResourceModel\ProductSpecialPrice\Collection;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class ProductSpecialPrice
 * @package Steven\ProductSpecialPrice\Model
 */
class ProductSpecialPrice extends AbstractModel
{
    /**
     * @var ProductSpecialPriceInterfaceFactory
     */
    protected $specialPriceDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'special_price';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ProductSpecialPriceInterfaceFactory $specialPriceDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\ProductSpecialPrice $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ProductSpecialPriceInterfaceFactory $specialPriceDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\ProductSpecialPrice $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->specialPriceDataFactory = $specialPriceDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve special price model with special price data
     * @return ProductSpecialPriceInterface
     */
    public function getDataModel()
    {
        $specialPriceData = $this->getData();
        $specialPriceDataObject = $this->specialPriceDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $specialPriceDataObject,
            $specialPriceData,
            ProductSpecialPriceInterface::class
        );

        return $specialPriceDataObject;
    }
}

