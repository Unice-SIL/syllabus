<?php


namespace AppBundle\Repository;

use AppBundle\Entity\ActivityType;

/**
 * Interface ActivityTypeRepositoryInterface
 * @package AppBundle\Repository
 */
interface ActivityTypeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     * @return ActivityType|null
     */
    public function find(string $id): ?ActivityType;

    /**
     * @return ActivityType[]
     */
    public function findAll(): array;

    /**
     * @param ActivityType $activityType
     */
    public function create(ActivityType $activityType): void;

    /**
     * @param ActivityType $activityType
     */
    public function update(ActivityType $activityType): void;

    /**
     * @param ActivityType $activityType
     */
    public function delete(ActivityType $activityType): void;

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array;

}