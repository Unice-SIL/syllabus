<?php

namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\ActivityType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ActivityTypeFixture extends Fixture implements FixtureGroupInterface
{
    /**
     *
     */
    const ACTIVITY_TYPE_DISTANT = 'Distant';
    const ACTIVITY_TYPE_AUTONOMY = 'Autonomy';
    const ACTIVITY_TYPE_CLASS = 'Class';

    public function load(ObjectManager $manager)
    {
        $activityType = new ActivityType();
        $activityType
            ->setLabel(self::ACTIVITY_TYPE_DISTANT)
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_1))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_2))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_4))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_5))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_1))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_2))
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_TYPE_CLASS, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setLabel(self::ACTIVITY_TYPE_AUTONOMY)
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_1))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_2))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_3))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_4))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_5))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_6))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_7))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_1))
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_TYPE_DISTANT, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setLabel(self::ACTIVITY_TYPE_CLASS)
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_2))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_3))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_4))
            ->addActivity($this->getReference(ActivityFixture::ACTIVITY_7))
            ->addActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_2))
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_TYPE_AUTONOMY, $activityType);
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