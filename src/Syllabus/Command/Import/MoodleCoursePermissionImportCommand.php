<?php


namespace App\Syllabus\Command\Import;


use App\Syllabus\Command\Scheduler\AbstractJob;
use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Entity\User;
use App\Syllabus\Entity\Year;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportingHelper;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Import\Configuration\CoursePermissionMoodleConfiguration;
use App\Syllabus\Import\ImportManager;
use App\Syllabus\Manager\CoursePermissionManager;
use App\Syllabus\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'syllabus:import:moodle:import',
)]
class MoodleCoursePermissionImportCommand extends AbstractJob
{
    private const LOOP_BREAK = 10;

    private $timeStart;

    /**
     * @var int
     */
    private int $memStart = 0;

    /**
     * @var int
     */
    private int $loop = 1;

    /**
     * @var int
     */
    private int $totalLoop = 0;

    /**
     * @var array
     */
    private array $options;
    /**
     * @var ImportManager
     */
    private ImportManager $importManager;
    /**
     * @var CoursePermissionMoodleConfiguration
     */
    private CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration;
    /**
     * @var CoursePermissionManager
     */
    private CoursePermissionManager $coursePermissionManager;
    /**
     * @var UserManager
     */
    private UserManager $userManager;

    const SOURCE = 'moodle';

    /**
     * MoodleCoursePermissionImportCommand constructor.
     * @param ImportManager $importManager
     * @param CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration
     * @param EntityManagerInterface $em
     * @param CoursePermissionManager $coursePermissionManager
     * @param UserManager $userManager
     * @param array $moodlePermissionDbImporterOptions
     */
    public function __construct(
        ImportManager $importManager,
        CoursePermissionMoodleConfiguration $coursePermissionMoodleConfiguration,
        EntityManagerInterface $em,
        CoursePermissionManager $coursePermissionManager,
        UserManager $userManager,
        array $moodlePermissionDbImporterOptions
    )
    {
        parent::__construct($em);
        $this->options = $moodlePermissionDbImporterOptions;
        $this->importManager = $importManager;
        $this->coursePermissionMoodleConfiguration = $coursePermissionMoodleConfiguration;
        $this->coursePermissionManager = $coursePermissionManager;
        $this->userManager = $userManager;
    }


    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('Moodle Permission import');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Report
     * @throws Exception
     */
    protected function subExecute(InputInterface $input, OutputInterface $output): Report
    {
        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        //======================End Perf==================

        $report = ReportingHelper::createReport();

        $this->progress(0);

        $coursePermissions = $this->importManager->parseFromConfig($this->coursePermissionMoodleConfiguration, $report, $this->options);

        $this->totalLoop = count($coursePermissions);

        $yearsToImport = $this->em->getRepository(Year::class)->findByImport(true);

        $handledCourseInfoIds = [];
        $handledUserUsernames = [];

        /** @var CoursePermission $coursePermission */
        foreach ($coursePermissions as $reportLineId => $coursePermission) {

            //======================Perf==================
            if ($this->loop % self::LOOP_BREAK === 1) {
                $this->timeStart = microtime(true);
                $this->memStart = memory_get_usage();
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

                    if ($report->getLineReport($reportLineId) instanceof ReportLine) {
                        dump($course->getCode() . ' - ' . $user->getUsername());
                        dump($report->getLineReport($reportLineId)->getComments());
                        $this->nextLoop();
                        continue;
                    }

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

            }

            $this->nextLoop();
        }

        $this->em->flush(); //necessary to be sure every coursePermission was flushed;
        //======================Perf==================
        dump( $interval, microtime(true) - $start . ' s');
        //======================End Perf==================

        return $report;
    }


    private function nextLoop(): void
    {
        if ($this->loop % self::LOOP_BREAK === 0) {
            $progress = round((($this->loop / $this->totalLoop) * 100));
            $this->progress($progress);
            $this->memoryUsed(memory_get_usage(), true);

            $this->em->clear();

            //======================Perf==================

            $interval[$this->loop]['time'] = microtime(true) - $this->timeStart . ' s';
            $interval[$this->loop]['memory'] = round((memory_get_usage() - $this->memStart) / 1048576, 2) . ' MB';
            $interval[$this->loop]['progress'] = $progress . '%';
            dump($interval[$this->loop]);
            //======================End Perf==================
        }

        $this->loop++;
    }

}