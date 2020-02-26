<?php

namespace AppBundle\Manager;

use AppBundle\Entity\ActivityMode;
use AppBundle\Repository\ActivityModeRepositoryInterface;

/**
 * Class ActivityModeManager
 * @package AppBundle\Manager
 */
class ActivityModeManager
{
    /**
     * @var ActivityModeRepositoryInterface
     */
    private $repository;

    /**
     * ActivityModeManager constructor.
     * @param ActivityModeRepositoryInterface $repository
     */
    public function __construct(ActivityModeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ActivityMode
     */
    public function new()
    {
        return new ActivityMode();
    }

    /**
     * @param $id
     * @return ActivityMode|null
     */
    public function find($id): ?ActivityMode
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
     * @param ActivityMode $activityMode
     */
    public function create(ActivityMode $activityMode)
    {
        $this->repository->create($activityMode);
    }

    /**
     * @param ActivityMode $activityMode
     */
    public function update(ActivityMode $activityMode)
    {
        $this->repository->update($activityMode);
    }

    /**
     * @param ActivityMode $activityMode
     */
    public function delete(ActivityMode $activityMode)
    {
        $this->repository->delete($activityMode);
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