<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Repository\Doctrine\CourseAchievementDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CourseAchievementManager
 * @package App\Syllabus\Manager
 */
class CourseAchievementManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CourseAchievementDoctrineRepository
     */
    private $repository;

    /**
     * CourseAchievementManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseAchievementDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseAchievementDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param CourseInfo|null $courseInfo
     * @return CourseAchievement
     */
    public function new(CourseInfo $courseInfo = null)
    {
        $courseAchievement = new CourseAchievement();
        $courseAchievement->setCourseInfo($courseInfo);
        return $courseAchievement;
    }

    /**
     * @param string $id
     * @return CourseAchievement|null
     */
    public function find(string $id): ?CourseAchievement
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
     * @param CourseAchievement $courseAchievement
     */
    public function create(CourseAchievement $courseAchievement): void
    {
        $this->em->persist($courseAchievement);
        $this->em->flush();
    }

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function update(CourseAchievement $courseAchievement): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseAchievement $courseAchievement
     * @throws \Exception
     */
    public function delete(CourseAchievement $courseAchievement): void
    {
        $this->em->remove($courseAchievement);
        $this->em->flush();
    }
}