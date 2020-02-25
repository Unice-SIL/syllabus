<?php


namespace AppBundle\Command\Test;

use AppBundle\Helper\ErrorManager;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Manager\UserManager;
use AppBundle\Parser\CourseInfoCsvParser;
use AppBundle\Parser\CoursePermissionCsvParser;
use AppBundle\Parser\UserCsvParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:test';

    /**
     * @var UserManager
     */
    private $coursePermissionManager;
    private $coursePermissionParser;
    private $userManager;
    private $userParser;
    private $courseInfoManager;
    private $courseInfoParser;
    /**
     * @var ErrorManager
     */
    private $errorManager;
    private $em;

    public function __construct(
        CoursePermissionManager $coursePermissionManager,
        CoursePermissionCsvParser $coursePermissionParser,
        UserManager $userManager,
        UserCsvParser $userParser,
        CourseInfoManager $courseInfoManager,
        CourseInfoCsvParser $courseInfoParser,
        EntityManagerInterface $em,
        ErrorManager $errorManager
    )
    {
        parent::__construct();
        $this->coursePermissionManager = $coursePermissionManager;
        $this->coursePermissionParser = $coursePermissionParser;
        $this->userManager = $userManager;
        $this->userParser = $userParser;
        $this->courseInfoManager = $courseInfoManager;
        $this->courseInfoParser = $courseInfoParser;
        $this->em = $em;
        $this->errorManager = $errorManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Command to test something');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $path = __DIR__ . '/../../../../no_commit/course_permission.csv' ;
//
//        $coursePermissions = $this->coursePermissionParser->parse($path, ['allow_extra_field' => true, 'allow_less_field' => true]);
//
//
//        $report = $this->coursePermissionParser->getReport();
//        foreach ($coursePermissions as $lineIdReport => $coursePermission) {
//
//            $this->coursePermissionManager->updateIfExistsOrCreate($coursePermission, ['permission'], [
//                'flush' => true,
//                'find_by_parameters' => [
//                    'user' => $coursePermission->getUser(),
//                    'courseInfo' => $coursePermission->getCourseInfo(),
//                    'permission' => $coursePermission->getPermission()
//                ],
//                'lineIdReport' => $lineIdReport,
//                'report' => $report
//            ]);
//        }
//        dump($report);
//
        $path = __DIR__ . '/../../../../no_commit/user.csv' ;

        $users = $this->userParser->parse($path, ['allow_extra_field' => true, 'allow_less_field' => true]);

        $report = $this->userParser->getReport();

        foreach ($users as $lineIdReport => $user) {
            $this->userManager->updateIfExistsOrCreate($user, ['firstname'], [
                'flush' => true,
                'find_by_parameters' => [
                    'username' => $user->getUsername(),
                ],
                'lineIdReport' => $lineIdReport,
                'report' => $report
            ]);


        }

        dump($report);

//        $path = __DIR__ . '/../../../../no_commit/course_info.csv' ;
//
//        $courseInfos = $this->courseInfoParser->parse($path, ['allow_extra_field' => true, 'allow_less_field' => true]);
//
//        $report = $this->courseInfoParser->getReport();
//
//        $courseInfoFields = $this->em->getRepository(CourseInfoField::class)->findByImport(true);
//        $fieldsToUpdate = array_map(function ($courseInfoField) {return $courseInfoField->getField();}, $courseInfoFields);
//
//        foreach ($courseInfos as $lineIdReport => $courseInfo) {
//
//            $this->courseInfoManager->updateIfExistsOrCreate($courseInfo, $fieldsToUpdate, [
//                'flush' => true,
//                'find_by_parameters' => [
//                    'course' => $courseInfo->getCourse(),
//                    'year' => $courseInfo->getYear(),
//                ],
//                'lineIdReport' => $lineIdReport,
//                'report' => $report
//            ]);
//
//
//        }
//
//        dump($report);
    }
}
