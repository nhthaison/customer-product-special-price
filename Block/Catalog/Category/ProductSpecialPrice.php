<?php

namespace Steven\ProductSpecialPrice\Block\Catalog\Category;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class ProductSpecialPrice
 * @package Steven\ProductSpecialPrice\Block\Catalog\Category
 */
class ProductSpecialPrice extends Template
{
    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
