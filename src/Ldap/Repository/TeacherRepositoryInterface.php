<?php

namespace App\Ldap\Repository;

use App\Ldap\Collection\TeacherCollection;
use App\Ldap\Entity\Teacher;

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