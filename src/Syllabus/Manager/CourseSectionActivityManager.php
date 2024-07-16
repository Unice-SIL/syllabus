<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CourseSectionActivity;
use App\Syllabus\Repository\Doctrine\CourseSectionActivityDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CourseSectionActivityManager
 * @package App\Syllabus\Manager
 */
class CourseSectionActivityManager
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CourseSectionActivityDoctrineRepository
     */
    private CourseSectionActivityDoctrineRepository $repository;

    /**
     * CourseSectionActivityManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseSectionActivityDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseSectionActivityDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return CourseSectionActivity
     */
    public function new(): CourseSectionActivity
    {
        return new CourseSectionActivity();
    }

    /**
     * @param $id
     * @return CourseSectionActivity|null
     */
    public function find($id): ?CourseSectionActivity
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
     * @param CourseSectionActivity $courseSectionActivity
     */
    public function create(CourseSectionActivity $courseSectionActivity): void
    {
        $this->em->persist($courseSectionActivity);
        $this->em->flush();
    }

    /**
     * @param CourseSectionActivity $courseSectionActivity
     */
    public function update(CourseSectionActivity $courseSectionActivity): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseSectionActivity $courseSectionActivity
     */
    public function delete(CourseSectionActivity $courseSectionActivity): void
    {
        $this->em->remove($courseSectionActivity);
        $this->em->flush();
    }
}