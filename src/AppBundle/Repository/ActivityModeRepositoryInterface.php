<?php


namespace AppBundle\Repository;


use AppBundle\Entity\ActivityMode;
use Doctrine\ORM\QueryBuilder;

interface ActivityModeRepositoryInterface
{
    /**
     * Find activityMode by id
     * @param string $id
     * @return ActivityMode|null
     */
    public function find(string $id): ?ActivityMode;

    /**
     * @return \ArrayObject
     */
    public function findAll(): \ArrayObject;

    /**
     * Create activityMode
     * @param ActivityMode $activityMode
     */
    public function create(ActivityMode $activityMode): void;

    /**
     * Update activityMode
     * @param ActivityMode $activityMode
     */
    public function update(ActivityMode $activityMode): void;

    /**
     * Delete activityMode
     * @param ActivityMode $activityMode
     */
    public function delete(ActivityMode $activityMode): void;

    /**
     * Begin a transaction
     */
    public function beginTransaction(): void;

    /**
     * Commit change
     */
    public function commit(): void;

    /**
     * Rollback change
     */
    public function rollback(): void;


    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder;

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query): array;
}