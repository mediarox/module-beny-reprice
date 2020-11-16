<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Seperator
 *
 * Provides values for system config path beny_reprice/export/seperator.
 */
class Seperator implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'comma', 'label' => __('Comma')],
            ['value' => 'semicolon', 'label' => __('Semicolon')],
            ['value' => 'tab', 'label' => __('Tab')]
        ];
    }
}
