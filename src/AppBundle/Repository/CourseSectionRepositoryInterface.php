<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseSection;

/**
 * Interface CourseSectionRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseSectionRepositoryInterface
{
    /**
     * Find a course section by id
     * @param string $id
     * @return CourseSection|null
     */
    public function find(string $id): ?CourseSection;

    /**
     * Create a course section
     * @param CourseSection $courseSection
     */
    public function create(CourseSection $courseSection): void;

    /**
     * Delete a course section
     * @param CourseSection $courseSection
     */
    public function delete(CourseSection $courseSection): void;

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