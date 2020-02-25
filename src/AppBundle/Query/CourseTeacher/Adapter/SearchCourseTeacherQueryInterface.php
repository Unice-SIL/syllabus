<?php

namespace AppBundle\Query\CourseTeacher\Adapter;

use AppBundle\Collection\CourseTeacherCollection;
use AppBundle\Query\CourseTeacher\Adapter\Ldap\SearchCourseTeacherLdapQuery;

/**
 * Interface SearchCourseTeacherQueryInterface
 * @package AppBundle\Query\CourseTeacher\Adapter
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