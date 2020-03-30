<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class InfoHandler
 *
 * Provides alternative log file for debug messages.
 */
class DebugHandler extends Base
{
    /**
     * Log level
     *
     * @var int
     */
    protected $loggerType = Logger::INFO;
    /**
     * logfile name
     *
     * @var string
     */
    protected $fileName = 'var/log/beny_reprice/debug.log';
}
