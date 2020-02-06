<?php

namespace AppBundle\Manager;


use AppBundle\Repository\ActivityTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ActivityTypeManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var ActivityTypeRepositoryInterface
     */
    private $repository;


    public function __construct(EntityManagerInterface $em, ActivityTypeRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $activities = $this->repository->findAll();
        return $activities;
    }
    public function create()
    {

        $activityType = new ActivityType();
        $activityType->isNew = true; // This dynamic property helps to track the new state of this entity
        $activityType->setId(Uuid::uuid4());
        $this->em->persist($activityType);

        return $activityType;
    }
}