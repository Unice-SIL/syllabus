<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Entity\CourseSection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CoursePrerequisiteFixture
 * @package App\Syllabus\Fixture
 */
class CoursePrerequisiteFixture extends Fixture implements DependentFixtureInterface,  FixtureGroupInterface
{
    /**
     *
     */
    const COURSE_PREREQUISITE_1 = 'coursePrerequisite1';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseSection 1
        $coursePrerequisite = new CoursePrerequisite();
        $coursePrerequisite->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setDescription('Prerequisite n°1');

        $this->addReference(self::COURSE_PREREQUISITE_1, $coursePrerequisite);

        // Save
        $manager->persist($coursePrerequisite);
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