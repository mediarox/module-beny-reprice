<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\Product\Update;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;
use Zend\Http\ClientFactory;
use Zend\Http\Exception\RuntimeException;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

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
    private $productUpdate;

    /**
     * Import constructor.
     *
     * @param Config          $config
     * @param UrlInterface    $url
     * @param Request         $request
     * @param Parameters      $parameters
     * @param Headers         $headers
     * @param ClientFactory   $client
     * @param Update          $productUpdate
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $config,
        UrlInterface $url,
        Request $request,
        Parameters $parameters,
        Headers $headers,
        ClientFactory $client,
        Update $productUpdate,
        LoggerInterface $logger
    ) {
        parent::__construct($config, $url, $request, $parameters, $client, $headers, $logger);
        $this->productUpdate = $productUpdate;
    }

    /**
     * Provides parameters for import query.
     *
     * @return array
     */
    private function getImportParams()
    {
        return [
            'exportall' => $this->config->getExportAll(),
            'format' => 'json',
        ];
    }

    /**
     * Import product price updates.
     *
     * @throws \Exception
     */
    public function updatePrices()
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
    private function processProductUpdate($response)
    {
        $error = false;
        $priceUpdates = json_decode($response->getContent(), true);

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
