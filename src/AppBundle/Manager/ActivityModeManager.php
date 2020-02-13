<?php


namespace AppBundle\Manager;


use AppBundle\Entity\ActivityMode;
use AppBundle\Repository\ActivityModeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ActivityModeManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var ActivityModeRepositoryInterface
     */
    private $repository;


    public function __construct(EntityManagerInterface $em, ActivityModeRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create()
    {
        return new ActivityMode();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $activitiesmode = $this->repository->findAll();
        return $activitiesmode;
    }
}