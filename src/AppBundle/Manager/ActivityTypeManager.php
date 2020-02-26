<?php


namespace AppBundle\Manager;


use AppBundle\Entity\ActivityType;
use AppBundle\Repository\ActivityTypeRepositoryInterface;

class ActivityTypeManager
{
    /**
     * @var ActivityTypeRepositoryInterface
     */
    private $repository;


    public function __construct(ActivityTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function new()
    {
        return new ActivityType();
    }
    
    public function find($id): ?ActivityType
    {
        return $this->repository->find($id);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param ActivityType $activityType
     */
    public function create(ActivityType $activityType)
    {
        $this->repository->create($activityType);
    }

    /**
     * @param ActivityType $activityType
     */
    public function update(ActivityType $activityType)
    {
        $this->repository->update($activityType);
    }

    /**
     * @param ActivityType $activityType
     */
    public function delete(ActivityType $activityType)
    {
        $this->repository->delete($activityType);
    }

    /**
     * @param $query
     * @param $field
     * @return array
     */
    public function findLikeQuery($query, $field): array
    {
        return $this->repository->findLikeQuery($query, $field);
    }
}