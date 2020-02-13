<?php

namespace AppBundle\Importer\Course;


use AppBundle\Exception\CourseInfoAlreadyExistException;
use AppBundle\Exception\YearNotFoundException;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\DuplicateCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByCodeAndYearQuery;
use AppBundle\Query\Year\FindYearById;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CourseDuplicateCommand
 * @package AppBundle\Importer\Course
 */
class CourseDuplicateCommand extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = "syllabus:duplicate:course";

    /**
     * @var FindCourseInfoByCodeAndYearQuery
     */
    private $findCourseInfoByCodeAndYearQuery;

    /**
     * @var FindYearById
     */
    private $findYearById;

    /**
     * @var DuplicateCourseInfoQuery
     */
    private $duplicateCourseInfoQuery;


    /**
     * CourseDuplicateCommand constructor.
     * @param FindCourseInfoByCodeAndYearQuery $findCourseInfoByCodeAndYearQuery
     * @param FindYearById $findYearById
     * @param DuplicateCourseInfoQuery $duplicateCourseInfoQuery
     */
    public function __construct(
        FindCourseInfoByCodeAndYearQuery $findCourseInfoByCodeAndYearQuery,
        FindYearById $findYearById,
        DuplicateCourseInfoQuery $duplicateCourseInfoQuery
    )
    {
        $this->findCourseInfoByCodeAndYearQuery = $findCourseInfoByCodeAndYearQuery;
        $this->findYearById = $findYearById;
        $this->duplicateCourseInfoQuery = $duplicateCourseInfoQuery;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription("Duplicate Course info for a year with a new year")
            ->setHelp(
                "This command allow you to duplicate Course info for a year with a new year"
            )
            ->addArgument('code', InputArgument::REQUIRED, 'Institution course id to duplicate')
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
        $code = $input->getArgument('code');
        $year = $input->getArgument('year');
        $newyear = $input->getArgument('newyear');

        $output->writeln("==============================");
        $output->writeln("Start duplication infos for course {$code} and year {$year} to year {$newyear}");
        $output->writeln(date('d/m/Y H:i:s', time()));
        $output->writeln($this->getDescription());
        $output->writeln("==============================");

        try {

            $courseInfo = $this->findCourseInfoByCodeAndYearQuery->setCode($code)->setYear($year)->execute();
            $newYear = $this->findYearById->setId($newyear)->execute();
            $this->duplicateCourseInfoQuery->setCourseInfo($courseInfo)->setYear($newYear)->execute();
        }catch (YearNotFoundException $e){
            $output->writeln("Year {$newyear} not found");
        }catch (CourseInfoAlreadyExistException $e) {
            $output->writeln("Course {$code} already exist for year {$newyear}");
        }catch (\Exception $e){
            $output->writeln((string)$e);
        }
    }
}