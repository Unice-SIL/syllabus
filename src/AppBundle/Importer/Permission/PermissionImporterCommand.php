<?php

namespace AppBundle\Importer\Permission;


use AppBundle\Importer\Common\AbstractImporterCommand;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UniceSIL\SyllabusImporterToolkit\Permission\PermissionCollection;
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
        parent::__construct($container, $yearRepository, $logger);
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
        // Get years to import
        $years = $this->getYearsToImport();
        // Get permissions to import
        $courses = $this->getPermissionsToImport($years);
        // Start import permissions
        $this->startImport($courses);

    }

    /**
     * @param array $years
     * @return PermissionCollection
     */
    private function getPermissionsToImport(array $years=[]): PermissionCollection
    {
        $permissions = $this->importerService->setYears($years)->execute();
        $this->output->writeln(sprintf("%d permissions to import", $permissions->count()));
        return $permissions;
    }


    /**
     * @param PermissionCollection $permissions
     */
    private function startImport(PermissionCollection $permissions): void
    {
        foreach ($permissions as $permission) {
            try {
                $this->courseRepository->beginTransaction();
                // Prepare course
                $course = $this->prepareCourse($course);
                if ($course instanceof Course) {
                    $this->courseRepository->update($course);
                }
                $this->courseRepository->commit();
            } catch (\Exception $e) {
                $this->courseRepository->rollback();
                $this->logger->error((string)$e);
                $this->output->writeln($e->getMessage());
            }
        }
    }
}