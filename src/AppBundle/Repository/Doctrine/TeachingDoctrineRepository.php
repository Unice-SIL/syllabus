<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Teaching;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

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
