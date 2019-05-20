<?php

namespace AppBundle\Importer\Course;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Structure;
use AppBundle\Exception\StructureNotFoundException;
use AppBundle\Exception\YearNotFoundException;
use AppBundle\Importer\Common\AbstractImporterCommand;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseRepositoryInterface;
use AppBundle\Repository\StructureRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseCollection;
use UniceSIL\SyllabusImporterToolkit\Course\CourseImporterInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInfoInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInterface;
use UniceSIL\SyllabusImporterToolkit\Structure\StructureInterface;

/**
 * Class CourseImporterCommand
 * @package AppBundle\Importer
 */
class CourseImporterCommand extends AbstractImporterCommand
{
    /**
     * @var string
     */
    protected static $defaultName = "syllabus:importer:course";

    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var StructureRepositoryInterface
     */
    private $structureRepository;


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
        $this->courseRepository = $courseRepository;
        $this->courseInfoRepository = $courseInfoRepository;
        $this->yearRepository =$yearRepository;
        $this->structureRepository = $structureRepository;
        parent::__construct($container, $yearRepository, $logger);
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
        parent::configure();
    }

    /**
     *
     */
    protected function start()
    {
        if(!$this->importerService instanceof CourseImporterInterface){
            throw new \Exception(sprintf("Service %s must implement %s", $this->importerServiceName, CourseImporterInterface::class));
        }
        $this->importerService->setArgs($this->importerServiceArgs);
        // Get years to import
        $years = $this->getYearsToImport();
        // Get courses to import
        $courses = $this->getCoursesToImport($years);
        // Start import courses
        $this->startImport($courses);
    }

    /**
     * @param array $years
     * @return CourseCollection
     */
    private function getCoursesToImport(array $years=[]): CourseCollection
    {
        $courses = $this->importerService->setYears($years)->execute();
        $this->output->writeln(sprintf("%d courses to import", $courses->count()));
        return $courses;
    }

    /**
     * @param CourseCollection $courses
     */
    private function startImport(CourseCollection $courses): void
    {
        $course = null;
        foreach ($courses as $key => $course) {
            $this->courseRepository->beginTransaction();
            try {
                // Prepare course
                $course = $this->prepareCourse($course);
                if ($course instanceof Course) {
                    $this->courseRepository->update($course);
                }
                $this->courseRepository->commit();
                $this->courseRepository->detach($course);
                $this->courseRepository->clear();
            } catch (\Exception $e) {
                $this->logger->error((string)$e);
                $this->courseRepository->rollback();
                $this->output->writeln($e->getMessage());
            }finally{
                unset($course);
                unset($courses[$key]);
            }
        }
    }

    /**
     * @param CourseInterface $c
     * @return Course|null
     */
    private function prepareCourse(CourseInterface $c): ?Course
    {
        $this->output->writeln(sprintf("Import course %s (%d KB used)", $c->getEtbId(), (memory_get_usage()/1024)));

        // COURSE
        // Retrieve course in Syllabus by establishment id
        $course = $this->courseRepository->findByEtbId($c->getEtbId());
        // If course not exist in Syllabus and if createCourseIfNotExist is true then instantiate new course
        if(is_null($course)) {
            if($c->createIfNotExist() == false){
                return null;
            }
            // Init new course
            $course = new Course();
            $course->setId(Uuid::uuid4());
        }
        $course->setEtbId($c->getEtbId())
            ->setType($c->getType());

        // COURSE INFO
        $courseInfo = null;
        foreach ($c->getCourseInfos() as $courseInfo){
            $courseInfo = $this->prepareCourseInfo($courseInfo, $course);
            if($courseInfo instanceof CourseInfo){
                $course->removeCourseInfo($courseInfo);
                $course->addCourseInfo($courseInfo);
            }
        }

        // COURSE PARENTS
        $course->setParents(new ArrayCollection());
        $courseParent = null;
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
        $year = null;
        $oldCourseInfo = null;
        $structure = null;
        $courseInfo = null;
        try {
            // Get year
            $year = $this->yearRepository->find($ci->getYearId());
            if (is_null($year)) {
                throw new YearNotFoundException(sprintf("Cannot import info, year %s does not exist", $ci->getYearId()));
            }

            // Get structure
            $structure = $this->prepareStructure($ci->getStructure());

            // Get course info for year
            $courseInfo = $this->courseInfoRepository->findByEtbIdAndYear($course->getEtbId(), $ci->getYearId());
            // If course info not exist create new instance
            if (is_null($courseInfo)) {
                $oldCourseInfo = $course->getCourseInfos()->last();
                if($oldCourseInfo instanceof CourseInfo){
                    $courseInfo = clone $oldCourseInfo;
                }else{
                    $courseInfo = new CourseInfo();
                }
                $courseInfo->setId(Uuid::uuid4())
                    ->setYear($year)
                    ->setPublisher(null)
                    ->setPublicationDate(null)
                    ->setLastUpdater(null)
                    ->setModificationDate(null)
                    ->setTemPresentationTabValid(false)
                    ->setTemActivitiesTabValid(false)
                    ->setTemObjectivesTabValid(false)
                    ->setTemMccTabValid(false)
                    ->setTemInfosTabValid(false)
                    ->setTemEquipmentsTabValid(false)
                    ->setTemClosingRemarksTabValid(false)
                    ->setCreationDate(new \DateTime());
            }

            $courseInfo->setCourse($course)
                ->setTitle($ci->getTitle())
                ->setStructure($structure)
                ->setPeriod($ci->getPeriod())
                ->setDomain($ci->getDomain())
                ->setEcts($ci->getEcts())
                ->setTeachingCmClass($ci->getTeachingCmClass())
                ->setTeachingTdClass($ci->getTeachingTdClass())
                ->setTeachingTpClass($ci->getTeachingTpClass());

            return $courseInfo;
        }catch (YearNotFoundException | StructureNotFoundException $e){
            $this->output->writeln($e->getMessage());
        }finally{
            unset($oldCourseInfo);
        }
        return null;
    }

    /**
     * @param StructureInterface $s
     * @return Structure
     * @throws StructureNotFoundException
     */
    private function prepareStructure(StructureInterface $s): Structure
    {
        $structure = $this->structureRepository->findByEtbId($s->getEtbId());
        if (is_null($structure)) {
            if($s->createIfNotExist()){
                $structure = new Structure();
                $structure->setId(Uuid::uuid4())
                    ->setEtbId($s->getEtbId())
                    ->setLabel($s->getLabel());
                $this->structureRepository->update($structure);
            }else{
                throw new StructureNotFoundException(sprintf("Cannot import info, structure %s does not exist", $s->getEtbId()));
            }
        }
        return $structure;
    }

}