<?php

namespace App\Syllabus\Manager;


use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Repository\Doctrine\CourseSectionDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseSectionManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CourseSectionDoctrineRepository
     */
    private CourseSectionDoctrineRepository $repository;

    /**
     * CourseSectionManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseSectionDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseSectionDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return CourseSection
     */
    public function new(): CourseSection
    {
        return new CourseSection();
    }

    /**
     * @param $id
     * @return CourseSection|null
     */
    public function find($id): ?CourseSection
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
     * @param CourseSection $courseSection
     */
    public function create(CourseSection $courseSection): void
    {
        $this->em->persist($courseSection);
        $this->em->flush();
    }

    /**
     * @param CourseSection $courseSection
     */
    public function update(CourseSection $courseSection): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseSection $courseSection
     */
    public function delete(CourseSection $courseSection): void
    {
        $this->em->remove($courseSection);
        $this->em->flush();
    }
}