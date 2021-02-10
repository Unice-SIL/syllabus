<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Equipment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class EquipmentFixture
 * @package App\Syllabus\Fixture
 */
class EquipmentFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const EQUIPMENT_1 = 'autre';
    public const EQUIPMENT_2 = 'calculatrice';
    public const EQUIPMENT_3 = 'ordinateur';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Autre
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Autre")
            ->setLabelVisibility(false);
        $this->addReference(self::EQUIPMENT_1, $equipment);
        $manager->persist($equipment);

        // Blouse blanche de laboratoire
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Blouse blanche de laboratoire")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Cahier / feuilles
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Cahier / feuilles")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Calculatrice programmable
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Calculatrice programmable")
            ->setLabelVisibility(true);
        $this->addReference(self::EQUIPMENT_2, $equipment);
        $manager->persist($equipment);

        // Calculatrice non programmable
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Calculatrice non programmable")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Code juridique
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Code juridique")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Écouteur / casque audio
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Écouteur / casque audio")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Équipement sportif
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Équipement sportif")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Feuille de partition de musique
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Feuille de partition de musique")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Livre
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Livre")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Logiciel
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Logiciel")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Matériel de dessin (crayons de couleurs, gomme…)
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Matériel de dessin (crayons de couleurs, gomme…)")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Matériel de géométrie (équerre, règle graduée, compas…)
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Matériel de géométrie (équerre, règle graduée, compas…)")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Microphone
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Microphone")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Ordinateur personnel (ou tablette)
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Ordinateur personnel / tablette")
            ->setLabelVisibility(true);
        $this->addReference(self::EQUIPMENT_3, $equipment);
        $manager->persist($equipment);

        // Papier (à dessin, millimétré, calque…)  
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Papier (à dessin, millimétré, calque…)")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Smartphone personnel 
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel("Smartphone personnel")
            ->setLabelVisibility(true);
        $manager->persist($equipment);

        // Flush
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}