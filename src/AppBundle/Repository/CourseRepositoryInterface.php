<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Course;

/**
 * Interface CourseRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseRepositoryInterface
{
    /**
     * Find course info by id
     * @param string $id
     * @return Course|null
     */
    public function find(string $id): ?Course;

    /**
     * Find course info by establishment id
     * @param $etbId
     * @return Course|null
     */
    public function findByEtbId($etbId): ?Course;

    /**
     * Create course
     * @param Course $course
     */
    public function create(Course $course): void;

    /**
     * Update course
     * @param Course $course
     */
    public function update(Course $course): void;

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