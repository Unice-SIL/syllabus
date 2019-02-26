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
     * Delete a course teacher
     * @param CourseTeacher $courseTeacher
     */
    public function delete(CourseTeacher $courseTeacher): void;

}