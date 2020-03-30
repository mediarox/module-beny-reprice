<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Controller\Adminhtml\System\Config\License;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Mediarox\BenyReprice\Model\System\Config\License;

/**
 * Class Check
 *
 * Return license information.
 */
class Check extends Action
{
    /**
     * @var License
     */
    private $license;

    /**
     * Check constructor.
     *
     * @param Action\Context $context
     * @param License        $license
     */
    public function __construct(Action\Context $context, License $license)
    {
        parent::__construct($context);
        $this->license = $license;
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
