<?php

declare(strict_types=1);

namespace Steven\ProductSpecialPrice\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class ProductSpecialPrice
 * @package Steven\ProductSpecialPrice\Controller\Adminhtml
 */
abstract class ProductSpecialPrice extends Action
{
    /**
     * Admin resource
     */
    public const ADMIN_RESOURCE = 'Steven_ProductSpecialPrice::product_special_price';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->context = $context;
    }
}

