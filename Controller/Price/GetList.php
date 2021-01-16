<?php

namespace Steven\ProductSpecialPrice\Controller\Price;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Customer\Model\Session;
use Steven\ProductSpecialPrice\Model\ProductSpecialPriceRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use DateTime;
use Steven\ProductSpecialPrice\Api\Data\ProductSpecialPriceInterface;
use Magento\Framework\Pricing\Helper\Data;

/**
 * Class GetList
 * @package Steven\ProductSpecialPrice\Controller\Price
 */
class GetList implements HttpGetActionInterface
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ProductSpecialPriceRepository
     */
    protected $productSpecialPriceRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * @var Data
     */
    protected $pricingHelper;

    /**
     * GetList constructor.
     * @param ResultFactory $resultFactory
     * @param Session $session
     * @param ProductSpecialPriceRepository $productSpecialPriceRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param LoggerInterface $logger
     * @param TimezoneInterface $timezone
     * @param Data $pricingHelper
     */
    public function __construct(
        ResultFactory $resultFactory,
        Session $session,
        ProductSpecialPriceRepository $productSpecialPriceRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger,
        TimezoneInterface $timezone,
        Data $pricingHelper
    ) {
        $this->resultFactory = $resultFactory;
        $this->session = $session;
        $this->productSpecialPriceRepository = $productSpecialPriceRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
        $this->timezone = $timezone;
        $this->pricingHelper = $pricingHelper;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $customerId = 6;

        if (!$customerId) {
            return $resultJson->setData(['result' => '']);
        }

        return $resultJson->setData(['result' => $this->getCustomerSpecialPrice($customerId)]);
    }

    /**
     * @return int|null
     */
    protected function isCustomerLoggedIn(): ?int
    {
        return $this->session->getCustomerId();
    }

    /**
     * @param $customerId
     * @return array
     */
    protected function getCustomerSpecialPrice($customerId): array
    {
        $result = [];
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('customer_id', $customerId)->create();

        try {
            $specialPriceList = $this->productSpecialPriceRepository->getList($searchCriteria);

            if ($specialPriceList->getTotalCount()) {
                foreach ($specialPriceList->getItems() as $specialPrice) {
                    if ($this->validateSpecialPricePeriod($specialPrice)) {
                        $result[] = [
                            'product_id' => $specialPrice->getProductId(),
                            'price' => $this->pricingHelper->currency($specialPrice->getPrice(), true)
                        ];
                    }
                }
            }
        } catch (LocalizedException $e) {
            $this->logger->critical($e);
        }

        return $result;
    }

    /**
     * @return DateTime
     */
    protected function getCurrentDate(): DateTime
    {
        return $this->timezone->date();
    }

    /**
     * @param ProductSpecialPriceInterface $specialPrice
     * @return bool
     */
    protected function validateSpecialPricePeriod(ProductSpecialPriceInterface $specialPrice): bool
    {
        $currentDate = $this->getCurrentDate()->format('d-m-Y');

        // Check start date
        if ($startDate = $specialPrice->getStartDate()) {
            $startDate = $this->timezone->date($startDate)->format('d-m-Y');

            if (strtotime($currentDate) < strtotime($startDate)) {
                return false;
            }
        }

        // Check end date
        if ($endDate = $specialPrice->getEndDate()) {
            $endDate = $this->timezone->date($endDate)->format('d-m-Y');

            if (strtotime($endDate) < strtotime($currentDate)) {
                return false;
            }
        }

        return true;
    }
}
