<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseAchievement;

/**
 * Interface CourseAchievementRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseAchievementRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     * @return CourseAchievement|null
     */
    public function find(string $id): ?CourseAchievement;

    /**
     * @return CourseAchievement[]
     */
    public function findAll(): array;

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function create(CourseAchievement $courseAchievement): void;

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function update(CourseAchievement $courseAchievement): void;

    /**
     * @param CourseAchievement $courseAchievement
     */
    public function delete(CourseAchievement $courseAchievement): void;
}