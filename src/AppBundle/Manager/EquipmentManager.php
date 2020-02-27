<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Equipment;
use AppBundle\Repository\Doctrine\EquipmentDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class EquipmentManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EquipmentDoctrineRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, EquipmentDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function new()
    {
        return new Equipment();
    }

    /**
     * @param $id
     * @return Equipment|null
     */
    public function find($id): ?Equipment
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
     * @param Equipment $equipment
     */
    public function create(Equipment $equipment)
    {
        $this->em->persist($equipment);
        $this->em->flush();
    }

    /**
     * @param Equipment $equipment
     */
    public function update(Equipment $equipment): void
    {
        $this->em->flush();
    }

    /**
     * @param Equipment $equipment
     */
    public function delete(Equipment $equipment): void
    {
        $this->em->remove($equipment);
        $this->em->flush();
    }


}