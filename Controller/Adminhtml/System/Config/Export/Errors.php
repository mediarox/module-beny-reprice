<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Controller\Adminhtml\System\Config\Export;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Mediarox\BenyReprice\Model\System\Config\Export\Errors as ExportErrors;

/**
 * Class ExportErrors
 *
 * Prepare csv file for download.
 */
class Errors extends Action
{
    /**
     * @var ExportErrors
     */
    private $errors;
    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * ExportErrors constructor.
     *
     * @param Action\Context $context
     * @param ExportErrors   $errors
     * @param FileFactory    $fileFactory
     */
    public function __construct(Action\Context $context, ExportErrors $errors, FileFactory $fileFactory)
    {
        parent::__construct($context);
        $this->errors = $errors;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $filename = 'product_errors.csv';
        $response = $this->errors->exportErrors();
        return $this->fileFactory->create(
            $filename,
            $response->getContent(),
            DirectoryList::VAR_DIR
        );
    }
}
