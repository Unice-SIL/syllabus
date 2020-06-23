<?php


namespace AppBundle\Fixture;


use AppBundle\Entity\BakCourseEvaluationCt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BakCourseEvaluationCtFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        $courseEvaluationCt = new BakCourseEvaluationCt();
        $courseEvaluationCt->setActivity($this->getReference(BakActivityFixture::BAK_ACTIVITY_4))
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setDescription('Activity 4')
            ->setEvaluationRate(50)
            ->setPosition(4);
        $manager->persist($courseEvaluationCt);


        $manager->flush();
    }

    public function getDependencies(){
        return [
            BakActivityFixture::class
        ];
    }

}