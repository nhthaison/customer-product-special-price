<?php

namespace Steven\ProductSpecialPrice\Block\Adminhtml\Grid\Button;

use Steven\ProductSpecialPrice\Block\Adminhtml\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Add
 * @package Steven\ProductSpecialPrice\Block\Adminhtml\Grid\Button
 */
class Add extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Add Price'),
            'on_click' => sprintf("location.href = '%s';", $this->getAddNewUrl()),
            'class' => 'primary',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for add button
     *
     * @return string
     */
    public function getAddNewUrl(): string
    {
        return $this->getUrl('*/*/add');
    }
}
