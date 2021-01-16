<?php

namespace Steven\ProductSpecialPrice\Model;

use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterface;
use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterfaceFactory;
use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceSearchResultsInterfaceFactory;
use Steven\ProductSpecialPrice\Api\ProductSpecialPriceRepositoryInterface;
use Steven\ProductSpecialPrice\Model\ProductSpecialPriceFactory;
use Steven\ProductSpecialPrice\Model\ResourceModel\ProductSpecialPrice as ProductSpecialPriceResourceModel;
use Steven\ProductSpecialPrice\Model\ResourceModel\ProductSpecialPrice\CollectionFactory as ProductSpecialPriceCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Exception;

/**
 * Class ProductSpecialPriceRepository
 * @package Steven\ProductSpecialPrice\Model
 */
class ProductSpecialPriceRepository implements ProductSpecialPriceRepositoryInterface
{
    /**
     * @var ProductSpecialPriceResourceModel
     */
    protected $resource;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var ProductSpecialPriceFactory
     */
    protected $productSpecialPriceFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var ProductSpecialPriceSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var ProductSpecialPriceInterfaceFactory
     */
    protected $dataProductSpecialPriceFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var ProductSpecialPriceCollectionFactory
     */
    protected $productSpecialPriceCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ProductSpecialPriceResourceModel $resource
     * @param ProductSpecialPriceFactory $productSpecialPriceFactory
     * @param ProductSpecialPriceInterfaceFactory $dataProductSpecialPriceFactory
     * @param ProductSpecialPriceCollectionFactory $productSpecialPriceCollectionFactory
     * @param ProductSpecialPriceSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ProductSpecialPriceResourceModel $resource,
        ProductSpecialPriceFactory $productSpecialPriceFactory,
        ProductSpecialPriceInterfaceFactory $dataProductSpecialPriceFactory,
        ProductSpecialPriceCollectionFactory $productSpecialPriceCollectionFactory,
        ProductSpecialPriceSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->productSpecialPriceFactory = $productSpecialPriceFactory;
        $this->productSpecialPriceCollectionFactory = $productSpecialPriceCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataProductSpecialPriceFactory = $dataProductSpecialPriceFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ProductSpecialPriceInterface $specialPrice)
    {
        $specialPriceData = $this->extensibleDataObjectConverter->toNestedArray(
            $specialPrice,
            [],
            ProductSpecialPriceInterface::class
        );

        $specialPriceModel = $this->productSpecialPriceFactory->create()->setData($specialPriceData);

        try {
            $this->resource->save($specialPriceModel);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the special price: %1',
                    $exception->getMessage()
                )
            );
        }

        return $specialPriceModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($specialPriceId)
    {
        $specialPrice = $this->productSpecialPriceFactory->create();
        $this->resource->load($specialPrice, $specialPriceId);

        if (!$specialPrice->getId()) {
            throw new NoSuchEntityException(__('Special price with id "%1" does not exist.', $specialPriceId));
        }

        return $specialPrice->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->productSpecialPriceCollectionFactory->create();
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            ProductSpecialPriceInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $items = [];

        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProductSpecialPriceInterface $specialPrice)
    {
        try {
            $specialPriceModel = $this->productSpecialPriceFactory->create();
            $this->resource->load($specialPriceModel, $specialPrice->getId());
            $this->resource->delete($specialPriceModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the special price: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($specialPriceId)
    {
        return $this->delete($this->get($specialPriceId));
    }
}

