<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseSectionActivity;

/**
 * Interface CourseSectionActivityRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseSectionActivityRepositoryInterface
{
    /**
     * Find a course section activity by id
     * @param string $id
     * @return CourseSectionActivity|null
     */
    public function find(string $id): ?CourseSectionActivity;

    /**
     * Create a course section activity
     * @param CourseSectionActivity $courseSectionActivity
     */
    public function create(CourseSectionActivity $courseSectionActivity): void;

    /**
     * Delete a course section activity
     * @param CourseSectionActivity $courseSectionActivity
     */
    public function delete(CourseSectionActivity $courseSectionActivity): void;

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