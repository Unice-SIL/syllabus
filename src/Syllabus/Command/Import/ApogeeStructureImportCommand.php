<?php


namespace App\Syllabus\Command\Import;

use App\Syllabus\Command\Scheduler\AbstractJob;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Helper\Report\ReportingHelper;
use App\Syllabus\Import\Configuration\StructureApogeeConfiguration;
use App\Syllabus\Import\ImportManager;
use App\Syllabus\Manager\StructureManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApogeeStructureImportCommand extends AbstractJob
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

    const SOURCE = 'apogee';

    /**
     * ImportTestCommand constructor.
     * @param ImportManager $importManager
     * @param StructureApogeeConfiguration $configuration
     * @param StructureManager $structureManager
     * @param EntityManagerInterface $em
     */
    public function __construct(
        ImportManager $importManager,
        StructureApogeeConfiguration $configuration,
        StructureManager $structureManager,
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
     * @throws \Exception
     */
    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        $report = ReportingHelper::createReport();
        $fieldsAllowed = iterator_to_array($this->configuration->getMatching()->getCompleteMatching());
        $fieldsToUpdate = array_keys($fieldsAllowed);

        $structures = $this->importManager->parseFromConfig($this->configuration, $report);

        //$validationReport = ReportingHelper::createReport('Insertion en base de données');

        /**
         * @var Structure $structure
         */
        foreach ($structures as $lineIdReport => $structure) {
            $structure->setSource(self::SOURCE);

            $this->structureManager->updateIfExistsOrCreate($structure, $fieldsToUpdate, [
                'find_by_parameters' => [
                    'code' => $structure->getCode(),
                ],
                'flush' => true,
                'lineIdReport' => $lineIdReport,
                'report' => $report,
                'validations_groups_new' => ['Default'],
                'validations_groups_edit' => ['Default'],
            ]);

        }

        return $report;

    }
}
