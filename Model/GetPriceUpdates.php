<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Laminas\Http\ClientFactory;
use Laminas\Http\Exception\RuntimeException;
use Laminas\Http\Headers;
use Laminas\Http\Request;
use Laminas\Stdlib\Parameters;
use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\Product\Update;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;

/**
 * Class GetPriceUpdates
 *
 * Collects price updates from Beny.
 */
class GetPriceUpdates extends Api
{
    /**
     * @var Update
     */
    private Update $productUpdate;

    public function __construct(
        Config $config,
        UrlInterface $url,
        ClientFactory $client,
        Request $request,
        Parameters $parameters,
        Headers $headers,
        LoggerInterface $logger,
        Update $productUpdate
    ) {
        parent::__construct($config, $url, $client, $request, $parameters, $headers, $logger);
        $this->productUpdate = $productUpdate;
    }

    /**
     * Provides parameters for import query.
     *
     * @return array
     */
    private function getImportParams(): array
    {
        return [
            'exportall' => $this->config->getExportAll(),
            'format'    => 'json',
        ];
    }

    /**
     * Import product price updates.
     *
     * @throws \Exception
     */
    public function updatePrices(): \Laminas\Http\Response
    {
        $parameters = $this->getImportParams();
        $requestContent = '';
        $method = Request::METHOD_GET;
        $uri = $this->getApiUri(self::BENY_API_GET_PRICE_UPDATES);

        $response = $this->sendRequest($uri, $requestContent, $method, null, $parameters);

        $error = $this->processProductUpdate($response);

        if ($error) {
            throw new RuntimeException('Product price update threw errors. Please check the log.');
        }
        return $response;
    }

    /**
     * Update database values.
     *
     * @param $response
     * @return bool
     */
    private function processProductUpdate($response): bool
    {
        $error = false;
        $priceUpdates = \json_decode($response->getContent(), true);

        foreach ($priceUpdates as $priceUpdate) {
            try {
                $this->productUpdate->processProductUpdate($priceUpdate);
            } catch (\Exception $e) {
                $this->logger->critical('Price update failed for product id: ' . $priceUpdate['id']);
                $error = true;
            }
        }
        return $error;
    }
}
