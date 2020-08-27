<?php

namespace AppBundle\Manager;

use AppBundle\Entity\ActivityType;
use AppBundle\Repository\Doctrine\ActivityTypeDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ActivityTypeManager
 * @package AppBundle\Manager
 */
class ActivityTypeManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ActivityTypeDoctrineRepository
     */
    private $repository;


    public function __construct(EntityManagerInterface $em, ActivityTypeDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function new()
    {
        return new ActivityType();
    }

    /**
     * @param string $id
     * @return ActivityType|null
     */
    public function find($id): ?ActivityType
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return array
     */
    public function findAllNotObsolete()
    {
        return $this->repository->getIndexQueryBuilder()->andWhere('at.obsolete = 0')->getQuery()->getResult();
    }

    /**
     * @param ActivityType $activityType
     */
    public function create(ActivityType $activityType): void
    {
        $this->em->persist($activityType);
        $this->em->flush();
    }

    /**
     * @param ActivityType $activityType
     */
    public function update(ActivityType $activityType): void
    {
        $this->em->flush();
    }

    /**
     * @param ActivityType $activityType
     */
    public function delete(ActivityType $activityType): void
    {
        $this->em->remove($activityType);
        $this->em->flush();
    }
}