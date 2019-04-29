<?php

namespace AppBundle\Importer\Permission;


use AppBundle\Importer\Common\AbstractImporterCommand;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseImporterInterface;
use UniceSIL\SyllabusImporterToolkit\Permission\PermissionImporterInterface;

/**
 * Class PermissionImporterCommand
 * @package AppBundle\Importer\Course
 */
class PermissionImporterCommand extends AbstractImporterCommand
{
    /**
     * @var string
     */
    protected static $defaultName = "syllabus:importer:permission";

    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var YearRepositoryInterface
     */
    private $yearRepository;

    /**
     * CourseImporterCommand constructor.
     * @param ContainerInterface $container
     * @param CourseRepositoryInterface $courseRepository
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param YearRepositoryInterface $yearRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContainerInterface $container,
        CourseRepositoryInterface $courseRepository,
        CourseInfoRepositoryInterface $courseInfoRepository,
        YearRepositoryInterface $yearRepository,
        LoggerInterface $logger
    )
    {
        $this->courseRepository = $courseRepository;
        $this->courseInfoRepository = $courseInfoRepository;
        $this->yearRepository =$yearRepository;
        parent::__construct($container, $logger);
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription("Import Permission in Syllabus from external repository")
            ->setHelp(
                "This command allow you to import permission in Syllabus from external repository"
            )
            ->addArgument('service', InputArgument::REQUIRED, 'Course importer service name to use');
        parent::configure();
    }


    protected function start()
    {

        if (!$this->importerService instanceof PermissionImporterInterface) {
            throw new \Exception(
                sprintf("Service %s must implement %s", $this->importerServiceName, PermissionImporterInterface::class)
            );
        }
        $this->importerService->setArgs($this->importerServiceArgs);

        //

    }


}