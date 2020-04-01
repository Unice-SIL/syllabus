<?php


namespace AppBundle\Command\Import;

use AppBundle\Entity\Structure;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Import\Configuration\StructureApogeeConfiguration;
use AppBundle\Import\ImportManager;
use AppBundle\Manager\StructureManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApogeeStructureImportCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import:apogee:structure';
    /**
     * @var ImportManager
     */
    private $importManager;
    /**
     * @var StructureApogeeConfiguration
     */
    private $configuration;
    /**
     * @var StructureManager
     */
    private $structureManager;

    /**
     * ImportTestCommand constructor.
     * @param ImportManager $importManager
     * @param StructureApogeeConfiguration $configuration
     * @param StructureManager $structureManager
     */
    public function __construct(
        ImportManager $importManager,
        StructureApogeeConfiguration $configuration,
        StructureManager $structureManager
    )
    {
        parent::__construct();
        $this->importManager = $importManager;
        $this->configuration = $configuration;
        $this->structureManager = $structureManager;
    }

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Apogee Structure import');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parsingReport = ReportingHelper::createReport('Parsing');
        $fieldsAllowed = iterator_to_array($this->configuration->getMatching()->getCompleteMatching());
        $fieldsToUpdate = array_keys($fieldsAllowed);

        $structures = $this->importManager->parseFromConfig($this->configuration, $parsingReport);

        $validationReport = ReportingHelper::createReport('Insertion en base de données');

        /**
         * @var Structure $structure
         */
        foreach ($structures as $lineIdReport => $structure) {
            $structure->setSource('apogee');

            $this->structureManager->updateIfExistsOrCreate($structure, $fieldsToUpdate, [
                'find_by_parameters' => [
                    'code' => $structure->getCode(),
                ],
                'flush' => true,
                'lineIdReport' => $lineIdReport,
                'report' => $validationReport,
                'validations_groups_new' => ['Default'],
                'validations_groups_edit' => ['Default'],
            ]);

        }

    }
}
