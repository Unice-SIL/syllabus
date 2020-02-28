<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseTutoringResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class CourseTutoringResourceDoctrineRepository
 * @package AppBundle\Repository\Doctrine
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