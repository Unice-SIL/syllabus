<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseTeacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseTeacherFixture
 * @package AppBundle\Fixture
 */
class CourseTeacherFixture extends Fixture implements DependentFixtureInterface
{
    /**
     *
     */
    const COURSE_TEACHER_1 = 'courseTeacher1';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseTeacher 1
        $courseTeacher = new CourseTeacher();
        $courseTeacher->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setFirstname('John')
            ->setLastname('DOE')
            ->setEmail('John.Doe@unice.fr')
            ->setManager(true);

        $this->addReference(self::COURSE_TEACHER_1, $courseTeacher);

        // Save
        $manager->persist($courseTeacher);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CourseInfoFixture::class,
            UserFixture::class
        ];
    }
}