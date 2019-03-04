<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseTeacher;
use AppBundle\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseTeacherRepositoryInterface
{
    /**
     * Find a course teacher by id
     * @param string $id
     * @return CourseTeacher|null
     */
    public function find(string $id): ?CourseTeacher;

    /**
     * Create a course teacher
     * @param CourseTeacher $courseTeacher
     */
    public function create(CourseTeacher $courseTeacher): void;

    /**
     * Delete a course teacher
     * @param CourseTeacher $courseTeacher
     */
    public function delete(CourseTeacher $courseTeacher): void;

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