<?php

namespace App\Syllabus\Manager;


use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Repository\Doctrine\CourseSectionDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseSectionManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var CourseSectionDoctrineRepository
     */
    private $repository;

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
    public function new()
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
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param CourseSection $courseSection
     */
    public function create(CourseSection $courseSection)
    {
        $this->em->persist($courseSection);
        $this->em->flush();
    }

    /**
     * @param CourseSection $courseSection
     */
    public function update(CourseSection $courseSection)
    {
        $this->em->flush();
    }

    /**
     * @param CourseSection $courseSection
     */
    public function delete(CourseSection $courseSection)
    {
        $this->em->remove($courseSection);
        $this->em->flush();
    }
}