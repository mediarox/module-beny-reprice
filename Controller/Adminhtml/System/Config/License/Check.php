<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

declare(strict_types=1);

namespace Mediarox\BenyReprice\Controller\Adminhtml\System\Config\License;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Mediarox\BenyReprice\Model\System\Config\License;

/**
 * Class Check
 *
 * Return license information.
 */
class Check implements ActionInterface
{
    /**
     * @var ResultFactory
     */
    protected ResultFactory $resultFactory;
    /**
     * @var License
     */
    private License $license;

    /**
     * Check constructor.
     *
     * @param License       $license
     * @param ResultFactory $resultFactory
     */
    public function __construct(License $license, ResultFactory $resultFactory)
    {
        $this->license = $license;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($this->license->checkLicense());
        return $resultJson;
    }
}
