<?php
/**
 * @package   Mediarox_BenyReprice
 * @copyright Copyright 2020 (c) mediarox UG (haftungsbeschraenkt) (http://www.mediarox.de)
 * @author    Marcus Bernt <mbernt@mediarox.de>
 */

namespace Mediarox\BenyReprice\Console\Command;

use Mediarox\BenyReprice\Cron\DeleteOld;
use Mediarox\BenyReprice\Cron\Export;
use Mediarox\BenyReprice\Cron\Import;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends Command
{
    protected DeleteOld $deleteOld;
    /**
     * @var Import
     */
    private $import;
    /**
     * @var Export
     */
    private $export;


    public function __construct(Import $import, Export $export, DeleteOld $deleteOld, string $name = null)
    {
        parent::__construct($name);
        $this->import = $import;
        $this->export = $export;
        $this->deleteOld = $deleteOld;
    }

    protected function configure()
    {
        $this->setDescription('Test command for debugging.');
        $this->setName('mediarox:beny-reprice:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->export->execute();
        $this->import->execute();
        $this->deleteOld->execute();
    }
}
