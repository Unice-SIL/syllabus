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
}