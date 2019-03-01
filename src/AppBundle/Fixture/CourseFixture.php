<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseFixture
 * @package AppBundle\Fixture
 */
class CourseFixture extends Fixture
{
    /**
     *
     */
    public const COURSE_1 = 'course1';
    public const COURSE_2 = 'course2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Course 1
        $course1 = new Course();
        $course1->setId(Uuid::uuid4())
            ->setType('ECUE')
            ->setEtbId('SLEPB111');
        $this->addReference(self::COURSE_1, $course1);

        // Course 2
        $course2 = new Course();
        $course2->setId(Uuid::uuid4())
            ->setType('UE')
            ->setEtbId('SLUPB11');
        $this->addReference(self::COURSE_2, $course2);

        // Course hierarchy
        $course1->addCourseParent($course2);
        $course2->addCourseChild($course1);

        // Save
        $manager->persist($course1);
        $manager->persist($course2);
        $manager->flush();
    }

}