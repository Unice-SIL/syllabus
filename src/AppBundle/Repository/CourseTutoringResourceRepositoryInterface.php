<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseTutoringResource;

/**
 * Interface CourseTutoringResourceRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseTutoringResourceRepositoryInterface
{
    /**
     * Find a course tutoring resource by id
     * @param string $id
     * @return CourseTutoringResource|null
     */
    public function find(string $id): ?CourseTutoringResource;

    /**
     * Create a course tutoring resource
     * @param CourseTutoringResource $courseTutoringResource
     */
    public function create(CourseTutoringResource $courseTutoringResource): void;

    /**
     * Delete a course tutoring resource
     * @param CourseTutoringResource $courseTutoringResource
     */
    public function delete(CourseTutoringResource $courseTutoringResource): void;

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