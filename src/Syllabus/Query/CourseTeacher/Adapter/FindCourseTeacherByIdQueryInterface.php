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
     * @param string $id
     * @return FindCourseTeacherByIdQueryInterface
     */
    public function setId(string $id): FindCourseTeacherByIdQueryInterface;

    /**
     * @return CourseTeacher|null
     */
    public function execute(): ?CourseTeacher;
}