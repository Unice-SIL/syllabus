<?php

namespace LdapBundle\Repository;

use LdapBundle\Collection\TeacherCollection;
use LdapBundle\Entity\Teacher;

/**
 * Interface TeacherRepositoryInterface
 * @package LdapBundle\Repository
 */
interface TeacherRepositoryInterface
{
    /**
     * Find a teacher with id
     * @param $id
     * @return mixed
     */
    public function find($id): ?Teacher;

    /**
     * Search teachers by term
     * @param $term
     * @return mixed
     */
    public function search($term): TeacherCollection;
}