<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseTutoringResource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseAchievementFixture
 * @package AppBundle\Fixture
 */
class CourseTutoringResourceFixture extends Fixture implements DependentFixtureInterface,  FixtureGroupInterface
{
    /**
     *
     */
    const COURSE_TUTORING_RESOURCE_1 = 'courseTutoringResource1';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseSection 1
        $courseTutoringResource = new CourseTutoringResource();
        $courseTutoringResource->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setDescription('Tutoring resource n°1');

        $this->addReference(self::COURSE_TUTORING_RESOURCE_1, $courseTutoringResource);

        // Save
        $manager->persist($courseTutoringResource);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CourseInfoFixture::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}