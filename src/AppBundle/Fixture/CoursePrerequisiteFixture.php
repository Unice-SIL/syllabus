<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseSection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CoursePrerequisiteFixture
 * @package AppBundle\Fixture
 */
class CoursePrerequisiteFixture extends Fixture implements DependentFixtureInterface
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
}