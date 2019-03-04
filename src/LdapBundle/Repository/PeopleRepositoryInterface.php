<?php

namespace LdapBundle\Repository;

use LdapBundle\Collection\PeopleCollection;
use LdapBundle\Entity\People;

/**
 * Interface PeopleRepositoryInterface
 * @package LdapBundle\Repository
 */
interface PeopleRepositoryInterface
{
    /**
     * Find a people with id
     * @param $id
     * @return mixed
     */
    public function find($id): ?People;

    /**
     * Search peoples by term
     * @param $term
     * @return mixed
     */
    public function search($term): PeopleCollection;
}