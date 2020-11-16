<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System\Config\Export;

use Laminas\Http\Request;
use Mediarox\BenyReprice\Model\Api;

/**
 * Class Errors
 *
 * Prepare csv file for download.
 */
class Errors extends Api
{
    /**
     * @return \Laminas\Http\Response
     */
    public function exportErrors(): \Laminas\Http\Response
    {
        $uri = $this->getApiUri(self::BENY_API_GET_ERRORS);
        $method = Request::METHOD_GET;
        $content = '';
        $params = $this->getErrorParams();

        return $this->sendRequest($uri, $content, $method, null, $params);
    }

    protected function getErrorParams(): array
    {
        return [
            'format' => 'csv',
        ];
    }
}
