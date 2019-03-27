<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CoursePrerequisite;

/**
 * Interface CoursePrerequisiteRepositoryInterface
 * @package AppBundle\Repository
 */
interface CoursePrerequisiteRepositoryInterface
{
    /**
     * Find a course prerequisite by id
     * @param string $id
     * @return CoursePrerequisite|null
     */
    public function find(string $id): ?CoursePrerequisite;

    /**
     * Create a course prerequisite
     * @param CoursePrerequisite $coursePrerequisite
     */
    public function create(CoursePrerequisite $coursePrerequisite): void;

    /**
     * Delete a course prerequisite
     * @param CoursePrerequisite $coursePrerequisite
     */
    public function delete(CoursePrerequisite $coursePrerequisite): void;

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