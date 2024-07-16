<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Repository\Doctrine\ActivityModeDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ActivityModeManager
 * @package App\Syllabus\Manager
 */
class ActivityModeManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var ActivityModeDoctrineRepository
     */
    private ActivityModeDoctrineRepository $repository;

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
    public function new(): ActivityMode
    {
        return new ActivityMode();
    }

    /**
     * @param mixed $id
     * @return ActivityMode|null
     */
    public function find(mixed $id): ?ActivityMode
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
    public function create(ActivityMode $activityMode): void
    {
        $this->em->persist($activityMode);
        $this->em->flush();
    }

    /**
     * @param ActivityMode $activityMode
     */
    public function update(ActivityMode $activityMode): void
    {
        $this->em->flush();
    }

    /**
     * @param ActivityMode $activityMode
     */
    public function delete(ActivityMode $activityMode): void
    {
        $this->em->remove($activityMode);
        $this->em->flush();
    }

}