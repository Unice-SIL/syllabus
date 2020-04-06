<?php

namespace AppBundle\Manager;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Helper\ErrorManager;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Repository\Doctrine\CoursePrerequisiteDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CoursePermissionManager extends AbstractManager
{

    /**
     * @var CoursePrerequisiteDoctrineRepository
     */
    private $repository;

    /**
     * CoursePermissionManager constructor.
     * @param EntityManagerInterface $em
     * @param ErrorManager $errorManager
     * @param CoursePrerequisiteDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ErrorManager $errorManager, CoursePrerequisiteDoctrineRepository $repository)
    {
        parent::__construct($em, $errorManager);
        $this->repository = $repository;
    }


    /**
     * @param CourseInfo|null $courseInfo
     * @return CoursePermission
     */
    public function new(CourseInfo $courseInfo = null): CoursePermission
    {
        $coursePermission = new CoursePermission();
        $coursePermission->setCourseInfo($courseInfo);
        return $coursePermission;
    }

    /**
     * @param string $id
     * @return CoursePermission|null
     */
    public function find(string $id): ?CoursePermission
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param CoursePermission $permission
     */
    public function create(CoursePermission $permission): void
    {
        $this->em->persist($permission);
        $this->em->flush();
    }

    /**
     * @param CoursePermission $permission
     */
    public function update(CoursePermission $permission): void
    {
        $this->em->flush();
    }

    /**
     * @param CoursePermission $permission
     */
    public function delete(CoursePermission $permission): void
    {
        $this->em->remove($permission);
        $this->em->flush();
    }

    protected function getClass(): string
    {
        return CoursePermission::class;
    }

}