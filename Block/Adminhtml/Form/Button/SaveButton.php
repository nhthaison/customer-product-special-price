<?php

namespace Steven\ProductSpecialPrice\Block\Adminhtml\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Steven\ProductSpecialPrice\Block\Adminhtml\GenericButton;

/**
 * Class SaveButton
 * @package Steven\ProductSpecialPrice\Block\Adminhtml\Form\Button
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}

