<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseResourceEquipment;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Repository\Doctrine\CourseResourceEquipmentDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CourseResourceEquipmentManager
 * @package AppBundle\Manager
 */
class CourseResourceEquipmentManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CourseResourceEquipmentDoctrineRepository
     */
    private $repository;

    /**
     * CourseResourceEquipmentManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseResourceEquipmentDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseResourceEquipmentDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param CourseInfo|null $courseInfo
     * @param Equipment|null $equipment
     * @return CourseResourceEquipment
     */
    public function new(CourseInfo $courseInfo = null, Equipment $equipment = null)
    {
        $courseResourceEquipment = new CourseResourceEquipment();
        $courseResourceEquipment->setCourseInfo($courseInfo)->setEquipment($equipment);
        return $courseResourceEquipment;
    }

    /**
     * @param string $id
     * @return CourseResourceEquipment|null
     */
    public function find(string $id): ?CourseResourceEquipment
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     */
    public function create(CourseResourceEquipment $courseResourceEquipment): void
    {
        $this->em->persist($courseResourceEquipment);
        $this->em->flush();
    }

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     */
    public function update(CourseResourceEquipment $courseResourceEquipment): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     */
    public function delete(CourseResourceEquipment $courseResourceEquipment): void
    {
        $this->em->remove($courseResourceEquipment);
        $this->em->flush();
    }

}