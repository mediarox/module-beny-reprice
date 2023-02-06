<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Laminas\Http\Request;
use Laminas\Http\Response;

/**
 * Class DeleteProducts
 *
 * Responsible for delete action.
 */
class DeleteProducts extends Api
{
    /**
     * Send delete request to Beny.
     *
     * @param array $productSkus
     * @return Response
     */
    public function deleteFromBeny(array $productSkus): Response
    {
        $uri = $this->getApiUri(self::BENY_API_DELETE_PRODUCTS);
        $deleteSkus = ['ids' => implode(',', $productSkus)];
        $headers = $this->headers->addHeaders(['Content-Type' => 'application/json']);
        $method = Request::METHOD_GET;

        return $this->sendRequest($uri, '', $method, $headers, $deleteSkus);
    }
}
