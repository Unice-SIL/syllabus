<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Structure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class StructureFixture
 * @package App\Syllabus\Fixture
 */
class StructureFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    const SCIENCES = 'structureSciences';
    const LAS = 'structureLAS';
    const LA = 'structureLA';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $structure = new Structure();
        $structure->setId(Uuid::uuid4())
            ->setLabel('UFR Sciences')
            ->setCode('SCI');
        $this->addReference(self::SCIENCES, $structure);
        $manager->persist($structure);

        $structure = new Structure();
        $structure->setId(Uuid::uuid4())
            ->setLabel('UFR LASH')
            ->setCode('LAS');
        $this->addReference(self::LAS, $structure);
        $manager->persist($structure);

        $structure = new Structure();
        $structure->setId(Uuid::uuid4())
            ->setLabel('UFR LASH UCA')
            ->setCode('LA');
        $this->addReference(self::LA, $structure);
        $manager->persist($structure);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}