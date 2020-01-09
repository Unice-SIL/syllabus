<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Equipment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

class EquipmentManager
{
    /**
     * @var ObjectRepository
     */
    private $em;


    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function create()
    {

        $equipment = new Equipment();
        $equipment->isNew = true; // This dynamic property helps to track the new state of this entity
        $equipment->setId(Uuid::uuid4());
        $this->em->persist($equipment);

        return $equipment;
    }

}