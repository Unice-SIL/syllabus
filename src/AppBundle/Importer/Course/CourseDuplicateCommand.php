<?php

namespace AppBundle\Importer\Course;


use AppBundle\Exception\CourseInfoAlreadyExistException;
use AppBundle\Exception\YearNotFoundException;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\DuplicateCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByEtbIdAndYearQuery;
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
     * @var FindCourseInfoByEtbIdAndYearQuery
     */
    private $findCourseInfoByEtbIdAndYearQuery;

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
     * @param FindCourseInfoByEtbIdAndYearQuery $findCourseInfoByEtbIdAndYearQuery
     * @param FindYearById $findYearById
     * @param DuplicateCourseInfoQuery $duplicateCourseInfoQuery
     */
    public function __construct(
        FindCourseInfoByEtbIdAndYearQuery $findCourseInfoByEtbIdAndYearQuery,
        FindYearById $findYearById,
        DuplicateCourseInfoQuery $duplicateCourseInfoQuery
    )
    {
        $this->findCourseInfoByEtbIdAndYearQuery = $findCourseInfoByEtbIdAndYearQuery;
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
            ->addArgument('etbId', InputArgument::REQUIRED, 'Institution course id to duplicate')
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
        $etbId = $input->getArgument('etbId');
        $year = $input->getArgument('year');
        $newyear = $input->getArgument('newyear');

        $output->writeln("==============================");
        $output->writeln("Start duplication infos for course {$etbId} and year {$year} to year {$newyear}");
        $output->writeln(date('d/m/Y H:i:s', time()));
        $output->writeln($this->getDescription());
        $output->writeln("==============================");

        try {

            $courseInfo = $this->findCourseInfoByEtbIdAndYearQuery->setEtbId($etbId)->setYear($year)->execute();
            $newYear = $this->findYearById->setId($newyear)->execute();
            $this->duplicateCourseInfoQuery->setCourseInfo($courseInfo)->setYear($newYear)->execute();
        }catch (YearNotFoundException $e){
            $output->writeln("Year {$newyear} not found");
        }catch (CourseInfoAlreadyExistException $e) {
            $output->writeln("Course {$etbId} already exist for year {$newyear}");
        }catch (\Exception $e){
            $output->writeln((string)$e);
        }
    }
}