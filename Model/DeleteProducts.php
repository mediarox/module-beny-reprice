<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;
use Zend\Http\ClientFactory;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class DeleteProducts
 *
 * Responsible for delete action.
 */
class DeleteProducts extends Api
{
    /**
     * Delete constructor.
     *
     * @param Config          $config
     * @param UrlInterface    $url
     * @param Request         $request
     * @param Parameters      $parameters
     * @param Headers         $headers
     * @param ClientFactory   $client
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $config,
        UrlInterface $url,
        Request $request,
        Parameters $parameters,
        Headers $headers,
        ClientFactory $client,
        LoggerInterface $logger
    ) {
        parent::__construct($config, $url, $request, $parameters, $client, $headers, $logger);
    }

    /**
     * Send delete request to Beny.
     *
     * @param array $productSkus
     * @return \Zend\Http\Response
     * @throws \Exception
     */
    public function deleteFromBeny(array $productSkus)
    {
        $uri = $this->getApiUri(self::BENY_API_DELETE_PRODUCTS);
        $requestContent = json_encode(['ids' => [$productSkus]]);
        $headers = $this->headers->addHeaders(['Content-Type=application/json']);
        $method = Request::METHOD_GET;

        return $this->sendRequest($uri, $requestContent, $method, $headers);
    }
}
