<?php

namespace AppBundle\Importer\Course;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\StructureNotFoundException;
use AppBundle\Exception\YearNotFoundException;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseRepositoryInterface;
use AppBundle\Repository\StructureRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseCollection;
use UniceSIL\SyllabusImporterToolkit\Course\CourseImporterInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInfoCollection;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInfoInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInterface;

/**
 * Class CourseImporterCommand
 * @package AppBundle\Importer
 */
class CourseImporterCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = "syllabus:importer:course";

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var YearRepositoryInterface
     */
    private $yearRepository;

    /**
     * @var StructureRepositoryInterface
     */
    private $structureRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * CourseImporterCommand constructor.
     * @param ContainerInterface $container
     * @param CourseRepositoryInterface $courseRepository
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param YearRepositoryInterface $yearRepository
     * @param StructureRepositoryInterface $structureRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContainerInterface $container,
        CourseRepositoryInterface $courseRepository,
        CourseInfoRepositoryInterface $courseInfoRepository,
        YearRepositoryInterface $yearRepository,
        StructureRepositoryInterface $structureRepository,
        LoggerInterface $logger
    )
    {
        $this->container = $container;
        $this->courseRepository = $courseRepository;
        $this->courseInfoRepository = $courseInfoRepository;
        $this->yearRepository =$yearRepository;
        $this->structureRepository = $structureRepository;
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription("Import Course in Syllabus from external repository")
            ->setHelp(
                "This command allow you to import course ins Syllabus from external repository"
            )
            ->addArgument('service', InputArgument::REQUIRED, 'Course importer service name to use');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        try {
            $output->writeln("==============================");
            $output->writeln("Start course importer");
            $output->writeln("==============================");


            // Get CourseImporter service
            $courseImporterServiceName = $input->getArgument('service');
            $output->writeln(sprintf("Get service %s", $courseImporterServiceName));
            $courseImporterServiceName = $input->getArgument('service');
            $courseImporter = $this->container->get($courseImporterServiceName);
            if (!$courseImporter instanceof CourseImporterInterface) {
                throw new \Exception(
                    sprintf("Service %s must implement %s", $courseImporterServiceName, CourseImporterInterface::class)
                );
            }

            // Get courses to import
            $courses = $this->getCoursesToImport($courseImporter);

            // Start courses import
            $this->startImport($courses);


        }catch (\Exception $e){
            $this->logger->error((string)$e);
            $output->writeln($e->getMessage());
        }
        $output->writeln("==============================");
        $output->writeln("End course importer");
        $output->writeln("==============================");
    }

    /**
     * @param CourseImporterInterface $courseImporter
     * @return CourseCollection
     */
    private function getCoursesToImport(CourseImporterInterface $courseImporter): CourseCollection
    {
        $years = $this->getYearsToImport();
        $courses = $courseImporter->setYears($years)->execute();
        $this->output->writeln(sprintf("%d courses to import", $courses->count()));
        return $courses;
    }

    /**
     * @return array
     */
    private function getYearsToImport(): array
    {
        $years = $this->yearRepository->findToImport();
        return $years->toArray();
    }

    /**
     * @param CourseCollection $courses
     */
    private function startImport(CourseCollection $courses): void
    {
        foreach ($courses as $course) {
            //if($course->getEtbId()!=="SLEPB111") continue;
            try {
                $this->courseRepository->beginTransaction();
                // Prepare course
                $course = $this->prepareCourse($course);
                if ($course instanceof Course) {
                    $this->courseRepository->update($course);
                }
                $this->courseRepository->commit();
            } catch (\Exception $e) {
                $this->courseRepository->rollback();
                $this->logger->error((string)$e);
                $this->output->writeln($e->getMessage());
            }
        }
    }

    /**
     * @param CourseInterface $c
     * @return Course|null
     */
    private function prepareCourse(CourseInterface $c): ?Course
    {
        $this->output->writeln(sprintf("Import course %s", $c->getEtbId()));

        // COURSE
        // Retrieve course in Syllabus by establishment id
        $course = $this->courseRepository->findByEtbId($c->getEtbId());
        // If course not exist in Syllabus and if createCourseIfNotExist is true then instantiate new course
        if(is_null($course)) {
            if($c->createCourseIfNotExist() == false){
                return null;
            }
            // Init new course
            $course = new Course();
            $course->setId(Uuid::uuid4());
        }
        $course->setEtbId($c->getEtbId())
            ->setType($c->getType());

        // COURSE INFO
        foreach ($c->getCourseInfos() as $courseInfo){
            $courseInfo = $this->prepareCourseInfo($courseInfo, $course);
            if($courseInfo instanceof CourseInfo){
                $course->removeCourseInfo($courseInfo);
                $course->addCourseInfo($courseInfo);
            }
        }

        // COURSE PARENTS
        $course->setParents(new ArrayCollection());
        foreach ($c->getParents() as $courseParent) {
            // Recursive call to generate parent course
            $courseParent = $this->prepareCourse($courseParent);
            if ($courseParent instanceof Course) {
                $course->addParent($courseParent);
            }
        }

        return $course;
    }

    /**
     * @param CourseInfoInterface $ci
     * @param Course $course
     * @return CourseInfo|null
     * @throws StructureNotFoundException
     */
    private function prepareCourseInfo(CourseInfoInterface $ci, Course $course): ?CourseInfo
    {
        try {
            // Get year
            $year = $this->yearRepository->find($ci->getYearId());
            if (is_null($year)) {
                throw new YearNotFoundException(sprintf("Cannot import info, year %s does not exist", $ci->getYearId()));
            }

            // get structure
            $structure = $this->structureRepository->findByEtbId($ci->getStructureId());
            if (is_null($structure)) {
                throw new StructureNotFoundException(sprintf("Cannot import info, structure %s does not exist", $ci->getStructureId()));
            }

            // Get course info for year
            $courseInfo = $this->courseInfoRepository->findByEtbIdAndYear($course->getEtbId(), $ci->getYearId());
            // If course info not exist create new instance
            if (is_null($courseInfo)) {
                $courseInfo = new CourseInfo();
                $courseInfo->setId(Uuid::uuid4())
                    ->setYear($year)
                    ->setCreationDate(new \DateTime());
            }

            $courseInfo->setCourse($course)
                ->setTitle($ci->getTitle())
                ->setStructure($structure)
                ->setPeriod($ci->getPeriod())
                ->setDomain($ci->getDomain())
                ->setTeachingCmClass($ci->getTeachingCmClass())
                ->setTeachingTdClass($ci->getTeachingTdClass())
                ->setTeachingTpClass($ci->getTeachingTpClass());

            return $courseInfo;
        }catch (YearNotFoundException | StructureNotFoundException $e){
            $this->output->writeln($e->getMessage());
        }
        return null;
    }

}