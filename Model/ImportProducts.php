<?php
/**
 * @package   Mediarox_BenyExport
 * @copyright Copyright 2019 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Model;

use Laminas\Http\ClientFactory;
use Laminas\Http\Headers;
use Laminas\Http\Request;
use Laminas\Stdlib\Parameters;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Mediarox\BenyReprice\Model\System\Config;
use Psr\Log\LoggerInterface;

/**
 * Class ImportProducts
 *
 * Exports products to Beny.
 */
class ImportProducts extends Api
{
    private const EXPORT_FILE_PATH = 'feeds/beny.csv';
    /**
     * @var DirectoryList
     */
    private DirectoryList $directoryList;
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * ImportProducts constructor.
     *
     * @param Config          $config
     * @param UrlInterface    $url
     * @param ClientFactory   $client
     * @param Request         $request
     * @param Parameters      $parameters
     * @param Headers         $headers
     * @param LoggerInterface $logger
     * @param DirectoryList   $directoryList
     * @param Filesystem      $filesystem
     */
    public function __construct(
        Config $config,
        UrlInterface $url,
        ClientFactory $client,
        Request $request,
        Parameters $parameters,
        Headers $headers,
        LoggerInterface $logger,
        DirectoryList $directoryList,
        Filesystem $filesystem
    ) {
        parent::__construct($config, $url, $client, $request, $parameters, $headers, $logger);
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
    }

    /**
     * Import products into Beny database.
     *
     * @throws FileSystemException
     */
    public function import(): \Laminas\Http\Response
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
    protected function getExportParams(): array
    {
        $params = [
            'keepold' => $this->config->getKeepOld(),
            'lineend' => $this->config->getLineEnd(),
            'seperator' => $this->config->getSeperator(),
        ];

        if ($getStatus = $this->config->getGetStatus()) {
            $params['get_status'] = $getStatus;
        }

        return $params;
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
        if ($path) {
            $directoryRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
            $fileContent = $directoryRead->readFile($path);
        } else {
            $directoryRead = $this->filesystem->getDirectoryRead(DirectoryList::PUB);
            $fileContent = $directoryRead->readFile(self::EXPORT_FILE_PATH);
        }
        return utf8_encode($fileContent);
    }

    /**
     * Return absolute file path.
     *
     * @return false|string
     */
    protected function getExportFilePath()
    {
        $directoryRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $filePath = $directoryRead->getAbsolutePath(self::BENY_API_UPLOAD_DIR) .
            DIRECTORY_SEPARATOR .
            $this->config->getFileUpload();
        return $this->config->getFileUpload() ? $filePath : false;
    }
}
