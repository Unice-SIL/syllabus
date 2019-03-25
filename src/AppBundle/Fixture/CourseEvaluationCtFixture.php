<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseEvaluationCt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseEvaluationCtFixture
 * @package AppBundle\Fixture
 */
class CourseEvaluationCtFixture extends Fixture implements DependentFixtureInterface
{
    /**
     *
     */
    const COURSE_EVALUATION_CT_1 = 'courseEvaluationCt1';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseEvaluationCt 1
        $courseEvaluationCt1 = new CourseEvaluationCt();
        $courseEvaluationCt1->setId(Uuid::uuid4())
            ->setDescription('')
            ->setOrder(1)
            ->setActivity($this->getReference(ActivityFixture::ACTIVITY_7))
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1));

        $this->addReference(self::COURSE_EVALUATION_CT_1, $courseEvaluationCt1);

        // Save
        $manager->persist($courseEvaluationCt1);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            ActivityFixture::class,
            CourseInfoFixture::class
        ];
    }
}