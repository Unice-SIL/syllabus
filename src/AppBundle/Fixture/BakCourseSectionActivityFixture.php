<?php


namespace AppBundle\Fixture;


use AppBundle\Entity\BakActivity;
use AppBundle\Entity\BakCourseSectionActivity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BakCourseSectionActivityFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $courseSectionActivity = new BakCourseSectionActivity();
        $courseSectionActivity->setActivity($this->getReference(BakActivityFixture::BAK_ACTIVITY_1))
            ->setCourseSection($this->getReference(CourseSectionFixture::COURSE_SECTION_1))
            ->setDescription('Activity 1')
            ->setPosition(1);
        $manager->persist($courseSectionActivity);

        $courseSectionActivity = new BakCourseSectionActivity();
        $courseSectionActivity->setActivity($this->getReference(BakActivityFixture::BAK_ACTIVITY_2))
            ->setCourseSection($this->getReference(CourseSectionFixture::COURSE_SECTION_1))
            ->setDescription('Activity 2')
            ->setPosition(2);
        $manager->persist($courseSectionActivity);

        $courseSectionActivity = new BakCourseSectionActivity();
        $courseSectionActivity->setActivity($this->getReference(BakActivityFixture::BAK_ACTIVITY_3))
            ->setCourseSection($this->getReference(CourseSectionFixture::COURSE_SECTION_1))
            ->setDescription('Activity 3')
            ->setEvaluationRate(30)
            ->setEvaluationPeer(true)
            ->setEvaluationTeacher(true)
            ->setPosition(3);
        $manager->persist($courseSectionActivity);


        $manager->flush();
    }

    public function getDependencies(){
        return [
            BakActivityFixture::class,
            CourseSectionFixture::class
        ];
    }
}