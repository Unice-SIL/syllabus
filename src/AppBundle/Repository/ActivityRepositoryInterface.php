<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Activity;

/**
 * Interface ActivityRepositoryInterface
 * @package AppBundle\Repository
 */
interface ActivityRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $id
     * @return Activity|null
     */
    public function find($id): ?Activity;

    /**
     * @return Activity[]
     */
    public function findAll(): array;

    /**
     * @param Activity $activity
     */
    public function create(Activity $activity): void;

    /**
     * @param Activity $activity
     */
    public function update(Activity $activity): void;

    /**
     * @param Activity $activity
     */
    public function delete(Activity $activity): void;

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array;

}