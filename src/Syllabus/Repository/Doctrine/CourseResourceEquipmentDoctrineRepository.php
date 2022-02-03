<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CourseResourceEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CourseResourceEquipmentDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
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