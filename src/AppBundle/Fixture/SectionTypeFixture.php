<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseSection;
use AppBundle\Entity\SectionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class SectionTypeFixture
 * @package AppBundle\Fixture
 */
class SectionTypeFixture extends Fixture
{
    /**
     *
     */
    const SECTION_TYPE_CHAPITRE = 'chapitre';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // SectionType 1
        $sectionType = new SectionType();
        $sectionType->setId(Uuid::uuid4())
            ->setCode('chapitre')
            ->setLabel('Chapitre')
            ->setObsolete(false)
            ->setOrder(0);

        $this->addReference(self::SECTION_TYPE_CHAPITRE, $sectionType);

        // Save
        $manager->persist($sectionType);
        $manager->flush();
    }

}