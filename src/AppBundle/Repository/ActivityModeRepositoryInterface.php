<?php


namespace AppBundle\Repository;

use AppBundle\Entity\ActivityMode;

/**
 * Interface ActivityModeRepositoryInterface
 * @package AppBundle\Repository
 */
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
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array;
}