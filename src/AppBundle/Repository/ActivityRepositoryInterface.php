<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Activity;

/**
 * Interface ActivityRepositoryInterface
 * @package AppBundle\Repository
 */
interface ActivityRepositoryInterface
{
    /**
     * Find activity by id
     * @param string $id
     * @return Activity|null
     */
    public function find(string $id): ?Activity;

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param $type
     * @return \ArrayObject
     */
    public function findByCriteria($type): \ArrayObject;

    /**
     * Create activity
     * @param Activity $activity
     */
    public function create(Activity $activity): void;

    /**
     * Update activity
     * @param Activity $activity
     */
    public function update(Activity $activity): void;

    /**
     * Delete activity
     * @param Activity $activity
     */
    public function delete(Activity $activity): void;

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
     * Find activities by type with label like $query
     *
     * @param $query
     * @param $type
     * @return \ArrayObject
     */
    public function findLikeQuery(string $query, string $type): array;

}