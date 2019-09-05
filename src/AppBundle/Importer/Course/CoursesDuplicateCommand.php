<?php

namespace AppBundle\Importer\Course;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Year;
use AppBundle\Helper\FileUploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CoursesDuplicateCommand
 * @package AppBundle\Importer\Course
 */
class CoursesDuplicateCommand extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = "syllabus:duplicate:courses";

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;


    /**
     * CoursesDuplicateCommand constructor.
     * @param EntityManager $entityManager
     * @param FileUploaderHelper $fileUploaderHelper
     */
    public function __construct(
        EntityManager $entityManager,
        FileUploaderHelper $fileUploaderHelper
    )
    {
        $this->entityManager = $entityManager;
        $this->fileUploaderHelper = $fileUploaderHelper;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription("Duplicate all courses info for a year on a new year")
            ->setHelp(
                "This command allow you to duplicate Course info for a year on a new year"
            )
            ->addArgument('year', InputArgument::REQUIRED, 'Course info year to duplicate')
            ->addArgument('newyear', InputArgument::REQUIRED, 'Course info new year');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year');
        $newyear = $input->getArgument('newyear');

        $output->writeln("==============================");
        $output->writeln("Start duplication infos for all courses on a year {$year} to year {$newyear}");
        $output->writeln(date('d/m/Y H:i:s', time()));
        $output->writeln($this->getDescription());
        $output->writeln("==============================");

        try {
            $output->writeln("Retrieval all the courses for the year {$year} to duplicate");
            // Get all CourseInfo from $year
            $repo = $this->entityManager->getRepository(CourseInfo::class);
            $qb = $repo->createQueryBuilder('ci');
            $qb->select(['ci', 'c'])
                ->join('ci.year', 'y')
                ->join('ci.course', 'c')
                ->where($qb->expr()->eq('y.id', ':year'))
                ->andWhere($qb->expr()->isNotNull('ci.lastUpdater'))
                ->setParameter('year', $year);
            $coursesInfo = $qb->getQuery()->getArrayResult();
            $output->writeln(sprintf("%d courses to duplicate", count($coursesInfo)));
            // Loop on courses info
            /** @var CourseInfo $courseInfo */
            foreach ($coursesInfo as $key => $courseInfo){
                try {
                    $etbId = $courseInfo['course']['etbId'];
                    // Search if CourseInfo for new year already exist
                    $qb = $repo->createQueryBuilder('ci');
                    $qb->join('ci.course', 'c')
                        ->join('ci.year', 'y')
                        ->where($qb->expr()->eq('c.etbId', ':etbId'))
                        ->andWhere($qb->expr()->eq('y.id', ':year'))
                        ->setParameter('etbId', $etbId)
                        ->setParameter('year', $newyear);
                    $duplicateCourseInfo = $qb->getQuery()->getArrayResult();
                    if (!empty($duplicateCourseInfo)) {
                        $output->writeln("Course info for {$etbId} and year {$newyear} already exist");
                        continue;
                    }
                    $output->writeln(sprintf("Start duplicate course %s (%d KB used) :", $etbId, (memory_get_usage()/1024)));

                    $output->writeln("- Initilization");
                    // Find CourseInfo
                    $courseInfo = $this->entityManager->getRepository(CourseInfo::class)->find($courseInfo['id']);
                    $newYear = $this->entityManager->getRepository(Year::class)->find($newyear);

                    // Duplicate course
                    $duplicateCourseInfo = clone $courseInfo;
                    $duplicateCourseInfo->setId(Uuid::uuid4()->toString())
                        ->setYear($newYear)
                        ->setLastUpdater(null)
                        ->setPublisher(null)
                        ->setCreationDate(new \DateTime())
                        ->setModificationDate(null)
                        ->setPublicationDate(null)
                        ->setTemPresentationTabValid(false)
                        ->setTemActivitiesTabValid(false)
                        ->setTemObjectivesTabValid(false)
                        ->setTemMccTabValid(false)
                        ->setTemEquipmentsTabValid(false)
                        ->setTemInfosTabValid(false)
                        ->setTemClosingRemarksTabValid(false);

                    if($courseInfo->getImage())
                    {
                        $duplicateCourseInfo->setImage($this->fileUploaderHelper->copy($courseInfo->getImage()));
                    }

                    // CourseTeachers
                    $duplicateCourseTeachers = new ArrayCollection();
                    foreach ($courseInfo->getCourseTeachers() as $courseTeacher) {
                        $duplicateCourseTeacher = clone $courseTeacher;
                        $duplicateCourseTeacher->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        $duplicateCourseTeachers->add($duplicateCourseTeacher);
                    }
                    $duplicateCourseInfo->setCourseTeachers($duplicateCourseTeachers);

                    // CourseAchievements
                    $duplicateCourseAchievements = new ArrayCollection();
                    foreach ($courseInfo->getCourseAchievements() as $courseAchievement) {
                        $duplicationCourseAchievement = clone $courseAchievement;
                        $duplicationCourseAchievement->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        $duplicateCourseAchievements->add($duplicationCourseAchievement);
                    }
                    $duplicateCourseInfo->setCourseAchievements($duplicateCourseAchievements);

                    // CourseEvaluationCts
                    $duplicateCourseEvaluationCts = new ArrayCollection();
                    foreach ($courseInfo->getCourseEvaluationCts() as $courseEvaluationCt) {
                        $duplicateCourseEvaluationCt = clone $courseEvaluationCt;
                        $duplicateCourseEvaluationCt->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        $duplicateCourseEvaluationCts->add($duplicateCourseEvaluationCt);
                    }
                    $duplicateCourseInfo->setCourseEvaluationCts($duplicateCourseEvaluationCts);

                    // CoursePrerequisites
                    $duplicateCoursePrerequisites = new ArrayCollection();
                    foreach ($courseInfo->getCoursePrerequisites() as $coursePrerequisite) {
                        $duplicateCoursePrerequisite = clone $coursePrerequisite;
                        $duplicateCoursePrerequisite->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        $duplicateCoursePrerequisites->add($duplicateCoursePrerequisite);
                    }
                    $duplicateCourseInfo->setCoursePrerequisites($duplicateCoursePrerequisites);

                    // CourseResourceEquipments
                    $duplicateCourseResourceEquipments = new ArrayCollection();
                    foreach ($courseInfo->getCourseResourceEquipments() as $courseResourceEquipment) {
                        $duplicateCourseResourceEquipment = clone $courseResourceEquipment;
                        $duplicateCourseResourceEquipment->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        $duplicateCourseResourceEquipments->add($duplicateCourseResourceEquipment);
                    }
                    $duplicateCourseInfo->setCourseResourceEquipments($duplicateCourseResourceEquipments);

                    // CourseSections
                    $duplicateCourseSections = new ArrayCollection();
                    foreach ($courseInfo->getCourseSections() as $courseSection) {
                        $duplicateCourseSection = clone $courseSection;
                        $duplicateCourseSection->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        // CourseSectionActivities
                        $duplicateCourseSectionActivities = new ArrayCollection();
                        foreach ($courseSection->getCourseSectionActivities() as $courseSectionActivity) {
                            $duplicateCourseSectionActivity = clone $courseSectionActivity;
                            $duplicateCourseSectionActivity->setId(Uuid::uuid4())
                                ->setCourseSection($duplicateCourseSection);
                            $duplicateCourseSectionActivities->add($duplicateCourseSectionActivity);
                        }
                        $duplicateCourseSection->setCourseSectionActivities($duplicateCourseSectionActivities);
                        $duplicateCourseSections->add($duplicateCourseSection);
                    }
                    $duplicateCourseInfo->setCourseSections($duplicateCourseSections);

                    // CourseTutoringResources
                    $duplicateCourseTutoringResources = new ArrayCollection();
                    foreach ($courseInfo->getCourseTutoringResources() as $courseTutoringResource) {
                        $duplicateCourseTutoringResource = clone $courseTutoringResource;
                        $duplicateCourseTutoringResource->setId(Uuid::uuid4())
                            ->setCourseInfo($duplicateCourseInfo);
                        $duplicateCourseTutoringResources->add($duplicateCourseTutoringResource);
                    }
                    $duplicateCourseInfo->setCourseTutoringResources($duplicateCourseTutoringResources);

                    $output->writeln("- New CourseInfo id = {$duplicateCourseInfo->getId()}");
                    $output->writeln("- Save");
                    $this->entityManager->persist($duplicateCourseInfo);
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }catch (\Exception $e){
                    $output->writeln((string)$e);
                }finally{
                    unset($courseInfo);
                    unset($duplicateCourseInfo);
                    unset($duplicateCourseResourceEquipments);
                    unset($duplicateCourseAchievements);
                    unset($coursesInfo[$key]);
                }
            }
        }catch (\Exception $e){

            $output->writeln((string)$e);
        }
    }
}