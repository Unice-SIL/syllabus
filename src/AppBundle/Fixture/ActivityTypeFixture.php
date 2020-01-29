<?php

namespace AppBundle\Fixture;


use AppBundle\Entity\ActivityType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ActivityTypeFixture extends Fixture implements FixtureGroupInterface
{
    /**
     *
     */
    const ACTIVITY_TYPE_1 = 'activity_type1';
    const ACTIVITY_TYPE_2 = 'activity_type2';
    const ACTIVITY_TYPE_3 = 'activity_type3';

    public function load(ObjectManager $manager)
    {
        $activityType = new ActivityType();
        $activityType->setId(Uuid::uuid4())
            ->setLabel("Autonomy")
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_1))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_1))
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_TYPE_1, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType->setId(Uuid::uuid4())
            ->setLabel("Class")
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_2))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_2))
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_TYPE_2, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType->setId(Uuid::uuid4())
            ->setLabel("A distance")
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_1))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_2))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_1))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_2))
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_TYPE_3, $activityType);
        $manager->persist($activityType);

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