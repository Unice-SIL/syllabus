<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Repository\CourseResourceEquipmentRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseResourceEquipmentDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseResourceEquipmentDoctrineRepository extends AbstractDoctrineRepository implements CourseResourceEquipmentRepositoryInterface
{

    /**
     * UserDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find  course resource equipment by id
     * @param string $id
     * @return CourseResourceEquipment|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseResourceEquipment
    {
        $courseResourceEquipment = null;
        try{
            $courseResourceEquipment = $this->entityManager->getRepository(CourseResourceEquipment::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseResourceEquipment;
    }


    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     * @throws \Exception
     */
    public function create(CourseResourceEquipment $courseResourceEquipment): void
    {
        try{
            $this->entityManager->persist($courseResourceEquipment);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete a course resource equipment
     * @param CourseResourceEquipment $courseResourceEquipment
     * @throws \Exception
     */
    public function delete(CourseResourceEquipment $courseResourceEquipment): void
    {
        try {
            $this->entityManager->remove($courseResourceEquipment);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}