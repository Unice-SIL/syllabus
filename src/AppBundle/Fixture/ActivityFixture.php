<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Activity;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\SectionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class ActivityFixture
 * @package AppBundle\Fixture
 */
class ActivityFixture extends Fixture
{
    /**
     *
     */
    const ACTIVITY_1 = 'activity1';
    const ACTIVITY_2 = 'activity2';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Activity 1
        $activity1 = new Activity();
        $activity1->setId(Uuid::uuid4())
            ->setLabel('Cours Magistraux')
            ->setLabelVisibility(true)
            ->setDistant(false)
            ->setTeacher(false)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_1, $activity1);

        // Activity 2
        $activity2 = new Activity();
        $activity2->setId(Uuid::uuid4())
            ->setLabel('Projet')
            ->setLabelVisibility(true)
            ->setDistant(true)
            ->setTeacher(true)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_2, $activity2);

        // Save
        $manager->persist($activity1);
        $manager->persist($activity2);
        $manager->flush();
    }

}