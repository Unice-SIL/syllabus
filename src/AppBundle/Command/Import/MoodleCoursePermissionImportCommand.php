<?php


namespace AppBundle\Command\Import;


use AppBundle\Command\Scheduler\AbstractJob;
use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\User;
use AppBundle\Entity\Year;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Import\Configuration\CoursePermissionMoodleConfiguration;
use AppBundle\Import\ImportManager;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoodleCoursePermissionImportCommand extends AbstractJob
{
    protected static $defaultName = 'app:import:moodle:permission';
    /**
     * @var array
     */
    private $options;
    /**
     * @var ImportManager
     */
    private $importManager;
    /**
     * @var CoursePermissionMoodleConfiguration
     */
    private $coursePermissionMoodleConfiguration;
    /**
     * @var CoursePermissionManager
     */
    private $coursePermissionManager;
    /**
     * @var UserManager
     */
    private $userManager;

    const SOURCE = 'moodle';

    /**
     * MoodleCoursePermissionImportCommand constructor.
     * @param ImportManager $importManager
     * @param CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration
     * @param EntityManagerInterface $em
     * @param CoursePermissionManager $coursePermissionManager
     * @param UserManager $userManager
     * @param array $moodlePermissionImporterOptions
     */
    public function __construct(
        ImportManager $importManager,
        CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration,
        EntityManagerInterface $em,
        CoursePermissionManager $coursePermissionManager,
        UserManager $userManager,
        array $moodlePermissionImporterOptions
    )
    {
        parent::__construct($em);
        $this->options = $moodlePermissionImporterOptions;
        $this->importManager = $importManager;
        $this->coursePermissionMoodleConfiguration = $coursePermissionMoodleConfiguration;
        $this->coursePermissionManager = $coursePermissionManager;
        $this->userManager = $userManager;
    }


    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Moodle Permission import');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
     * @throws \Exception
     */
    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        $loopBreak = 4;
        //======================End Perf==================

        $report = ReportingHelper::createReport();

        $this->progress(1);

        $coursePermissions = $this->importManager->parseFromConfig($this->coursePermissionMoodleConfiguration, $report, $this->options);

        $this->progress(50);

        $yearsToImport = $this->em->getRepository(Year::class)->findByImport(true);

        $loop = 1;
        $memStart = 0;
        $handledCourseInfoIds = [];
        $handledUserUsernames = [];

        /** @var CoursePermission $coursePermission */
        foreach ($coursePermissions as $reportLineId => $coursePermission) {

            //======================Perf==================
            if ($loop % $loopBreak === 1) {
                $timeStart = microtime(true);
                $memStart = memory_get_usage();
            }
            //======================End Perf==================

            /** @var Course $course */
            $course = $this->em->getRepository(Course::class)->findOneByCode($coursePermission->getCourseInfo()->getCourse()->getCode());

            if ($course instanceof Course) {

                $user = $coursePermission->getUser();

                if (!in_array($user->getUsername(), $handledUserUsernames)) {

                    /** @var User $user */
                    $user = $this->userManager->updateIfExistsOrCreate($user, ['username'], [
                        'find_by_parameters' => ['username' => $user->getUsername()],
                        'flush' => true,
                        'validations_groups_new' => ['Default'],
                        'validations_groups_edit' => ['Default'],
                        'report' => $report,
                        'lineIdReport' => $reportLineId,
                    ]);
                    $handledUserUsernames[] = $user->getUsername();

                } else {
                    $user = $this->em->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);
                }

                foreach ($yearsToImport as $year) {
                    /** @var CourseInfo $courseInfo */
                    $courseInfo = $this->em->getRepository(CourseInfo::class)->findByCodeAndYear($course->getCode(), $year);

                    if ($courseInfo instanceof CourseInfo) {

                        // Removes old moodle permissions from courseinfo
                        if (!in_array($courseInfo->getId(), $handledCourseInfoIds)) {
                            /** @var CoursePermission $oldCoursePermission */
                            foreach ($courseInfo->getCoursePermissions() as $oldCoursePermission) {
                                if ($oldCoursePermission->getSource() === self::SOURCE) {
                                    $courseInfo->removeCoursePermission($oldCoursePermission);
                                }
                            }
                            $handledCourseInfoIds[] = $courseInfo->getId();
                        }

                        $newCoursePermission = $this->coursePermissionManager->new();
                        $newCoursePermission->setSource(self::SOURCE)
                            ->setUser($user)
                            ->setCourseInfo($courseInfo)
                            ->setPermission($coursePermission->getPermission());

                        /** @var CoursePermission $newCoursePermission */
                        $newCoursePermission = $this->coursePermissionManager->updateIfExistsOrCreate(
                            $newCoursePermission,
                            ['user', 'courseInfo', 'permission'],
                            [
                                'find_by_parameters' => [
                                    'user' => $newCoursePermission->getUser(),
                                    'courseInfo' => $newCoursePermission->getCourseInfo(),
                                    'permission' => $newCoursePermission->getPermission(),
                                ],
                                'validations_groups_new' => ['Default'],
                                'validations_groups_edit' => ['Default'],
                                'report' => $report,
                                'lineIdReport' => $reportLineId,
                            ]
                        );

                        $courseInfo->addCoursePermission($newCoursePermission);
                    }
                }


                $this->em->flush(); //if every permission import from moodle hasn't got a unique key username-code

                if ($loop % $loopBreak === 0) {
                    $progress = round((($loop / count($coursePermissions)) * 50) + 50);
                    $this->progress($progress);
                    $this->memoryUsed(memory_get_usage(), true);

                    $this->em->clear();

                    //======================Perf==================

                    $interval[$loop]['time'] = microtime(true) - $timeStart . ' s';
                    $interval[$loop]['memory'] = round((memory_get_usage() - $memStart) / 1048576, 2) . ' MB';
                    $interval[$loop]['progress'] = $progress . '%';
                    dump($interval[$loop]);
                    //======================End Perf==================
                }
            }

            $loop++;
        }

        $this->em->flush(); //necessary to be sure every coursePermission was flushed;
        //======================Perf==================
        dump( $interval, microtime(true) - $start . ' s');
        //======================End Perf==================

        return $report;
    }


}