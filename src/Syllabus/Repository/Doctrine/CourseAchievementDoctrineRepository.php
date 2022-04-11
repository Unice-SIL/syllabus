<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CourseAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CourseAchievementDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class CourseAchievementDoctrineRepository extends ServiceEntityRepository
{

    /**
     * CourseAchievementDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseAchievement::class);
    }

}