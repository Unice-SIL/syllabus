<?php

namespace AppBundle\Importer\Permission;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Importer\Common\AbstractImporterCommand;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CoursePermissionRepositoryInterface;
use AppBundle\Repository\CourseRepositoryInterface;
use AppBundle\Repository\UserRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseCollection;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInfoInterface;
use UniceSIL\SyllabusImporterToolkit\Course\CourseInterface;
use UniceSIL\SyllabusImporterToolkit\Permission\PermissionImporterInterface;
use UniceSIL\SyllabusImporterToolkit\Permission\PermissionInterface;
use UniceSIL\SyllabusImporterToolkit\User\UserInterface;

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
     * @var CoursePermissionRepositoryInterface
     */
    private $coursePermissionRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * PermissionImporterCommand constructor.
     * @param ContainerInterface $container
     * @param CourseRepositoryInterface $courseRepository
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param YearRepositoryInterface $yearRepository
     * @param UserRepositoryInterface $userRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContainerInterface $container,
        CourseRepositoryInterface $courseRepository,
        CourseInfoRepositoryInterface $courseInfoRepository,
        YearRepositoryInterface $yearRepository,
        UserRepositoryInterface $userRepository,
        LoggerInterface $logger
    )
    {
        $this->courseRepository = $courseRepository;
        $this->courseInfoRepository = $courseInfoRepository;
        $this->userRepository = $userRepository;
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
     * @return CourseCollection
     */
    private function getPermissionsToImport(array $years=[]): CourseCollection
    {
        $courses = $this->importerService->setYears($years)->execute();
        $this->output->writeln(sprintf("%d courses with permissions to import", $courses->count()));
        return $courses;
    }


    /**
     * @param CourseCollection $courses
     */
    private function startImport(CourseCollection $courses): void
    {
        $course = null;
        $courseInfo = null;
        foreach ($courses as $course) {
            foreach ($course->getCourseInfos() as $courseInfo) {
                $this->courseInfoRepository->beginTransaction();
                try {
                    // Prepare course info
                    $courseInfo = $this->prepareCourseInfo($course, $courseInfo);
                    if ($courseInfo instanceof CourseInfo) {
                        $this->courseInfoRepository->update($courseInfo);
                        $this->courseRepository->detach($courseInfo);
                    }
                    $this->courseInfoRepository->commit();
                    $this->courseInfoRepository->clear();
                } catch (\Exception $e) {
                    $this->logger->error((string)$e);
                    $this->output->writeln($e->getMessage());
                    $this->courseInfoRepository->rollback();
                }finally{
                    unset($courseInfo);
                    //gc_collect_cycles();
                }
            }
            unset($course);
        }
    }

    /**
     * @param CourseInterface $c
     * @param CourseInfoInterface $ci
     * @return CourseInfo|null
     */
    private function prepareCourseInfo(CourseInterface $c, CourseInfoInterface $ci): ?CourseInfo
    {
        $this->output->writeln(sprintf("Import permission for course %s and year  %s (%d KB used)", $c->getEtbId(), $ci->getYearId(), (memory_get_usage()/1024)));

        // COURSE INFO
        $courseInfo = $this->courseInfoRepository->findByEtbIdAndYear($c->getEtbId(), $ci->getYearId());
        if(is_null($courseInfo)){
            return null;
        }

        // PERMISSIONS
        $courseInfo->setCoursePermissions(new ArrayCollection());
        $coursePermission = null;
        foreach ($ci->getCoursePermission() as $coursePermission){
            $coursePermission = $this->prepareCoursePermission($coursePermission, $courseInfo);
            if($coursePermission instanceof CoursePermission){
                $courseInfo->addPermission($coursePermission);
            }
        }

        return $courseInfo;
    }

    /**
     * @param PermissionInterface $cp
     * @param CourseInfo $courseInfo
     * @return CoursePermission|null
     */
    private function prepareCoursePermission(PermissionInterface $cp, CourseInfo $courseInfo): ?CoursePermission
    {
        $user = $this->prepareUser($cp->getUser());

        $coursePermission = new CoursePermission();
        $coursePermission->setId(Uuid::uuid4())
            ->setCourseInfo($courseInfo)
            ->setPermission($cp->getPermission())
            ->setUser($user);

        return $coursePermission;
    }

    /**
     * @param UserInterface $u
     * @return User|null
     * @throws UserNotFoundException
     */
    private function prepareUser(UserInterface $u){
        $user = $this->userRepository->findByUsername($u->getUsername());
        if(is_null($user)) {
            if ($u->createIfNotExist()) {
                $user = new User();
                $user->setId(Uuid::uuid4())
                    ->setUsername($u->getUsername())
                    ->setFirstname($u->getFirstname())
                    ->setLastname($u->getLastname())
                    ->setEmail($u->getEmail())
                    ->setRoles([]);
            } else {
                throw new UserNotFoundException(
                    sprintf("Cannot import permission, user %s does not exist", $u->getUsername())
                );
            }
        }
        return $user;
    }


}