<?php

namespace LdapBundle\Repository;

interface PeopleRepositoryInterface
{

    /**
     * @param $term
     * @return mixed
     */
    public function search($term);
}