<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CourseTutoringResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CourseTutoringResourceDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class CourseTutoringResourceDoctrineRepository extends ServiceEntityRepository
{
    /**
     * CourseTutoringResourceDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseTutoringResource::class);
    }
}