<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Marketplace
 *
 * Provides values for system config path beny_reprice/export/market_place.
 */
class Marketplace implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'google.de', 'label' => 'google.de'],
            ['value' => 'amazon.de', 'label' => 'amazon.de'],
            ['value' => 'ebay.de', 'label' => 'ebay.de'],
            ['value' => 'idealo.de', 'label' => 'idealo.de'],
            ['value' => 'ladenzeile.de', 'label' => 'ladenzeile.de'],
            ['value' => 'rakuten.de', 'label' => 'rakuten.de'],
            ['value' => 'toppreise.de', 'label' => 'toppreise.de'],
            ['value' => 'mercateo.de', 'label' => 'mercateo.de'],
            ['value' => 'billiger.de', 'label' => 'billiger.de'],
            ['value' => 'geizhals.de', 'label' => 'geizhals.de'],
            ['value' => 'geizhals.ch', 'label' => 'geizhals.ch'],
            ['value' => 'geizhals.at', 'label' => 'geizhals.at'],
        ];
    }
}
