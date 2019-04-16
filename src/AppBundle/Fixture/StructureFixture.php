<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Structure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class StructureFixture
 * @package AppBundle\Fixture
 */
class StructureFixture extends Fixture
{
    /**
     *
     */
    const SCIENCES = 'structureSciences';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $structure = new Structure();
        $structure->setId(Uuid::uuid4())
            ->setLabel('UFR Sciences')
            ->setEtbId('SCI')
            ->setCampus('Valrose');
        $this->addReference(self::SCIENCES, $structure);
        $manager->persist($structure);
        $manager->flush();
    }
}