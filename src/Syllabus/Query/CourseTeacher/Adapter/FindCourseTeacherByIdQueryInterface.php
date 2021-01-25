<?php

namespace App\Syllabus\Query\CourseTeacher\Adapter;

use App\Syllabus\Entity\CourseTeacher;

/**
 * Interface FindCourseTeacherByIdQueryInterface
 * @package App\Syllabus\Query\CourseTeacher\Adapter
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