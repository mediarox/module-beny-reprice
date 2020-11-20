<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

declare(strict_types=1);

namespace Mediarox\BenyReprice\Controller\Adminhtml\System\Config\Export;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Mediarox\BenyReprice\Model\System\Config\Export\Errors as ExportErrors;

/**
 * Class ExportErrors
 *
 * Prepare csv file for download.
 */
class Errors implements ActionInterface
{
    /**
     * @var ExportErrors
     */
    private ExportErrors $errors;
    /**
     * @var FileFactory
     */
    private FileFactory $fileFactory;

    /**
     * ExportErrors constructor.
     *
     * @param ExportErrors $errors
     * @param FileFactory  $fileFactory
     */
    public function __construct(ExportErrors $errors, FileFactory $fileFactory)
    {
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
