<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model\Product;

use Magento\Catalog\Model\ResourceModel\Product;
use Psr\Log\InvalidArgumentException;

/**
 * Class Update
 *
 * Update product price attribute.
 */
class Update
{
    /**
     * @var Product
     */
    private $productResource;
    /**
     * @var Product\Action
     */
    private $productAction;

    /**
     * Update constructor.
     *
     * @param Product        $productResource
     * @param Product\Action $productAction
     */
    public function __construct(Product $productResource, Product\Action $productAction)
    {
        $this->productResource = $productResource;
        $this->productAction = $productAction;
    }

    /**
     * Performs attribute update for product price.
     *
     * @param array $priceUpdate
     * @throws \Exception
     */
    public function processProductUpdate(array $priceUpdate)
    {
        if (!$productSku = $priceUpdate['id']) {
            throw new InvalidArgumentException('Beny Reprice: SKU is missing for product update.');
        }
        if (!$productId = $this->productResource->getIdBySku($productSku)) {
            throw new InvalidArgumentException(__('Product with sku ' . $productSku . ' does not exist.'));
        }
        if (!$newPrice = $priceUpdate['new_price']) {
            throw new InvalidArgumentException('Beny Reprice: new_price field was empty. Product sku: ' . $productSku);
        }
        $newPrice = round($newPrice, 2);
        $this->productAction->updateAttributes(
            [$productId],
            ['price' => $newPrice],
            0
        );
    }
}
