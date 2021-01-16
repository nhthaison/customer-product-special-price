<?php

namespace Steven\ProductSpecialPrice\Controller\Adminhtml\Price;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Steven\ProductSpecialPrice\Controller\Adminhtml\ProductSpecialPrice;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Steven\ProductSpecialPrice\Model\ProductSpecialPriceRepository;

/**
 * Class DeleteItem
 * @package Steven\ProductSpecialPrice\Controller\Adminhtml\Price
 */
class DeleteItem extends ProductSpecialPrice implements HttpPostActionInterface
{
    /**
     * @var ProductSpecialPriceRepository
     */
    protected $productSpecialPriceRepository;

    /**
     * DeleteItem constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ProductSpecialPriceRepository $productSpecialPriceRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductSpecialPriceRepository $productSpecialPriceRepository
    ) {
        parent::__construct($context, $resultPageFactory);
        $this->productSpecialPriceRepository = $productSpecialPriceRepository;
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

        if (!isset($params['id'])) {
            $this->messageManager->addErrorMessage(__('Please select a record.'));
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        try {
            $this->productSpecialPriceRepository->deleteById($params['id']);
            $this->messageManager->addSuccessMessage(__('Deleted successfully.'));
        } catch (NoSuchEntityException | LocalizedException $e) {
            $this->messageManager->createMessage($e);
        }

        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }
}
