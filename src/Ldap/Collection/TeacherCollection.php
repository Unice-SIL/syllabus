<?php

namespace App\Ldap\Collection;

use App\Ldap\Entity\Teacher;

/**
 * Class TeacherCollection
 * @package LdapBundle\Collection
 */
class TeacherCollection extends GenericCollection
{
    /**
     *
     */
    const TYPE = Teacher::class;

    /**
     * TeacherCollection constructor.
     * @param array $teachers
     */
    public function __construct(array $teachers = [])
    {
        parent::__construct(self::TYPE, $teachers);
    }

}