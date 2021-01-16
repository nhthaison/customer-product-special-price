<?php

namespace Steven\ProductSpecialPrice\Block\Adminhtml\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Steven\ProductSpecialPrice\Block\Adminhtml\GenericButton;

/**
 * Class BackButton
 * @package Steven\ProductSpecialPrice\Block\Adminhtml\Form\Button
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back button
     *
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*');
    }
}

