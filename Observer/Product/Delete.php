<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mediarox\BenyReprice\Api\Data\ConfigInterface;
use Mediarox\BenyReprice\Model\DeleteProducts;
use Psr\Log\LoggerInterface;

/**
 * Class Delete
 *
 * Execute delete request in case of event catalog_product_delete_after_done.
 */
class Delete implements ObserverInterface
{
    /**
     * @var DeleteProducts
     */
    private $delete;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Delete constructor.
     *
     * @param DeleteProducts  $delete
     * @param LoggerInterface $logger
     * @param ConfigInterface $config
     */
    public function __construct(DeleteProducts $delete, LoggerInterface $logger, ConfigInterface $config)
    {
        $this->delete = $delete;
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        if ($this->config->getDeleteProduct()) {
            $product = $observer->getData('product');
            $productSku = $product->getData('sku');
            try {
                $response = $this->delete->deleteFromBeny([$productSku]);
                $this->logger->debug('Deleted product from Beny: ' . $response->getContent());
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}
