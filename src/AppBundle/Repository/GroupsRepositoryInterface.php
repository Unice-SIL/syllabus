<?php

namespace AppBundle\Repository;


use Doctrine\ORM\QueryBuilder;

/**
 * Class GroupsDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
interface GroupsRepositoryInterface
{
    public function findLikeQuery(string $query, string $field): array;

    public function getIndexQueryBuilder(): QueryBuilder;
}