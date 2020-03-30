<?php
/**
 * @package   Mediarox_BenyExport
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;
use Zend\Http\ClientFactory;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class ImportProducts
 *
 * Exports products to Beny.
 */
class ImportProducts extends Api
{
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Export constructor.
     *
     * @param System\Config   $config
     * @param UrlInterface    $url
     * @param Request         $request
     * @param Parameters      $parameters
     * @param Headers         $headers
     * @param ClientFactory   $client
     * @param DirectoryList   $directoryList
     * @param Filesystem      $filesystem
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $config,
        UrlInterface $url,
        Request $request,
        Parameters $parameters,
        Headers $headers,
        ClientFactory $client,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        LoggerInterface $logger
    ) {
        parent::__construct($config, $url, $request, $parameters, $client, $headers, $logger);
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
    }

    /**
     * Import products into Beny database.
     *
     * @throws FileSystemException
     */
    public function import()
    {
        $uri = $this->getApiUri(self::BENY_API_IMPORT_PRODUCTS);
        $requestContent = $this->getExportFileContent();
        $headers = $this->headers->addHeaders(['Content-Type' => 'text/csv']);
        $parameters = $this->getExportParams();
        $method = Request::METHOD_POST;

        return $this->sendRequest($uri, $requestContent, $method, $headers, $parameters);
    }

    /**
     * @return array
     */
    protected function getExportParams()
    {
        return [
            'keepold' => $this->config->getKeepOld(),
            'lineend' => $this->config->getLineEnd(),
            'seperator' => $this->config->getSeperator(),
        ];
    }

    /**
     * Return csv-file content.
     *
     * @return false|string
     * @throws FileSystemException
     */
    protected function getExportFileContent()
    {
        $path = $this->getExportFilePath();
        $directoryRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $fileContent = $directoryRead->readFile($path);
        return utf8_encode(($fileContent));
    }

    /**
     * Return absolute file path.
     *
     * @return false|string
     */
    protected function getExportFilePath()
    {
        $directoryRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        return $directoryRead->getAbsolutePath(self::BENY_API_UPLOAD_DIR) .
            DIRECTORY_SEPARATOR .
            $this->config->getFileUpload();
    }
}
