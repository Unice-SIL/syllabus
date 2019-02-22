<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CourseInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseInfoFixture
 * @package AppBundle\Fixture
 */
class CourseInfoFixture extends Fixture implements DependentFixtureInterface
{
    /**
     *
     */
    public const COURSE_INFO_1 = 'courseInfo1';
    public const COURSE_INFO_2 = 'courseInfo2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Course info 1
        $courseInfo = new CourseInfo();
        $courseInfo->setId(Uuid::uuid4())
            ->setCourse($this->getReference(CourseFixture::COURSE_1))
            ->setYear($this->getReference(YearFixture::YEAR_2018))
            ->setStructure($this->getReference(StructureFixture::SCIENCES))
            ->setTitle('ECUE Intro à la microbiologie et la Pharmacopée européenne')
            ->setTeachingMode('class')
            ->setTeachingCmClass(4)
            ->setTeachingTpClass(8)
            ->setMccCapitalizable(true)
            ->setMccWeight(50)
            ->setMccCcCoeffSession1(30)
            ->setMccCcNbEvalSession1(3)
            ->setMccCtCoeffSession1(70)
            ->setMccCtDurationSession1('1h')
            ->setMccCtCoeffSession2(100)
            ->setMccCtDurationSession2('1h');
        $this->addReference(self::COURSE_INFO_1, $courseInfo);
        $manager->persist($courseInfo);
        // Course info 2
        $courseInfo = new CourseInfo();
        $courseInfo->setId(Uuid::uuid4())
            ->setCourse($this->getReference(CourseFixture::COURSE_2))
            ->setYear($this->getReference(YearFixture::YEAR_2018))
            ->setStructure($this->getReference(StructureFixture::SCIENCES))
            ->setTitle('UE1 Génie biologique et biologie moléculaire')
            ->setEcts(9);
        $this->addReference(self::COURSE_INFO_2, $courseInfo);
        $manager->persist($courseInfo);
        // flush
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(){
        return [
            CourseFixture::class,
            StructureFixture::class,
            YearFixture::class
        ];
    }
}