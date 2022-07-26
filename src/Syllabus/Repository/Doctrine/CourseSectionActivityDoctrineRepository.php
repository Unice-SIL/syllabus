<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CourseSectionActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CourseSectionActivityDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class CourseSectionActivityDoctrineRepository extends ServiceEntityRepository
{

    /**
     * CourseSectionActivityDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseSectionActivity::class);
    }
}