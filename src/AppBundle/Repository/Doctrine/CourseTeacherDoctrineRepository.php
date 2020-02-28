<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseTeacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class CourseTeacherDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseTeacherDoctrineRepository extends ServiceEntityRepository
{

    /**
     * CourseTeacherDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseTeacher::class);
    }
}