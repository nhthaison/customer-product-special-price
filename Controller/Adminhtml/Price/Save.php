<?php

declare(strict_types=1);

namespace Steven\ProductSpecialPrice\Controller\Adminhtml\Price;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Steven\ProductSpecialPrice\Controller\Adminhtml\ProductSpecialPrice;
use Steven\ProductSpecialPrice\Api\ProductSpecialPriceRepositoryInterface;
use Steven\ProductSpecialPrice\Model\Data\ProductSpecialPriceFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Save
 * @package Steven\ProductSpecialPrice\Controller\Adminhtml\Price
 */
class Save extends ProductSpecialPrice
{
    /**
     * @var ProductSpecialPriceRepositoryInterface
     */
    protected $productSpecialPriceRepository;

    /**
     * @var ProductSpecialPriceFactory
     */
    protected $productSpecialPriceFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ProductSpecialPriceRepositoryInterface $productSpecialPriceRepository
     * @param ProductSpecialPriceFactory $productSpecialPriceFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductSpecialPriceRepositoryInterface $productSpecialPriceRepository,
        ProductSpecialPriceFactory $productSpecialPriceFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context, $resultPageFactory);
        $this->productSpecialPriceRepository = $productSpecialPriceRepository;
        $this->productSpecialPriceFactory = $productSpecialPriceFactory;
        $this->logger = $logger;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        if (!isset($params['product_listing'])) {
            $this->messageManager->addErrorMessage(__('Please select at least one product.'));
            return $resultRedirect->setPath($this->_redirect->getRefererUrl());
        }

        if (!isset($params['customer_listing'])) {
            $this->messageManager->addErrorMessage(__('Please select at least one customer.'));
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        try {
            $priceListing = $this->processData($params);

            if ($priceListing) {
                $this->insertSpecialPrice($priceListing);
                $this->messageManager->addSuccessMessage(
                    'Assigned customer product special price successfully.'
                );

                return $resultRedirect->setPath('special_price/price/index');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e);
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        return $resultRedirect->setPath('special_price/price/index');
    }

    /**
     * @param $params
     * @return array
     */
    private function processData($params): array
    {
        $specialPriceList = [];

        foreach ($params['customer_listing'] as $customer) {
            foreach ($params['product_listing'] as $product) {
                $specialPriceList[] = [
                    'customer_id' => $customer['entity_id'],
                    'product_id' => $product['entity_id'],
                    'price' => $params['price'],
                    'start_date' => $params['start_date'],
                    'end_date' => $params['end_date']
                ];
            }
        }

        return $specialPriceList;
    }

    /**
     * @param $priceList
     * @throws LocalizedException
     */
    private function insertSpecialPrice($priceList): void
    {
        try {
            foreach ($priceList as $price) {
                $price['price'] ? (float)$price['price'] : null;
                $specialPrice = $this->productSpecialPriceFactory->create()
                    ->setCustomerId($price['customer_id'])
                    ->setProductId($price['product_id'])
                    ->setPrice($price['price'])
                    ->setStartDate($price['start_date'])
                    ->setEndDate($price['end_date']);
                $this->productSpecialPriceRepository->save($specialPrice);
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e);
            $this->logger->critical($e);
            throw $e;
        }
    }
}

