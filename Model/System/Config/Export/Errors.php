<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System\Config\Export;

use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\Api;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;
use Zend\Http\ClientFactory;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class Errors
 *
 * Prepare csv file for download.
 */
class Errors extends Api
{
    public function __construct(
        Config $config,
        UrlInterface $url,
        Request $request,
        Parameters $parameters,
        ClientFactory $client,
        Headers $headers,
        LoggerInterface $logger
    ) {
        parent::__construct($config, $url, $request, $parameters, $client, $headers, $logger);
    }

    /**
     * @return \Zend\Http\Response
     */
    public function exportErrors()
    {
        $uri = $this->getApiUri(self::BENY_API_GET_ERRORS);
        $method = Request::METHOD_GET;
        $content = '';
        $params = $this->getErrorParams();

        return $this->sendRequest($uri, $content, $method, null, $params);
    }

    protected function getErrorParams()
    {
        return [
            'format' => 'csv'
        ];
    }
}
