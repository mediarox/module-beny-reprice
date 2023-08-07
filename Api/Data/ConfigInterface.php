<?php

namespace Mediarox\BenyReprice\Api\Data;

interface ConfigInterface
{
    const CONFIG_BENY_REPRICE_ENABLE = 'beny_reprice/general/enable';
    const CONFIG_BENY_REPRICE_DEBUG_MODE = 'beny_reprice/general/debug_enable';
    const CONFIG_BENY_REPRICE_TEST_MODE = 'beny_reprice/general/test_enable';
    const CONFIG_BENY_REPRICE_API_KEY = 'beny_reprice/general/api_key';
    const CONFIG_BENY_REPRICE_NOTIFY_EMAIL = 'beny_reprice/general/email_notification';
    const CONFIG_BENY_REPRICE_CURL_TIMEOUT = 'beny_reprice/general/timeout';
    const CONFIG_BENY_REPRICE_MARKETPLACE = 'beny_reprice/export/market_place';
    const CONFIG_BENY_REPRICE_FILE = 'beny_reprice/export/file_upoad';
    const CONFIG_BENY_REPIRCE_SEPERATOR = 'beny_reprice/export/seperator';
    const CONFIG_BENY_REPIRCE_LINEEND = 'beny_reprice/export/line_end';
    const CONFIG_BENY_REPIRCE_KEEP_OLD = 'beny_reprice/export/keep_old';
    const CONFIG_BENY_REPIRCE_EXPORT_ALL = 'beny_reprice/import/export_all';
    const CONFIG_BENY_REPIRCE_DELETE_PRODUCT = 'beny_reprice/delete/delete_product';
    const CONFIG_BENY_REPIRCE_ENABLE_CRON = 'beny_reprice/delete/enable_cron';
    const CONFIG_BENY_REPIRCE_IMPORT_PRICES = 'beny_reprice/import/import_prices';
    const CONFIG_BENY_REPIRCE_IMPORT_ENABLE_DECIMAL = 'beny_reprice/import/enable_decimal';
    const CONFIG_BENY_REPIRCE_IMPORT_DECIMALS = 'beny_reprice/import/decimals';
    const CONFIG_BENY_REPIRCE_ENABLE_EXPORT = 'beny_reprice/export/enable_export';
    const CONFIG_BENY_REPIRCE_ONLY_OK = 'beny_reprice/import/only_ok';

    /**
     * @return int
     */
    public function getEnable(): int;

    /**
     * @return int
     */
    public function getDebugEnable(): int;

    /**
     * @return string
     */
    public function getTestEnable(): string;

    /**
     * @return string
     */
    public function getApiKey(): string;

    /**
     * @return string
     */
    public function getMarketPlace(): string;

    /**
     * @return string
     */
    public function getFileUpload(): string;

    /**
     * @return string
     */
    public function getEmailNotification(): string;

    /**
     * @return string
     */
    public function getKeepOld(): string;

    /**
     * @return string
     */
    public function getSeperator(): string;

    /**
     * @return string
     */
    public function getLineEnd(): string;

    /**
     * @return string
     */
    public function getExportAll(): string;

    /**
     * @return int
     */
    public function getDeleteProduct(): int;

    public function getEnableCron(): int;

    /**
     * @return int
     */
    public function getImportPrices(): int;

    /**
     * @return int
     */
    public function getEnableExport(): int;

    /**
     * @return int
     */
    public function getEnableDecimal(): int;

    /**
     * @return int
     */
    public function getDecimals(): int;

    /**
     * @return int
     */
    public function getCurlTimeout(): int;

    /**
     * @return string
     */
    public function getOnlyOk(): string;
}
