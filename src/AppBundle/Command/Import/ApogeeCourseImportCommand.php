<?php


namespace AppBundle\Command\Import;


use AppBundle\Entity\Course;
use AppBundle\Entity\Structure;
use AppBundle\Entity\Year;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Import\Configuration\CourseApogeeConfiguration;
use AppBundle\Import\Configuration\CourseParentApogeeConfiguration;
use AppBundle\Import\ImportManager;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ApogeeCourseImportCommand extends Command
{
    private static $yearsToImport;

    protected static $defaultName = 'app:import:apogee:course';

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
    private $em;
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
     * ImportTestCommand constructor.
     * @param ImportManager $importManager
     * @param CourseApogeeConfiguration $configuration
     * @param EntityManagerInterface $em
     * @param CourseManager $courseManager
     * @param CourseInfoManager $courseInfoManager
     */
    public function __construct(
        ImportManager $importManager,
        CourseApogeeConfiguration $configuration,
        CourseParentApogeeConfiguration $parentConfiguration,
        EntityManagerInterface $em,
        CourseManager $courseManager,
        CourseInfoManager $courseInfoManager
    )
    {
        parent::__construct();
        $this->importManager = $importManager;
        $this->configuration = $configuration;
        $this->parentConfiguration = $parentConfiguration;
        $this->em = $em;
        $this->courseManager = $courseManager;
        $this->courseInfoManager = $courseInfoManager;
    }

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Apogee Structure import');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        $loopBreak = 200;
        //======================End Perf==================

        $fieldsAllowed = iterator_to_array($this->configuration->getMatching()->getCompleteMatching());
        $fieldsToUpdate = array_keys($fieldsAllowed);
        $fieldsToUpdate[] = 'source';

        $parsingReport = ReportingHelper::createReport('Parsing');

        $courses = $this->importManager->parseFromConfig($this->configuration, $parsingReport, ['allow_extra_field' => true]);

        $validationReport = ReportingHelper::createReport('Insertion en base de données');

        $loop = 1;
        /** @var Course $course */
        foreach ($courses as $lineIdReport => $course) {

            //======================Perf==================
            if ($loop % $loopBreak === 1) {
                $timeStart = microtime(true);
            }
            //======================End Perf==================

            if (!self::$yearsToImport) {
                self::$yearsToImport = $this->em->getRepository(Year::class)->findByImport(true);
            }

            $course->setSource('apogee');

            $course = $this->courseManager->updateIfExistsOrCreate($course, $fieldsToUpdate, [
                'flush' => true,
                'find_by_parameters' => [
                    'code' => $course->getCode(),
                ],
                'lineIdReport' => $lineIdReport,
                'report' => $validationReport,
                'validations_groups_new' => ['Default'],
                'validations_groups_edit' => ['Default']
            ]);

            $parsingParentReport = ReportingHelper::createReport('Parsing');
            $parents = $this->importManager->parseFromConfig($this->parentConfiguration, $parsingParentReport, [
                'allow_extra_field' => true,
                'extractor' => [
                    'filter' => [
                        'code' => $course->getCode()
                    ]
                ]
            ]);

            $parentValidationReport = ReportingHelper::createReport('Insertion en base de données');
            $course->setParents(new ArrayCollection());
            /**
             * @var Course $parent
             */
            foreach ($parents as $parentLineIdReport => $parent) {
                $parent->setSource('apogee');

                $parent = $this->courseManager->updateIfExistsOrCreate($parent, $fieldsToUpdate, [
                    'find_by_parameters' => [
                        'code' => $parent->getCode(),
                    ],

                    'lineIdReport' => $parentLineIdReport,
                    'report' => $parentValidationReport,
                    'validations_groups_new' => ['Default'],
                    'validations_groups_edit' => ['Default'],
                ]);

                $course->addParent($parent);

                $this->setCourseInfos($parent);
            }

            $this->setCourseInfos($course);

            $this->em->flush();

            if ($loop % $loopBreak === 0) {

                $this->em->clear();
                self::$yearsToImport = null;

            //======================Perf==================

                $interval[$loop] = microtime(true) - $timeStart . ' s';
                dump($interval);
            //======================End Perf==================
            }

            $loop++;

        }

        //======================Perf==================
        dump( $interval, microtime(true) - $start . ' s');
        //======================End Perf==================

        return;

        /**
         * Import courses
         *
         * SQL
         * select elp.* from element_pedagogi elp
         *  where elp.cod_elp not in (select ere.cod_elp_pere from elp_regroupe_elp ere where ere.cod_elp_pere = elp.cod_elp)
         *  and elp.eta_elp = 'O'
         *  and elp.tem_sus_elp = 'N'
         *  and elp.cod_nel in ('UE', 'ECUE')
         *  and elp.cod_elp='SLEPB111';
         *
         * MAPPING
         * cod_elp => course->code
         * cod_cmp => course_info->structure->code
         * cod_nel => course->type
         * lib_elp => course->title && course_info->title
         * nbr_crd_elp => course_info->ects
         */

        $course1 = [
            'cod_elp' => 'CODELP1',
            'cod_cmp' => 'SCI',
            'cod_nel' => 'ECUE',
            'lib_elp' => 'Course import 1',
            'nbr_crd_elp' => null
        ];
        $courses = [$course1];


        /**
         * Import parents courses
         *
         * SQL
         * select elp.* from element_pedagogi elp
         *  inner join elp_regroupe_elp ere on (ere.cod_elp_pere = elp.cod_elp)
         *  where ere.cod_elp_fils = $codElpFils
         *  and ere.eta_elp_fils = 'O' and ere.eta_elp_pere = 'O'
         *  and ere.tem_sus_elp_fils = 'N' and ere.tem_sus_elp_pere = 'N'
         *  and elp.eta_elp = 'O' and elp.tem_sus_elp = 'N'
         *  and elp.cod_nel in ('UE', 'ECUE');
         *
         * MAPPING
         * cod_elp => course->code
         * cod_cmp => course_info->structure->code
         * cod_nel => course->type
         * lib_elp => course->title && course_info->title
         * nbr_crd_elp => course_info->ects
         */
        $parent1 = [
            'cod_elp' => 'CODELP1',
            'cod_cmp' => 'SCI',
            'cod_nel' => 'ECUE',
            'lib_elp' => 'Course import 1',
            'nbr_crd_elp' => null
        ];
        /**
         * Add children code as key to retrieves the parents for test
         */
        $parents = [
             $course1['cod_elp'] => [$parent1]
        ];


        /**
         * Import teaching hours for syllabus
         *
         * SQL
         * select * from elp_chg_typ_heu ecth
         *  where ecth.cod_elp = $code
         *  and cod_anu = $year;
         *
         * MAPPING
         * nbr_heu_elp => course_info->teachingCmClass | course_info->teachingTdClass | course_info->teachingTpClass
         */
        $hour1 = [
            [
                'cod_typ_heu' => 'CM',
                'nbr_heu_elp' => 4
            ],
            [
                'cod_typ_heu' => 'TD',
                'nbr_heu_elp' => 6
            ],
            [
                'cod_typ_heu' => 'TP',
                'nbr_heu_elp' => 8
            ]
        ];
        /**
         * Add course code as key to retrieves the teaching hours for test
         */
        $hours = [
            $course1['cod_elp'] => $hour1
        ];

    }

    private function setCourseInfos(Course $course)
    {
        $hours = $course->getHours();
        $ects = $course->getEcts();
        $structureCode = $course->getStructureCode();
        $structure =$this->em->getRepository(Structure::class)->findOneByCode($structureCode);

        if ($structure instanceof Structure) {

            foreach (self::$yearsToImport as $year) {
                $courseInfo = $this->courseInfoManager->new();
                $courseInfo->setTitle($course->getTitle());
                $courseInfo->setYear($year);
                $courseInfo->setEcts($ects);
                $courseInfo->setStructure($structure);
                $courseInfo->setCourse($course);

                foreach ($hours as $hour) {
                    switch ($hour['cod_typ_heu']) {
                        case 'CM':
                            $courseInfo->setTeachingCmClass($hour['nbr_heu_elp']);
                            break;
                        case 'TD':
                            $courseInfo->setTeachingTdClass($hour['nbr_heu_elp']);
                            break;
                        case 'TP':
                            $courseInfo->setTeachingTpClass($hour['nbr_heu_elp']);
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
    }
}