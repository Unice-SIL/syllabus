<?php


namespace AppBundle\Manager;


use AppBundle\Entity\ActivityType;
use AppBundle\Repository\ActivityTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ActivityTypeManager
{
    /**
     * @var ObjectRepository
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

    public function create()
    {
        return new ActivityType();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $activitiesType = $this->repository->findAll();
        return $activitiesType;
    }
}