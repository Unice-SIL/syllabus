<?php

namespace AppBundle\Manager;

use AppBundle\Entity\ActivityMode;
use AppBundle\Repository\ActivityModeRepositoryInterface;
use AppBundle\Repository\Doctrine\ActivityModeDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ActivityModeManager
 * @package AppBundle\Manager
 */
class ActivityModeManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ActivityModeRepositoryInterface
     */
    private $repository;

    /**
     * ActivityModeManager constructor.
     * @param EntityManagerInterface $em
     * @param ActivityModeDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ActivityModeDoctrineRepository $repository)
    {
        $this->em = $em;
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
     * @param mixed $id
     * @return ActivityMode|null
     */
    public function find($id): ?ActivityMode
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
     * @param ActivityMode $activityMode
     */
    public function create(ActivityMode $activityMode)
    {
        $this->em->persist($activityMode);
        $this->em->flush();
    }

    /**
     * @param ActivityMode $activityMode
     */
    public function update(ActivityMode $activityMode)
    {
        $this->em->flush();
    }

    /**
     * @param ActivityMode $activityMode
     */
    public function delete(ActivityMode $activityMode)
    {
        $this->em->remove($activityMode);
        $this->em->flush();
    }

}