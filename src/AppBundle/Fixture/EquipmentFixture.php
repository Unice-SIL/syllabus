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
    public const EQUIPMENT_2 = 'equipment_2';
    public const EQUIPMENT_3 = 'equipment_3';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Equipment 1
        $equipment1 = new Equipment();
        $equipment1->setId(Uuid::uuid4())
            ->setLabel('Calculatrice programmable')
            ->setIcon("calculatrice.png")
            ->setLabelVisibility(true);
        $this->addReference(self::EQUIPMENT_1, $equipment1);
        $manager->persist($equipment1);

        // Equipment 2
        $equipment2 = new Equipment();
        $equipment2->setId(Uuid::uuid4())
            ->setLabel('Blouse blanche')
            ->setIcon("blouse.png")
            ->setLabelVisibility(true);
        $this->addReference(self::EQUIPMENT_2, $equipment2);
        $manager->persist($equipment2);

        // Equipment 3
        $equipment3 = new Equipment();
        $equipment3->setId(Uuid::uuid4())
            ->setLabel('Autre')
            ->setLabelVisibility(false);
        $this->addReference(self::EQUIPMENT_3, $equipment3);
        $manager->persist($equipment3);

        // Flush
        $manager->flush();
    }

}