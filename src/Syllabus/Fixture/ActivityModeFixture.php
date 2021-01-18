<?php

namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\ActivityMode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ActivityModeFixture extends Fixture implements FixtureGroupInterface
{
    /**
     *
     */
    const ACTIVITY_MODE_1 = 'activity_mode1';
    const ACTIVITY_MODE_2 = 'activity_mode2';
    const ACTIVITY_MODE_3 = 'activity_mode3';

    public function load(ObjectManager $manager)
    {
        $activityMode = new ActivityMode();
        $activityMode->setId(Uuid::uuid4())
            ->setLabel("Together")
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_MODE_1, $activityMode);
        $manager->persist($activityMode);

        $activityMode = new ActivityMode();
        $activityMode->setId(Uuid::uuid4())
            ->setLabel("Groups")
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_MODE_2, $activityMode);
        $manager->persist($activityMode);

        $activityMode = new ActivityMode();
        $activityMode->setId(Uuid::uuid4())
            ->setLabel("Individual")
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_MODE_3, $activityMode);
        $manager->persist($activityMode);

        $manager->flush();
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}