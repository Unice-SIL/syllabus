<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CourseCriticalAchievement;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Repository\Doctrine\CourseCriticalAchievementDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CourseCriticalAchievementManager
 * @package App\Syllabus\Manager
 */
class CourseCriticalAchievementManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CourseCriticalAchievementDoctrineRepository
     */
    private CourseCriticalAchievementDoctrineRepository $repository;

    /**
     * CourseCriticalAchievementManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseCriticalAchievementDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseCriticalAchievementDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param CourseInfo|null $courseInfo
     * @return CourseCriticalAchievement
     */
    public function new(CourseInfo $courseInfo = null): CourseCriticalAchievement
    {
        $courseCriticalAchievement = new CourseCriticalAchievement();
        $courseCriticalAchievement->setCourseInfo($courseInfo);
        return $courseCriticalAchievement;
    }

    /**
     * @param string $id
     * @return CourseCriticalAchievement|null
     */
    public function find(string $id): ?CourseCriticalAchievement
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
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function create(CourseCriticalAchievement $courseCriticalAchievement): void
    {
        $this->em->persist($courseCriticalAchievement);
        $this->em->flush();
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function update(CourseCriticalAchievement $courseCriticalAchievement): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function delete(CourseCriticalAchievement $courseCriticalAchievement): void
    {
        $this->em->remove($courseCriticalAchievement);
        $this->em->flush();
    }


}