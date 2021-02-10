<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Repository\Doctrine\CourseTeacherDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CourseTeacherManager
 * @package App\Syllabus\Manager
 */
class CourseTeacherManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CourseTeacherDoctrineRepository
     */
    private $repository;

    /**
     * CourseTeacherManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseTeacherDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseTeacherDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return CourseTeacher
     */
    public function new()
    {
        return new CourseTeacher();
    }

    /**
     * @param string $id
     * @return CourseTeacher|null
     */
    public function find(string $id): ?CourseTeacher
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
     * @param CourseTeacher $courseTeacher
     */
    public function create(CourseTeacher $courseTeacher): void
    {
        $this->em->persist($courseTeacher);
        $this->em->flush();
    }

    /**
     * @param CourseTeacher $courseTeacher
     */
    public function update(CourseTeacher $courseTeacher): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseTeacher $courseTeacher
     */
    public function delete(CourseTeacher $courseTeacher): void
    {
        $this->em->remove($courseTeacher);
        $this->em->flush();
    }
}