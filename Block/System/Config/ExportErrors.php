<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Block\System\Config;

use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class ExportErrors
 *
 * Prepare export button.
 */
class ExportErrors extends Field
{
    const CONTROLLER_ROUTE_EXPORT_ERRORS = 'mediarox_beny/system_config_export/errors';
    protected $_template = 'Mediarox_BenyReprice::system/config/export_errors.phtml';

    /**
     * ExportErrors constructor.
     *
     * @param Context $context
     * @param array   $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->getUrl(self::CONTROLLER_ROUTE_EXPORT_ERRORS);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getButtonHtml()
    {
        $url = $this->getAjaxUrl();
        $button = $this->getLayout()->createBlock(
            Button::class
        )->setData(
            [
                'id' => 'export_erroneous_products',
                'label' => __('Export Erroneous Products'),
                'onclick' => "setLocation('" . $url . "')",
                'url' => $url
            ]
        );
        return $button->toHtml();
    }
}
