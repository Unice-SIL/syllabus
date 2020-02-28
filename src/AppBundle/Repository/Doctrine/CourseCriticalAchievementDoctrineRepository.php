<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\CourseCriticalAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CourseCriticalAchievementDoctrineRepository extends ServiceEntityRepository
{
    /**
     * CourseCriticalAchievementDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseCriticalAchievement::class);
    }
}