<?php

namespace AppBundle\Manager;

use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseAchievementRepositoryInterface;

/**
 * Class CourseAchievementManager
 * @package AppBundle\Manager
 */
class CourseAchievementManager
{
    /**
     * @var CourseAchievementRepositoryInterface
     */
    private $repository;

    /**
     * CourseAchievementManager constructor.
     * @param CourseAchievementRepositoryInterface $repository
     */
    public function __construct(CourseAchievementRepositoryInterface $repository)
    {
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
     * @param $id
     * @return CourseAchievement|null
     */
    public function find($id): ?CourseAchievement
    {
        return $this->repository->find($id);
    }

    /**
     * @return object[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function create(CourseAchievement $courseAchievement)
    {
        $this->repository->create($courseAchievement);
    }

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function update(CourseAchievement $courseAchievement)
    {
        $this->repository->update($courseAchievement);
    }

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function delete(CourseAchievement $courseAchievement)
    {
        $this->repository->delete($courseAchievement);
    }
}