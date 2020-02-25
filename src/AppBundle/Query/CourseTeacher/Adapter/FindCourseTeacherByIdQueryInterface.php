<?php

namespace AppBundle\Query\CourseTeacher\Adapter;

use AppBundle\Entity\CourseTeacher;

/**
 * Interface FindCourseTeacherByIdQueryInterface
 * @package AppBundle\Query\CourseTeacher\Adapter
 */
interface FindCourseTeacherByIdQueryInterface
{
    /**
     * @param string $term
     * @return FindCourseTeacherByIdQueryInterface
     */
    public function setId(string $term): FindCourseTeacherByIdQueryInterface;

    /**
     * @return CourseTeacher|null
     */
    public function execute(): ?CourseTeacher;
}