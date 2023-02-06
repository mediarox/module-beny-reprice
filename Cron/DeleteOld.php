<?php

/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2023 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

declare(strict_types=1);

namespace Mediarox\BenyReprice\Cron;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Mediarox\BenyReprice\Model\DeleteProducts;
use Mediarox\BenyReprice\Model\System\Config;

class DeleteOld
{
    protected DeleteProducts $deleteProducts;
    protected CollectionFactory $collectionFactory;
    protected Config $config;

    public function __construct(
        DeleteProducts $deleteProducts,
        CollectionFactory $collectionFactory,
        Config $config
    ) {
        $this->deleteProducts = $deleteProducts;
        $this->collectionFactory = $collectionFactory;
        $this->config = $config;
    }

    public function execute()
    {
        if ($this->config->getDeleteProduct()) {
            $deleteSkus = $this->getSkusToDelete();
            $deleteSkus = array_chunk($deleteSkus, 200);
            foreach ($deleteSkus as $deleteSkusSplice) {
                $this->deleteProducts->deleteFromBeny($deleteSkusSplice);
            }
        }
    }

    private function getSkusToDelete(): array
    {
        /** @var Collection $productCollection */
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToFilter('status', Status::STATUS_DISABLED)
            ->addAttributeToFilter('ts24_beny', 1);
        return $productCollection->getColumnValues('sku');
    }
}
