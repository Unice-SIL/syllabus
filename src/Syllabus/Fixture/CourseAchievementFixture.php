<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CourseAchievement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseAchievementFixture
 * @package App\Syllabus\Fixture
 */
class CourseAchievementFixture extends Fixture implements DependentFixtureInterface ,  FixtureGroupInterface
{
    /**
     *
     */
    const COURSE_ACHIEVEMENT_1 = 'courseAchievement1';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseSection 1
        $courseAchievement = new CourseAchievement();
        $courseAchievement->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setDescription('Achievement n°1');

        $this->addReference(self::COURSE_ACHIEVEMENT_1, $courseAchievement);

        // Save
        $manager->persist($courseAchievement);
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