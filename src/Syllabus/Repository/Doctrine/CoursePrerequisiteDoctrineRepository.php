<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CoursePrerequisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CourseAchievementDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
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