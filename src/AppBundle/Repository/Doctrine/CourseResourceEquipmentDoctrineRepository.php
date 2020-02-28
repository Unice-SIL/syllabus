<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseResourceEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class CourseResourceEquipmentDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseResourceEquipmentDoctrineRepository extends ServiceEntityRepository
{

    /**
     * CourseResourceEquipmentDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseResourceEquipment::class);
    }
}