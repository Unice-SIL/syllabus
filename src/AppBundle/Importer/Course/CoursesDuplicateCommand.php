<?php

namespace AppBundle\Importer\Course;


use AppBundle\Exception\CourseInfoAlreadyExistException;
use AppBundle\Exception\YearNotFoundException;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\DuplicateCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByEtbIdAndYearQuery;
use AppBundle\Query\Course\FindCourseInfoByYearQuery;
use AppBundle\Query\Year\FindYearById;
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
     * @var FindCourseInfoByYearQuery
     */
    private $findCourseInfoByYearQuery;

    /**
     * @var FindYearById
     */
    private $findYearById;

    /**
     * @var DuplicateCourseInfoQuery
     */
    private $duplicateCourseInfoQuery;


    /**
     * CoursesDuplicateCommand constructor.
     * @param FindCourseInfoByYearQuery $findCourseInfoByYearQuery
     * @param FindYearById $findYearById
     * @param DuplicateCourseInfoQuery $duplicateCourseInfoQuery
     */
    public function __construct(
        FindCourseInfoByYearQuery $findCourseInfoByYearQuery,
        FindYearById $findYearById,
        DuplicateCourseInfoQuery $duplicateCourseInfoQuery
    )
    {
        $this->findCourseInfoByYearQuery = $findCourseInfoByYearQuery;
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
            $newYear = $this->findYearById->setId($newyear)->execute();
            $coursesInfo = $this->findCourseInfoByYearQuery->setYear($year)->execute();
            foreach ($coursesInfo as $courseInfo){
                try {
                    $this->duplicateCourseInfoQuery->setCourseInfo($courseInfo)->setYear($newYear)->execute();
                }catch (CourseInfoAlreadyExistException $e) {
                    $output->writeln("Course {$coursesInfo->getCourse()->getEtbId()} already exist for year {$newyear}");
                }catch (\Exception $e){
                    $output->writeln((string)$e);
                }
            }
        }catch (YearNotFoundException $e){
            $output->writeln("Year {$newyear} not found");
        }catch (\Exception $e){
            $output->writeln((string)$e);
        }
    }
}