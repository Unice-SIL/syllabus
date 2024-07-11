<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CourseSectionActivity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

/**
 * Class CourseSectionFixture
 * @package App\Syllabus\Fixture
 */
class CourseSectionActivityFixture extends Fixture implements DependentFixtureInterface,  FixtureGroupInterface
{
    /**
     *
     */
    const COURSE_SECTION_ACTIVITY_1 = 'courseSectionActivity1';
    const COURSE_SECTION_ACTIVITY_2 = 'courseSectionActivity2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseSectionActivity 1
        $courseSectionActivity1 = new CourseSectionActivity();
        $courseSectionActivity1->setId(Uuid::v4())
            ->setDescription('')
            ->setPosition(1)
            ->setActivity($this->getReference(ActivityFixture::ACTIVITY_1))
            ->setActivityType($this->getReference(ActivityTypeFixture::ACTIVITY_TYPE_DISTANT))
            ->setActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_1))
            ->setCourseSection($this->getReference(CourseSectionFixture::COURSE_SECTION_1));

        $this->addReference(self::COURSE_SECTION_ACTIVITY_1, $courseSectionActivity1);

        // CourseSectionActivity 2
        $courseSectionActivity2 = new CourseSectionActivity();
        $courseSectionActivity2->setId(Uuid::v4())
            ->setDescription('Projet Syllabus')
            ->setPosition(2)
            ->setActivity($this->getReference(ActivityFixture::ACTIVITY_2))
            ->setActivityType($this->getReference(ActivityTypeFixture::ACTIVITY_TYPE_DISTANT))
            ->setActivityMode($this->getReference(ActivityModeFixture::ACTIVITY_MODE_1))
            ->setCourseSection($this->getReference(CourseSectionFixture::COURSE_SECTION_1));

        $this->addReference(self::COURSE_SECTION_ACTIVITY_2, $courseSectionActivity2);

        // Save
        $manager->persist($courseSectionActivity1);
        $manager->persist($courseSectionActivity2);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            ActivityFixture::class,
            CourseSectionFixture::class
        ];
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}