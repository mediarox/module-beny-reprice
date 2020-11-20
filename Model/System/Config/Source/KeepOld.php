<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class KeepOld
 *
 * Provides values for system config path beny_reprice/export/keep_old.
 */
class KeepOld implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 1, 'label' => __('Enable')],
            ['value' => 0, 'label' => __('Disable')]
        ];
    }
}
