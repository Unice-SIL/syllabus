<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Repository\Doctrine\CoursePrerequisiteDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CoursePrerequisiteManager
 * @package App\Syllabus\Manager
 */
class CoursePrerequisiteManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CoursePrerequisiteDoctrineRepository
     */
    private CoursePrerequisiteDoctrineRepository $repository;

    /**
     * ActivityManager constructor.
     * @param EntityManagerInterface $em
     * @param CoursePrerequisiteDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CoursePrerequisiteDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return CoursePrerequisite
     */
    public function new(): CoursePrerequisite
    {
        return new CoursePrerequisite();
    }

    /**
     * @param string $id
     * @return CoursePrerequisite|null
     */
    public function find(string $id): ?CoursePrerequisite
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
     * @param CoursePrerequisite $coursePrerequisite
     */
    public function create(CoursePrerequisite $coursePrerequisite): void
    {
        $this->em->persist($coursePrerequisite);
        $this->em->flush();
    }

    /**
     * @param CoursePrerequisite $coursePrerequisite
     */
    public function update(CoursePrerequisite $coursePrerequisite): void
    {
        $this->em->flush();
    }

    /**
     * @param CoursePrerequisite $coursePrerequisite
     */
    public function delete(CoursePrerequisite $coursePrerequisite): void
    {
        $this->em->remove($coursePrerequisite);
        $this->em->flush();
    }
}