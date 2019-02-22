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
        // Course 2
        $course = new Course();
        $course->setId(Uuid::uuid4())
            ->setType('UE')
            ->setEtbId('SLUPB11');
        $this->addReference(self::COURSE_2, $course);
        $manager->persist($course);
        // Course 1
        $course = new Course();
        $course->setId(Uuid::uuid4())
            ->setType('ECUE')
            ->setEtbId('SLEPB111')
            ->addCourseParent($this->getReference(CourseFixture::COURSE_2));
        $this->addReference(self::COURSE_1, $course);
        $manager->persist($course);
        // flush
        $manager->flush();
    }

}