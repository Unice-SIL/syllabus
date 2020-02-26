<?php


namespace AppBundle\Manager;

use AppBundle\Entity\Activity;
use AppBundle\Repository\ActivityRepositoryInterface;

/**
 * Class ActivityManager
 * @package AppBundle\Manager
 */
class ActivityManager
{
    /**
     * @var ActivityRepositoryInterface
     */
    private $repository;

    /**
     * ActivityManager constructor.
     * @param ActivityRepositoryInterface $repository
     */
    public function __construct(ActivityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Activity
     */
    public function new()
    {
        return new Activity();
    }

    /**
     * @param $id
     * @return Activity|null
     */
    public function find($id): ?Activity
    {
        return $this->repository->find($id);
    }

    /**
     * @return object[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Activity $activity
     */
    public function create(Activity $activity)
    {
        $this->repository->create($activity);
    }

    /**
     * @param Activity $activity
     */
    public function update(Activity $activity)
    {
        $this->repository->update($activity);
    }

    /**
     * @param Activity $activity
     */
    public function delete(Activity $activity)
    {
        $this->repository->delete($activity);
    }

    /**
     * @param $query
     * @return array
     */
    public function findLikeQuery($query): array
    {
        return $this->repository->findLikeQuery($query);
    }
}