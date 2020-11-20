<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Mediarox\BenyReprice\Api\Data\ConfigInterface;

/**
 * Class Config
 *
 * Collects configuration values.
 */
class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    public ScopeConfigInterface $scopeConfig;

    /**
     * Export constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        $apiKey = $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_API_KEY);
        if (null === $apiKey) {
            $apiKey = '';
        }
        return $apiKey;
    }

    /**
     * @return int
     */
    public function getEnable(): int
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_ENABLE);
    }

    /**
     * @return int
     */
    public function getDebugEnable(): int
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_DEBUG_MODE);
    }

    /**
     * @return string
     */
    public function getTestEnable(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_TEST_MODE) ? "true" : "false";
    }

    /**
     * @return string
     */
    public function getMarketPlace(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_MARKETPLACE);
    }

    /**
     * @return string
     */
    public function getFileUpload(): string
    {
        $filePath = $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_FILE);
        if (null === $filePath) {
            $filePath = '';
        }
        return $filePath;
    }

    /**
     * @return string
     */
    public function getEmailNotification(): string
    {
        $email = $this->scopeConfig->getValue(self::CONFIG_BENY_REPRICE_NOTIFY_EMAIL);
        if (null === $email) {
            $email = '';
        }
        return $email;
    }

    /**
     * @inheritDoc
     */
    public function getKeepOld(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_KEEP_OLD) ? "true" : "false";
    }

    /**
     * @inheritDoc
     */
    public function getSeperator(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_SEPERATOR);
    }

    /**
     * @inheritDoc
     */
    public function getLineEnd(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_LINEEND);
    }

    /**
     * @inheritDoc
     */
    public function getExportAll(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_EXPORT_ALL) ? "true" : "false";
    }

    /**
     * @inheritDoc
     */
    public function getDeleteProduct(): int
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_DELETE_PRODUCT);
    }

    /**
     * @inheritDoc
     */
    public function getImportPrices(): int
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_IMPORT_PRICES);
    }

    /**
     * @inheritDoc
     */
    public function getEnableExport(): int
    {
        return $this->scopeConfig->getValue(self::CONFIG_BENY_REPIRCE_ENABLE_EXPORT);
    }
}
