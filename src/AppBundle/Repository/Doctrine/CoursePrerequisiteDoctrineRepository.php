<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CoursePrerequisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class CourseAchievementDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CoursePrerequisiteDoctrineRepository extends ServiceEntityRepository
{
    /**
     * CoursePrerequisiteDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursePrerequisite::class);
    }
}