<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseSectionActivity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseSectionFixture
 * @package AppBundle\Fixture
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
        $courseSectionActivity1->setId(Uuid::uuid4())
            ->setDescription('')
            ->setOrder(1)
            ->setActivity($this->getReference(ActivityFixture::ACTIVITY_1))
            ->setCourseSection($this->getReference(CourseSectionFixture::COURSE_SECTION_1));

        $this->addReference(self::COURSE_SECTION_ACTIVITY_1, $courseSectionActivity1);

        // CourseSectionActivity 2
        $courseSectionActivity2 = new CourseSectionActivity();
        $courseSectionActivity2->setId(Uuid::uuid4())
            ->setDescription('Projet Syllabus')
            ->setOrder(2)
            ->setActivity($this->getReference(ActivityFixture::ACTIVITY_2))
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