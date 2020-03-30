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
 * Class CriticalHandler
 *
 * Provides alternative log file for critical messages.
 */
class CriticalHandler extends Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = Logger::CRITICAL;
    /**
     * logfile name
     *
     * @var string
     */
    protected $fileName = 'var/log/beny_reprice/exception.log';
}
