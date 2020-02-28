<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseAchievementDoctrineRepository
 * @package AppBundle\Repository\Doctrine
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