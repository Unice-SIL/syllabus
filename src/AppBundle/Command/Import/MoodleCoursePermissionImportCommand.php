<?php


namespace AppBundle\Command\Import;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\Year;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Import\Configuration\CoursePermissionMoodleConfiguration;
use AppBundle\Import\ImportManager;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoodleCoursePermissionImportCommand extends Command
{
    protected static $defaultName = 'app:import:moodle:permission';
    /**
     * @var ImportManager
     */
    private $importManager;
    /**
     * @var CoursePermissionMoodleConfiguration
     */
    private $coursePermissionMoodleConfiguration;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var CoursePermissionManager
     */
    private $coursePermissionManager;
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * MoodleCoursePermissionImportCommand constructor.
     * @param ImportManager $importManager
     * @param CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration
     * @param EntityManagerInterface $em
     * @param CoursePermissionManager $coursePermissionManager
     * @param UserManager $userManager
     */
    public function __construct(
        ImportManager $importManager,
        CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration,
        EntityManagerInterface $em,
        CoursePermissionManager $coursePermissionManager,
        UserManager $userManager
    )
    {
        parent::__construct();
        $this->importManager = $importManager;
        $this->coursePermissionMoodleConfiguration = $coursePermissionMoodleConfiguration;
        $this->em = $em;
        $this->coursePermissionManager = $coursePermissionManager;
        $this->userManager = $userManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Moodle Permission import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        $loopBreak = 4;
        //======================End Perf==================

        $report = ReportingHelper::createReport('Parsing');

        $coursePermissions = $this->importManager->parseFromConfig($this->coursePermissionMoodleConfiguration, $report);

        $yearsToImport = $this->em->getRepository(Year::class)->findByImport(true);

        $loop = 1;

        /** @var CoursePermission $coursePermission */
        foreach ($coursePermissions as $reportLineId => $coursePermission) {

            //======================Perf==================
            if ($loop % $loopBreak === 1) {
                $timeStart = microtime(true);
            }
            //======================End Perf==================

            $course = $this->em->getRepository(Course::class)->findOneByCode($coursePermission->getCourseInfo()->getCourse()->getCode());

            if (!$course instanceof Course) {
                continue;
            }

            $user = $coursePermission->getUser();
            $user = $this->userManager->updateIfExistsOrCreate($user, ['username'], [
                'find_by_parameters' => ['username' => $user->getUsername()],
                'flush' => true,
                'validations_groups_new' => ['Default'],
                'validations_groups_edit' => ['Default'],
            ]);

            foreach ($yearsToImport as $year) {
                $courseInfo = $this->em->getRepository(CourseInfo::class)->findByCodeAndYear($course->getCode(), $year);

                $newCoursePermission = $this->coursePermissionManager->new();
                $newCoursePermission->setUser($user);
                $newCoursePermission->setCourseInfo($courseInfo);
                $newCoursePermission->setPermission($coursePermission->getPermission());

                $this->coursePermissionManager->updateIfExistsOrCreate(
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
            }

            //$this->em->flush(); //if every permission import from moodle hasn't got a unique key username-code

            if ($loop % $loopBreak === 0) {

                $this->em->flush(); //if every permission import from moodle has a unique key username-code
                $this->em->clear();

                //======================Perf==================

                $interval[$loop] = microtime(true) - $timeStart . ' s';
                dump($interval);
                //======================End Perf==================
            }

            $loop++;
        }

        $this->em->flush(); //necessary to be sure every coursePermission was flushed;
        //======================Perf==================
        dump( $interval, microtime(true) - $start . ' s');
        //======================End Perf==================
    }


}