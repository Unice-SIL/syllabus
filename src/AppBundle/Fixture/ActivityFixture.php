<?php

namespace AppBundle\Fixture;

use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
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
    const ACTIVITY_3 = 'activity3';
    const ACTIVITY_4 = 'activity4';
    const ACTIVITY_5 = 'activity5';
    const ACTIVITY_6 = 'activity6';
    const ACTIVITY_7 = 'activity7';


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
            ->setType(ActivityType::ACTIVITY)
            ->setMode(ActivityMode::IN_CLASS)
            ->setGrp(ActivityGroup::HEAD)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_1, $activity1);

        // Activity 2
        $activity2 = new Activity();
        $activity2->setId(Uuid::uuid4())
            ->setLabel('Projet')
            ->setLabelVisibility(true)
            ->setType(ActivityType::ACTIVITY)
            ->setMode(ActivityMode::IN_CLASS)
            ->setGrp(ActivityGroup::GROUPS)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_2, $activity2);

        // Activity 3
        $activity3 = new Activity();
        $activity3->setId(Uuid::uuid4())
            ->setLabel('Etude de cas')
            ->setLabelVisibility(true)
            ->setType(ActivityType::ACTIVITY)
            ->setMode(ActivityMode::IN_CLASS)
            ->setGrp(ActivityGroup::TOGETHER)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_3, $activity3);

        // Activity 4
        $activity4 = new Activity();
        $activity4->setId(Uuid::uuid4())
            ->setLabel('Participation au forum')
            ->setLabelVisibility(true)
            ->setType(ActivityType::ACTIVITY)
            ->setMode(ActivityMode::IN_AUTONOMY)
            ->setGrp(ActivityGroup::INDIVIDUAL)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_4, $activity4);

        // Activity 5
        $activity5 = new Activity();
        $activity5->setId(Uuid::uuid4())
            ->setLabel('Exercices')
            ->setLabelVisibility(true)
            ->setType(ActivityType::ACTIVITY)
            ->setMode(ActivityMode::IN_AUTONOMY)
            ->setGrp(ActivityGroup::COLLECTIVE)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_5, $activity5);

        // Activity 6
        $activity6 = new Activity();
        $activity6->setId(Uuid::uuid4())
            ->setLabel('Mise en situation')
            ->setLabelVisibility(true)
            ->setType(ActivityType::EVALUATION)
            ->setMode(ActivityMode::EVAL_CC)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_6, $activity6);

        // Activity 7
        $activity7 = new Activity();
        $activity7->setId(Uuid::uuid4())
            ->setLabel('Test standardisé')
            ->setLabelVisibility(true)
            ->setType(ActivityType::EVALUATION)
            ->setMode(ActivityMode::EVAL_CT)
            ->setOrd(1)
            ->setObsolete(false);

        $this->addReference(self::ACTIVITY_7, $activity7);

        // Save
        $manager->persist($activity1);
        $manager->persist($activity2);
        $manager->persist($activity3);
        $manager->persist($activity4);
        $manager->persist($activity5);
        $manager->persist($activity6);
        $manager->persist($activity7);
        $manager->flush();
    }

}