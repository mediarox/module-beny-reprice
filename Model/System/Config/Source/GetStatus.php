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
class GetStatus implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'OK', 'label' => __('OK')],
            ['value' => 'LISTED', 'label' => __('LISTED')],
            ['value' => 'NOT_FOUND', 'label' => __('NOT_FOUND')],
            ['value' => 'ERROR', 'label' => __('ERROR')],
            ['value' => 'PENDING', 'label' => __('PENDING')],
            ['value' => 'NO_RESULT', 'label' => __('NO_RESULT')],
            ['value' => 'ERROR_EAN', 'label' => __('ERROR_EAN')],
            ['value' => 'MISSING_MANDATORIES', 'label' => __('MISSING_MANDATORIES')],
            ['value' => 'VALIDATION', 'label' => __('VALIDATION')],
            ['value' => 'MISSING_MINMAX', 'label' => __('MISSING_MINMAX')],
        ];
    }
}
