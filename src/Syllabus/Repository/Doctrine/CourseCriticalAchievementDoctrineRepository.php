<?php


namespace App\Syllabus\Repository\Doctrine;


use App\Syllabus\Entity\CourseCriticalAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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