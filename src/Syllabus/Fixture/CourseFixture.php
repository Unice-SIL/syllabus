<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

/**
 * Class CourseFixture
 * @package App\Syllabus\Fixture
 */
class CourseFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const COURSE_1 = 'SLEPB111';
    public const COURSE_2 = 'SLUPB11';
    public const COURSE_3 = 'TEST';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        // Course 1
        $course1 = new Course();
        $course1->setId(Uuid::v4())
            ->setType('ECUE')
            ->setSource('fixtures')
            ->setCode(self::COURSE_1)
            ->setTitle('Cours 1');
        $this->addReference(self::COURSE_1, $course1);

        // Course 2
        $course2 = new Course();
        $course2->setId(Uuid::v4())
            ->setType('UE')
            ->setSource('fixtures')
            ->setCode(self::COURSE_2)
            ->setTitle('Cours 2');
        $this->addReference(self::COURSE_2, $course2);

        // Course 3
        $course3 = new Course();
        $course3->setId(Uuid::v4())
            ->setType('UE')
            ->setSource('fixtures')
            ->setCode(self::COURSE_3)
            ->setTitle('Cours 3');
        $this->addReference(self::COURSE_3, $course3);

        // Course hierarchy
        $course1->addParent($course2);
        $course1->addChild($course2);
        $course2->addParent($course1);
        $course2->addChild($course1);

        // Save
        $manager->persist($course1);
        $manager->persist($course2);
        $manager->persist($course3);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

}