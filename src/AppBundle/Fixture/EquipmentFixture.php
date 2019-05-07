<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Equipment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class EquipmentFixture
 * @package AppBundle\Fixture
 */
class EquipmentFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const EQUIPMENT_1 = 'calculatrice';
    public const EQUIPMENT_2 = 'ordinateur';
    public const EQUIPMENT_3 = 'equipment_3';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Calculatrice programmable
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Calculatrice programmable')
            ->setLabelVisibility(true);
        $this->addReference(self::EQUIPMENT_1, $equipment);
        $manager->persist($equipment);

        // Calculatrice non programmable
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Calculatrice non programmable')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Ordinateur personnel (ou tablette)
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Ordinateur personnel (ou tablette)')
            ->setLabelVisibility(true);
        $this->addReference(self::EQUIPMENT_2, $equipment);
        $manager->persist($equipment);

        // Smartphone personnel 
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Smartphone personnel')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Papier millimétré 
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Papier millimétré')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Feuille de partition de musique
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Feuille de partition de musique')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Ecouteur / Casque audio
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Ecouteur / Casque audio')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Microphone
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Microphone')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Livre (à préciser par l’enseignant)
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('Livre (à préciser par l’enseignant)')
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Autre
        $equipment3 = new Equipment();
        $equipment3->setId(Uuid::uuid4())
            ->setLabel('Autre')
            ->setLabelVisibility(false);
        $this->addReference(self::EQUIPMENT_3, $equipment3);
        $manager->persist($equipment3);

        // Flush
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}