<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\Teaching;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * TeachingRepository
 *
 */
class TeachingDoctrineRepository extends ServiceEntityRepository
{
    /**
     * StructureDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teaching::class);
    }

}
