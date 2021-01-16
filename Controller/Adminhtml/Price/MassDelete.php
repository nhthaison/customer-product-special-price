<?php

declare(strict_types=1);

namespace Steven\ProductSpecialPrice\Controller\Adminhtml\Price;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\InventoryAdminUi\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Steven\ProductSpecialPrice\Model\ProductSpecialPriceRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Steven\ProductSpecialPrice\Controller\Adminhtml\ProductSpecialPrice;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class MassDelete
 * @package Steven\ProductSpecialPrice\Controller\Adminhtml\Price
 */
class MassDelete extends ProductSpecialPrice implements HttpPostActionInterface
{
    /**
     * @var ProductSpecialPriceRepository
     */
    protected $productSpecialPriceRepository;

    /**
     * @var Filter
     */
    private $massActionFilter;

    /**
     * @param Context $context
     * @param ProductSpecialPriceRepository $productSpecialPriceRepository
     * @param Filter $massActionFilter
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        ProductSpecialPriceRepository $productSpecialPriceRepository,
        Filter $massActionFilter,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $resultPageFactory);
        $this->massActionFilter = $massActionFilter;
        $this->productSpecialPriceRepository = $productSpecialPriceRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRequest()->isPost() !== true) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        $deletedItemsCount = 0;

        foreach ($this->massActionFilter->getIds() as $id) {
            try {
                $id = (int)$id;
                $this->productSpecialPriceRepository->deleteById($id);
                $deletedItemsCount++;
            } catch (NoSuchEntityException | LocalizedException $e) {
                $errorMessage = __('[ID: %1] ', $id) . $e->getMessage();
                $this->messageManager->addErrorMessage($errorMessage);
            }
        }

        $this->messageManager->addSuccessMessage(__('You deleted %1 special price(s).', $deletedItemsCount));
        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }
}
