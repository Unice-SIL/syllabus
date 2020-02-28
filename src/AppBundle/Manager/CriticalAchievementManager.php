<?php

namespace AppBundle\Manager;

use AppBundle\Entity\CriticalAchievement;
use AppBundle\Repository\Doctrine\CriticalAchievementDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class CriticalAchievementManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CriticalAchievementDoctrineRepository
     */
    private $repository;

    /**
     * CriticalAchievementManager constructor.
     * @param EntityManagerInterface $em
     * @param CriticalAchievementDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CriticalAchievementDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return CriticalAchievement
     */
    public function new()
    {
        return new CriticalAchievement();
    }

    /**
     * @param $id
     * @return CriticalAchievement
     */
    public function find($id): CriticalAchievement
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
     * @param CriticalAchievement $criticalAchievement
     */
    public function create(CriticalAchievement $criticalAchievement): void
    {
        $this->em->persist($criticalAchievement);
        $this->em->flush();
    }

    /**
     * @param CriticalAchievement $criticalAchievement
     */
    public function update(CriticalAchievement $criticalAchievement): void
    {
        $this->em->flush();
    }

    /**
     * @param CriticalAchievement $criticalAchievement
     */
    public function delete(CriticalAchievement $criticalAchievement): void
    {
        $this->em->remove($criticalAchievement);
        $this->em->flush();
    }
}