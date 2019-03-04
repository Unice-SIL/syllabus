<?php

namespace LdapBundle\Collection;

use LdapBundle\Entity\Teacher;

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
     * PeopleCollection constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE);
    }

}