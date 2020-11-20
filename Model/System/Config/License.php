<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\System\Config;

use Laminas\Http\Exception\InvalidArgumentException;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Mediarox\BenyReprice\Model\Api;

/**
 * Class License
 *
 * Check license infos
 */
class License extends Api
{
    /**
     * @return Response
     */
    public function checkLicense(): Response
    {
        $apiKey = $this->config->getApiKey();
        if (empty($apiKey)) {
            throw new InvalidArgumentException(__('No api key found. Please make sure you saved your api key.'));
        }

        $uri = $this->getApiUri(self::BENY_API_LICENSE);
        $method = Request::METHOD_GET;
        $content = '';
        $licenseInfo = $this->sendRequest($uri, $content, $method)->getContent();
        $licenseInfo = $this->prepareLicenseInfo($licenseInfo);
        return $licenseInfo;
    }

    /**
     * @param string $licenseInfo
     * @return mixed
     */
    private function prepareLicenseInfo(string $licenseInfo)
    {
        $info = \json_decode(
            $licenseInfo,
            true,
            512,
            JSON_OBJECT_AS_ARRAY
        );
        $info[0]['marketplaces'] = implode(',', $info[0]['marketplaces']);
        return $info;
    }
}
