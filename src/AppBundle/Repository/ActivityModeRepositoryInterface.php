<?php


namespace AppBundle\Repository;


use AppBundle\Entity\ActivityMode;
use Doctrine\ORM\QueryBuilder;

interface ActivityModeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     * @return ActivityMode|null
     */
    public function find(string $id): ?ActivityMode;

    /**
     * @return ActivityMode[]
     */
    public function findAll(): array;

    /**
     * @param ActivityMode $activityMode
     */
    public function create(ActivityMode $activityMode): void;

    /**
     * @param ActivityMode $activityMode
     */
    public function update(ActivityMode $activityMode): void;

    /**
     * @param ActivityMode $activityMode
     */
    public function delete(ActivityMode $activityMode): void;

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder;

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array;
}