<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseAchievement;

/**
 * Interface CourseAchievementRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseAchievementRepositoryInterface
{
    /**
     * Find a course achievement by id
     * @param string $id
     * @return CourseAchievement|null
     */
    public function find(string $id): ?CourseAchievement;

    /**
     * Create a course achievement
     * @param CourseAchievement $courseAchievement
     */
    public function create(CourseAchievement $courseAchievement): void;

    /**
     * Delete a course achievement
     * @param CourseAchievement $courseAchievement
     */
    public function delete(CourseAchievement $courseAchievement): void;

    /**
     * Begin a transaction
     */
    public function beginTransaction(): void;

    /**
     * Commit change
     */
    public function commit(): void;

    /**
     * Rollback change
     */
    public function rollback(): void;
}