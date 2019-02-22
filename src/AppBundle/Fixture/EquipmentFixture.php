<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Equipment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class EquipmentFixture
 * @package AppBundle\Fixture
 */
class EquipmentFixture extends Fixture
{
    /**
     *
     */
    public const EQUIPMENT_1 = 'equipment_1';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Calculatrice programmable')
            ->setIcon("test.png");
        $this->addReference(self::EQUIPMENT_1, $equipment);
        $manager->persist($equipment);
        $manager->flush();
    }

}