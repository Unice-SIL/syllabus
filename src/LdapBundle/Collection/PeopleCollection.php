<?php

namespace LdapBundle\Collection;

use LdapBundle\Entity\People;

/**
 * Class PeopleCollection
 * @package LdapBundle\Collection
 */
class PeopleCollection extends GenericCollection
{
    /**
     *
     */
    const TYPE = People::class;

    /**
     * PeopleCollection constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE);
    }

}