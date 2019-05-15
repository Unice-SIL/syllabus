<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CoursePermission;

/**
 * Interface CoursePermissionRepositoryInterface
 * @package AppBundle\Repository
 */
interface CoursePermissionRepositoryInterface
{
    /**
     * Find permission by id
     * @param string $id
     * @return CoursePermission|null
     */
    public function find(string $id): ?CoursePermission;

    /**
     * Create permission
     * @param CoursePermission $permission
     */
    public function create(CoursePermission $permission): void;

    /**
     * Update permission
     * @param CoursePermission $permission
     */
    public function update(CoursePermission $permission): void;


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