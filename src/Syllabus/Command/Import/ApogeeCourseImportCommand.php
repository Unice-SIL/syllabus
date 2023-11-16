<?php


namespace App\Syllabus\Command\Import;


use App\Syllabus\Command\Scheduler\AbstractJob;
use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Entity\Teaching;
use App\Syllabus\Entity\Year;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportingHelper;
use App\Syllabus\Import\Configuration\CourseApogeeConfiguration;
use App\Syllabus\Import\Configuration\CourseParentApogeeConfiguration;
use App\Syllabus\Import\Configuration\HourApogeeConfiguration;
use App\Syllabus\Import\ImportManager;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\CourseManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;


class ApogeeCourseImportCommand extends AbstractJob
{
    protected static $defaultName = 'app:import:apogee:course';
    /**
     * @var Year[]
     */
    private static $yearsToImport;
    /**
     * @var Structure[]
     */
    private $structures = [];
    /**
     * @var Course[]
     */
    private $handledParents = [];
    /**
     * @var ImportManager
     */
    private $importManager;
    /**
     * @var CourseApogeeConfiguration
     */
    private $configuration;
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var CourseManager
     */
    private $courseManager;
    /**
     * @var CourseInfoManager
     */
    private $courseInfoManager;
    /**
     * @var CourseParentApogeeConfiguration
     */
    private $parentConfiguration;
    /**
     * @var HourApogeeConfiguration
     */
    private $hourApogeeConfiguration;
    /**
     * @var Report
     */
    private $report;


    const SOURCE = 'apogee';

    /**
     * ApogeeCourseImportCommand constructor.
     * @param ImportManager $importManager
     * @param CourseApogeeConfiguration $configuration
     * @param CourseParentApogeeConfiguration $parentConfiguration
     * @param HourApogeeConfiguration $hourApogeeConfiguration
     * @param EntityManagerInterface $em
     * @param CourseManager $courseManager
     * @param CourseInfoManager $courseInfoManager
     */
    public function __construct(
        ImportManager $importManager,
        CourseApogeeConfiguration $configuration,
        CourseParentApogeeConfiguration $parentConfiguration,
        HourApogeeConfiguration $hourApogeeConfiguration,
        EntityManagerInterface $em,
        CourseManager $courseManager,
        CourseInfoManager $courseInfoManager
    )
    {
        parent::__construct($em);
        $this->importManager = $importManager;
        $this->configuration = $configuration;
        $this->parentConfiguration = $parentConfiguration;
        $this->hourApogeeConfiguration = $hourApogeeConfiguration;
        $this->em = $em;
        $this->courseManager = $courseManager;
        $this->courseInfoManager = $courseInfoManager;
        $this->report = ReportingHelper::createReport();
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
     * @return Report|mixed
     * @throws Exception
     */
    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        $loopBreak = 75;
        //======================End Perf==================

        $fieldsAllowed = iterator_to_array($this->configuration->getMatching()->getCompleteMatching());
        $fieldsToUpdate = array_keys($fieldsAllowed);
        $fieldsToUpdate[] = 'source';

        $courses = $this->importManager->parseFromConfig($this->configuration, $this->report, ['allow_extra_field' => true]);

        //$validationReport = ReportingHelper::createReport('Insertion en base de données');

        $loop = 1;
        $memStart = 0;

        /** @var Course $course */
        foreach ($courses as $lineIdReport => $course) {

            //======================Perf==================
            if ($loop % $loopBreak === 1) {
                $timeStart = microtime(true);
                $memStart = memory_get_usage();
            }
            //======================End Perf==================

            dump('Import info course ' . $course->getCode());

            try {

                if (!self::$yearsToImport) {
                    self::$yearsToImport = $this->em->getRepository(Year::class)->findByImport(true);
                }

                if ($this->getStructure($course->getStructureCode()) instanceof Structure) {
                    $course->setSynchronized(true);
                    $course = $this->courseManager->updateIfExistsOrCreate($course, $fieldsToUpdate, [
                        'flush' => false,
                        'find_by_parameters' => [
                            'code' => $course->getCode(),
                        ],
                        'lineIdReport' => $lineIdReport,
                        'report' => $this->report,
                        'validations_groups_new' => ['Default'],
                        'validations_groups_edit' => ['Default']
                    ]);
                    if (!$course->isSynchronized()) {
                        $this->em->refresh($course);
                        continue;
                    }
                    $course->setSource(self::SOURCE);

                    //$this->em->flush();

                    //$parsingParentReport = ReportingHelper::createReport('Parsing');
                    $parents = $this->importManager->parseFromConfig($this->parentConfiguration, $this->report, [
                        'allow_extra_field' => true,
                        'extractor' => [
                            'filter' => [
                                'code' => $course->getCode()
                            ]
                        ]
                    ]);


                    //$parentValidationReport = ReportingHelper::createReport('Insertion en base de données');
                    // Important remove all parents before add news
                    foreach ($course->getParents() as $parent) {
                        $course->removeParent($parent);
                    }
                    /**
                     * @var Course $parent
                     */
                    foreach ($parents as $parentLineIdReport => $parent) {

                        if (!$this->getStructure($parent->getStructureCode()) instanceof Structure) {
                            continue;
                        }

                        if (!in_array($parent->getCode(), $this->handledParents)) {
                            $parent->setSynchronized(true);
                            $parent = $this->courseManager->updateIfExistsOrCreate($parent, $fieldsToUpdate, [
                                'find_by_parameters' => [
                                    'code' => $parent->getCode(),
                                ],

                                'lineIdReport' => $parentLineIdReport,
                                'report' => $this->report,
                                'validations_groups_new' => ['Default'],
                                'validations_groups_edit' => ['Default'],
                            ]);
                            if (!$parent->isSynchronized()) {
                                $this->em->refresh($parent);
                                continue;
                            }
                            $parent->setSource(self::SOURCE);

                            $this->setCourseInfos($parent);
                            $this->handledParents[] = $parent->getCode();
                        } else {
                            $parent = $this->em->getRepository(Course::class)->findOneBy(['code' => $parent->getCode()]);
                        }

                        $course->addParent($parent);
                    }

                    /** @var CourseInfo $courseInfo */
                    $this->setCourseInfos($course);

                    // Important ne pas déplacer
                    $this->em->flush();
                }
            }catch (Throwable $e) {
                dump($e->getMessage());
            }

            if ($loop % $loopBreak === 0) {
                $progress = round(($loop / count($courses)) * 100);
                $this->progress($progress);
                $this->memoryUsed(memory_get_usage(), true);

                $this->em->clear();
                self::$yearsToImport = null;
                $this->structures = [];

                //======================Perf==================

                $interval[$loop]['time'] = microtime(true) - $timeStart . ' s';
                $interval[$loop]['memory'] = round((memory_get_usage() - $memStart)/1048576, 2) . ' MB';
                $interval[$loop]['progress'] = $progress . '%';
                dump($interval[$loop]);
                //======================End Perf==================
            }

            $loop++;
        }

        //======================Perf==================
        dump( $interval, microtime(true) - $start . ' s');
        //======================End Perf==================

        //return $this->report;

    }

    private function setCourseInfos(Course $course)
    {
        //$hours = $course->getHours();
        $ects = $course->getEcts();

        $structure = $this->getStructure($course->getStructureCode());
        if(!$structure instanceof Structure)
        {
            return;
        }

        foreach (self::$yearsToImport as $year) {
            $courseInfo = $this->courseInfoManager->new();
            $courseInfo->setTitle($course->getTitle());
            $courseInfo->setYear($year);
            $courseInfo->setEcts($ects);
            $courseInfo->setStructure($structure);
            $courseInfo->setCourse($course);

            /** @var Teaching[] $teachings */
            $teachings = $this->importManager->parseFromConfig($this->hourApogeeConfiguration, $this->report, [
                ['allow_extra_field' => true],
                'extractor' => [
                    'filter' => [
                        'code' => $course->getCode(),
                        'year' => $year->getId(),
                    ]
                ]
            ]);

            foreach ($teachings as $teaching) {
                switch ($teaching->getType()) {
                    case 'CM':
                        $courseInfo->setTeachingCmClass($teaching->getHourlyVolume());
                        break;
                    case 'TD':
                        $courseInfo->setTeachingTdClass($teaching->getHourlyVolume());
                        break;
                    case 'TP':
                        $courseInfo->setTeachingTpClass($teaching->getHourlyVolume());
                        break;
                }
            }

            $this->courseInfoManager->updateIfExistsOrCreate($courseInfo, ['title', 'year', 'ects', 'structure', 'teachingCmClass', 'teachingTdClass', 'teachingTpClass', 'course'], [
                'find_by_parameters' => [
                    'course' => $course,
                    'year' => $year
                ],
            ]);

        }

    }

    /**
     * @param $code
     * @return Structure|null
     */
    private function getStructure($code)
    {
        $structure = null;
        if(in_array($code, $this->structures)) {
            return $this->structures[$code];
        }

        /** @var Structure $structure */
        $structure =$this->em->getRepository(Structure::class)->findOneByCode($code);
        if($structure instanceof Structure)
        {
            $this->structures[$structure->getCode()] = $structure;
            return $structure;
        }
        return null;
    }
}