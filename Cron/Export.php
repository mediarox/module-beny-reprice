<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Cron;

use Mediarox\BenyReprice\Model\ImportProducts;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;

/**
 * Class Export
 *
 * Cron class for product export to Beny.
 */
class Export
{
    /**
     * @var ImportProducts
     */
    private $export;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Export constructor.
     *
     * @param ImportProducts $export
     * @param Config                                     $config
     * @param LoggerInterface                            $logger
     */
    public function __construct(ImportProducts $export, Config $config, LoggerInterface $logger)
    {
        $this->export = $export;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Entry point for cron based product export to Beny.
     */
    public function execute()
    {
        if ($this->config->getEnableExport()) {
            try {
                $response = $this->export->import();
                if ($this->config->getDebugEnable()) {
                    $this->logger->debug('Update Beny DB response: ' . $response->getContent());
                }
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}
