<?php
/**
 * @package   Mediarox\BenyReprice\Cron
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Cron;

use Mediarox\BenyReprice\Model\GetPriceUpdates;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;

/**
 * Class Import
 *
 * Cron class for product price updates on Magento database.
 */
class Import
{
    /**
     * @var GetPriceUpdates
     */
    private GetPriceUpdates $import;
    /**
     * @var Config
     */
    private Config $config;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Import constructor.
     *
     * @param GetPriceUpdates $import
     * @param Config          $config
     * @param LoggerInterface $logger
     */
    public function __construct(GetPriceUpdates $import, Config $config, LoggerInterface $logger)
    {
        $this->import = $import;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Entry point for cron based price updates.
     */
    public function execute()
    {
        if ($this->config->getImportPrices()) {
            try {
                $response = $this->import->updatePrices();
                if ($this->config->getDebugEnable()) {
                    $this->logger->debug('Upadte Magento DB: ' . $response->getContent());
                }
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}
