<?php

namespace AppBundle\Importer\Course;

use AppBundle\Entity\Course;
use AppBundle\Exception\CourseNotFoundException;
use AppBundle\Query\Course\FindCourseByEtbIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseImporterInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInterface;

/**
 * Class CourseImporterCommand
 * @package AppBundle\Importer
 */
class CourseImporterCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = "syllabus:importer:course";

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var FindCourseByEtbIdQuery
     */
    private $findCourseByEtbIdQuery;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CourseImporterCommand constructor.
     * @param ContainerInterface $container
     * @param FindCourseByEtbIdQuery $findCourseByEtbIdQuery
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContainerInterface $container,
        FindCourseByEtbIdQuery $findCourseByEtbIdQuery,
        LoggerInterface $logger
    )
    {
        $this->container = $container;
        $this->findCourseByEtbIdQuery = $findCourseByEtbIdQuery;
        $this->logger = $logger;
        parent::__construct();
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
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln("==============================");
            $output->writeln("Start course importer");

            $courseImporterServiceName = $input->getArgument('service');
            $output->writeln(sprintf("Get service %s", $courseImporterServiceName));
            $courseImporterServiceName = $input->getArgument('service');
            $courseImporter = $this->container->get($courseImporterServiceName);
            if (!$courseImporter instanceof CourseImporterInterface) {
                throw new \Exception(
                    sprintf("Service %s must implement %s", $courseImporterServiceName, CourseImporterInterface::class)
                );
            }
            $courses = $courseImporter->execute();
            $output->writeln(sprintf("%d courses to import", $courses->count()));
            foreach ($courses as $c) {
                try {
                    $course = $this->getCourse($c);
                }catch (\Exception $e) {
                    $msg = sprintf("Error during import course %s : %s", $c->getEtbId(), (string)$e);
                    $this->logger->error($msg);
                    $output->writeln($msg);
                }
            }
        }catch (\Exception $e){
            $this->logger->error((string)$e);
            $output->writeln($e->getMessage());
        }
        $output->writeln("End course importer");
        $output->writeln("==============================");
    }

    /**
     * @param CourseInterface $c
     * @return Course
     */
    private function getCourse(CourseInterface $c): Course
    {
        $course = new Course();
        try {

            try {
                $course = $this->findCourseByEtbIdQuery->setEtbId($c->getEtbId())->execute();
            } catch (CourseNotFoundException $e) {
            }
            foreach ($c->getParents() as $p) {
                $parent = $this->getCourse($p);
                $course->addParent($parent);
            }
            $course->setEtbId($c->getEtbId())
                ->setType($c->getType());
        }catch (\Exception $e){
            
        }
        return $course;
    }
}