<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CourseSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class CourseSectionDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class CourseSectionDoctrineRepository extends ServiceEntityRepository
{

    /**
     * CourseSectionDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseSection::class);
    }
}