<?php

namespace AppBundle\Query\CourseTeacher\Adapter;

use AppBundle\Collection\CourseTeacherCollection;
use AppBundle\Query\CourseTeacher\Adapter\Ldap\ImportCourseTeacherLdapQuery;

/**
 * Interface ImportCourseTeacherQueryInterface
 * @package AppBundle\Query\Adapter
 */
interface ImportCourseTeacherQueryInterface
{
    /**
     * @param string $term
     * @return ImportCourseTeacherLdapQuery
     */
    public function setTerm(string $term): ImportCourseTeacherLdapQuery;

    /**
     * @return CourseTeacherCollection
     */
    public function execute(): CourseTeacherCollection;
}