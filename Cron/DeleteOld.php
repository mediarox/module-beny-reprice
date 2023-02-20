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
        if ($this->config->getEnableCron()) {
            $collection = $this->getProductsToDelete();
            $collection->setPageSize(200);
            $lastPage = $collection->getLastPageNumber();
            $currentPage = 1;
            while ($currentPage <= $lastPage) {
                $collection->setCurPage($currentPage);
                $skus = $collection->getColumnValues('sku');
                $this->deleteProducts->deleteFromBeny($skus);
                $currentPage++;
            }
        }
    }

    public function getProductsToDelete(): Collection
    {
        /** @var Collection $productCollection */
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToFilter('status', Status::STATUS_DISABLED);
        return $productCollection;
    }
}
