<?php


namespace AppBundle\Command\Test;

use AppBundle\Command\Scheduler\AbstractCron;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends AbstractCron
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:test';

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Command to test something');
    }

    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        sleep(1);


        $path = __DIR__ . '/../../../../no_commit/course_permission.csv' ;

        $coursePermissions = $this->coursePermissionParser->parse($path, ['allow_extra_field' => true, 'allow_less_field' => true]);


        $report = $this->coursePermissionParser->getReport();
        foreach ($coursePermissions as $lineIdReport => $coursePermission) {

            $this->coursePermissionManager->updateIfExistsOrCreate($coursePermission, ['permission'], [
                'flush' => true,
                'find_by_parameters' => [
                    'user' => $coursePermission->getUser(),
                    'courseInfo' => $coursePermission->getCourseInfo(),
                    'permission' => $coursePermission->getPermission()
                ],
                'lineIdReport' => $lineIdReport,
                'report' => $report
            ]);
        }
        dump($report);


        /*
        $path = __DIR__ . '/../../../../no_commit/user.csv' ;

        $users = $this->userParser->parse($path, ['allow_extra_field' => true, 'allow_less_field' => true]);

        $report = $this->userParser->getReport();

        foreach ($users as $lineIdReport => $user) {
            $this->userManager->updateIfExistsOrCreate($user, ['firstname', 'lastname', 'email'], [
                'flush' => true,
                'find_by_parameters' => [
                    'username' => $user->getUsername(),
                ],
                'lineIdReport' => $lineIdReport,
                'report' => $report
            ]);

        }

        dump($report);
        */
/*
        $path = __DIR__ . '/../../../../no_commit/course_info.csv' ;

        $courseInfos = $this->courseInfoParser->parse($path, ['allow_extra_field' => true, 'allow_less_field' => true]);

        $report = $this->courseInfoParser->getReport();

        $courseInfoFields = $this->em->getRepository(CourseInfoField::class)->findByImport(true);
        $fieldsToUpdate = array_map(function ($courseInfoField) {return $courseInfoField->getField();}, $courseInfoFields);

        $fieldsToUpdate = array_intersect($fieldsToUpdate, $this->courseInfoParser->getCsv()->getHeader());

        foreach ($courseInfos as $lineIdReport => $courseInfo) {

            $this->courseInfoManager->updateIfExistsOrCreate($courseInfo, $fieldsToUpdate, [
                'flush' => true,
                'find_by_parameters' => [
                    'course' => $courseInfo->getCourse(),
                    'year' => $courseInfo->getYear(),
                ],
                'lineIdReport' => $lineIdReport,
                'report' => $report
            ]);


        }

        dump($report);
*/
    }
}
