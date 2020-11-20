<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Laminas\Http\Client;
use Laminas\Http\Client\Adapter\Curl;
use Laminas\Http\ClientFactory;
use Laminas\Http\Exception\RuntimeException;
use Laminas\Http\Headers;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\Stdlib\Parameters;
use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;

/**
 * Class Api
 *
 * Base class for api connections.
 */
class Api
{
    const BENY_API_BASE_URL = 'https://web.beny-ag.com/api/beny/login/';
    const BENY_API_GET_PRICE_UPDATES = '/get_price_updates?';
    const BENY_API_IMPORT_PRODUCTS = '/import_products?';
    const BENY_API_DELETE_PRODUCTS = '/delete_products?';
    const BENY_API_GET_ERRORS = '/get_errors?';
    const BENY_API_LICENSE = '/license';
    const BENY_API_INITIAL_ALL = '/all_initial?';
    const BENY_API_UPLOAD_DIR = 'beny_reprice';
    /**
     * @var Config
     */
    protected Config $config;
    /**
     * @var UrlInterface
     */
    private UrlInterface $url;
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Parameters
     */
    private Parameters $parameters;
    /**
     * @var ClientFactory
     */
    private ClientFactory $client;
    /**
     * @var Headers
     */
    protected Headers $headers;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Api constructor.
     *
     * @param Config          $config
     * @param UrlInterface    $url
     * @param Request         $request
     * @param Parameters      $parameters
     * @param ClientFactory   $client
     * @param Headers         $headers
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $config,
        UrlInterface $url,
        ClientFactory $client,
        Request $request,
        Parameters $parameters,
        Headers $headers,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->url = $url;
        $this->request = $request;
        $this->parameters = $parameters;
        $this->client = $client;
        $this->headers = $headers;
        $this->logger = $logger;
    }

    /**
     * @param string $function
     * @return string
     */
    protected function getApiUri(string $function): string
    {
        return self::BENY_API_BASE_URL . $this->config->getApiKey() . $function;
    }

    /**
     * @param string  $uri
     * @param string  $content
     * @param string  $method
     * @param Headers $headers
     * @param array   $params
     * @return Request
     */
    protected function prepareRequest(
        string $uri,
        string $content,
        string $method,
        ?Headers $headers,
        array $params
    ): Request {
        $this->request->setUri($uri);
        $this->request->setContent($content);
        $this->request->setMethod($method);
        if (!null === $headers) {
            $this->request->setHeaders($headers);
        }
        $params = array_merge($params, $this->getStandardParams());
        $this->parameters->fromArray($params);
        return $this->request->setQuery($this->parameters);
    }

    /**
     * @param string  $uri
     * @param string  $content
     * @param string  $method
     * @param Headers $headers
     * @param array   $params
     * @return Response
     */
    protected function sendRequest(
        string $uri,
        string $content,
        string $method,
        Headers $headers = null,
        array $params = []
    ): Response {
        /** @var Client $client */
        $client = $this->client->create();
        $client->setOptions([
            'adapter'     => Curl::class,
            'curloptions' => [
                CURLOPT_RETURNTRANSFER => 1,
            ],
        ]);

        $request = $this->prepareRequest($uri, $content, $method, $headers, $params);
        if ($this->config->getDebugEnable()) {
            $this->logger->debug('Request Method: ' . $request->getMethod());
            $this->logger->debug('Request URI: ' . $request->getUriString());
            $this->logger->debug('Request Content: ' . $request->getContent());
        }
        $response = $client->send($request);

        if (!$response) {
            throw new RuntimeException(__('Unable to read response, or response is empty'));
        }
        return $response;
    }

    /**
     * @return array
     */
    protected function getStandardParams(): array
    {
        return [
            'test'        => $this->config->getTestEnable(),
            'marketplace' => $this->config->getMarketPlace(),
        ];
    }
}
