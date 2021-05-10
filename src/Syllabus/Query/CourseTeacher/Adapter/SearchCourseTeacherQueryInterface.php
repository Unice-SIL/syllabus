<?php

namespace App\Syllabus\Query\CourseTeacher\Adapter;

use App\Syllabus\Collection\CourseTeacherCollection;
use App\Syllabus\Query\CourseTeacher\Adapter\Ldap\SearchCourseTeacherLdapQuery;

/**
 * Interface SearchCourseTeacherQueryInterface
 * @package App\Syllabus\Query\CourseTeacher\Adapter
 */
interface SearchCourseTeacherQueryInterface
{
    /**
     * @param string $term
     * @return SearchCourseTeacherQueryInterface
     */
    public function setTerm(string $term): SearchCourseTeacherQueryInterface;

    /**
     * @return CourseTeacherCollection
     */
    public function execute(): CourseTeacherCollection;
}