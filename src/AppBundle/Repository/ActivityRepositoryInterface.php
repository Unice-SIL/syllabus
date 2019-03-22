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
     * @param $type
     * @param $mode
     * @param $grp
     * @return \ArrayObject
     */
    public function findByCriteria($type, $mode, $grp): \ArrayObject;

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

}