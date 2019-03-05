<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseSection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseSectionFixture
 * @package AppBundle\Fixture
 */
class CourseSectionFixture extends Fixture implements DependentFixtureInterface
{
    /**
     *
     */
    const COURSE_SECTION_1 = 'courseSection1';


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseSection 1
        $courseSection = new CourseSection();
        $courseSection->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setTitle('Chapitre 1')
            ->setDescription('Ceci est le chapitre 1 du cours')
            ->setSectionType($this->getReference(SectionTypeFixture::SECTION_TYPE_CHAPITRE));

        $this->addReference(self::COURSE_SECTION_1, $courseSection);

        // Save
        $manager->persist($courseSection);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CourseInfoFixture::class,
            SectionTypeFixture::class
        ];
    }
}