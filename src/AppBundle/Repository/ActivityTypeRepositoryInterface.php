<?php


namespace AppBundle\Repository;


use AppBundle\Entity\ActivityType;
use Doctrine\ORM\QueryBuilder;

interface ActivityTypeRepositoryInterface
{
    /**
     * Find activityType by id
     * @param string $id
     * @return ActivityType|null
     */
    public function find(string $id): ?ActivityType;

    /**
     * @return \ArrayObject
     */
    public function findAll(): \ArrayObject;

    /**
     * Create activityType
     * @param ActivityType $activityType
     */
    public function create(ActivityType $activityType): void;

    /**
     * Update activityType
     * @param ActivityType $activityType
     */
    public function update(ActivityType $activityType): void;

    /**
     * Delete activityType
     * @param ActivityType $activityType
     */
    public function delete(ActivityType $activityType): void;

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
    public function findLikeQuery(string $query, string $field): array;

}