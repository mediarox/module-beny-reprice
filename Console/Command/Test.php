<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Console\Command;

use Mediarox\BenyReprice\Cron\Export;
use Mediarox\BenyReprice\Cron\Import;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends Command
{
    /**
     * @var Import
     */
    private $import;
    /**
     * @var Export
     */
    private $export;

    /**
     * Test constructor.
     *
     * @param Import      $import
     * @param Export      $export
     * @param string|null $name
     */
    public function __construct(Import $import, Export $export, string $name = null)
    {
        parent::__construct($name);
        $this->import = $import;
        $this->export = $export;
    }

    protected function configure()
    {
        $this->setDescription('Test command for debugging.');
        $this->setName('mediarox:beny-reprice:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $this->export->execute();
        $this->import->execute();
    }
}
