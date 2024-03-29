<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CourseInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseInfoFixture
 * @package App\Syllabus\Fixture
 */
class CourseInfoFixture extends Fixture implements DependentFixtureInterface,  FixtureGroupInterface
{
    /**
     *
     */
    public const COURSE_INFO_1 = 'courseInfo1';
    public const COURSE_INFO_2 = 'courseInfo2';
    public const COURSE_INFO_3 = 'courseInfo3';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $demains = new ArrayCollection();
        $demains->add($this->getReference(DomainFixture::DOMAIN_1));

        $periods = new ArrayCollection();
        $periods->add($this->getReference(PeriodFixture::PERIOD_1));

        $levels = new ArrayCollection();
        $levels->add($this->getReference(LevelFixture::LEVEL_L1));

        $campus = new ArrayCollection();
        $campus->add($this->getReference(CampusFixture::CAMPUS_1));

        $languages = new ArrayCollection();
        $languages->add($this->getReference(LanguageFixture::LANGUAGE_FR));

        // Course info 1
        $courseInfo = new CourseInfo();
        $courseInfo->setId('00000000-aaaa-bbbb-cccc-dddddddddddd')
            ->setCourse($this->getReference(CourseFixture::COURSE_1))
            ->setYear($this->getReference(YearFixture::YEAR_2018))
            ->setStructure($this->getReference(StructureFixture::SCIENCES))
            ->setTitle('ECUE Intro à la microbiologie et la Pharmacopée européenne')
            ->setTeachingMode('class')
            ->setTeachingCmClass(4)
            ->setTeachingTpClass(8)
            ->setMccCompensable(false)
            ->setMccCapitalizable(true)
            ->setMccWeight(50)
            ->setMccCcCoeffSession1(30)
            ->setMccCcNbEvalSession1(3)
            ->setMccCtCoeffSession1(70)
            ->setMccCtDurationSession1('1h')
            ->setMccCtCoeffSession2(100)
            ->setMccCtDurationSession2('1h')
            ->setCreationDate(new \DateTime())
            ->setLanguages($languages)
            ->setLevels($levels)
            ->setCampuses($campus)
            ->setPeriods($periods)
            ->setDomains($demains)
            ->setSummary('Mon résumé')
        ;
        $this->addReference(self::COURSE_INFO_1, $courseInfo);
        $manager->persist($courseInfo);

        // Course info 2
        $courseInfo = new CourseInfo();
        $courseInfo->setId('00000001-aaaa-bbbb-cccc-dddddddddddd')
            ->setCourse($this->getReference(CourseFixture::COURSE_2))
            ->setYear($this->getReference(YearFixture::YEAR_2018))
            ->setStructure($this->getReference(StructureFixture::SCIENCES))
            ->setTitle('UE1 Génie biologique et biologie moléculaire')
            ->setMccCompensable(true)
            ->setMccCapitalizable(false)
            ->setEcts(9)
            ->setCreationDate(new \DateTime());
        $this->addReference(self::COURSE_INFO_2, $courseInfo);
        $manager->persist($courseInfo);

        // Course info 3
        $courseInfo = new CourseInfo();
        $courseInfo->setId('00000001-aaaa-bbbb-cccc-dddddddddddd')
            ->setCourse($this->getReference(CourseFixture::COURSE_3))
            ->setYear($this->getReference(YearFixture::YEAR_2018))
            ->setStructure($this->getReference(StructureFixture::SCIENCES))
            ->setTitle('Cours sans permission')
            ->setMccCompensable(true)
            ->setMccCapitalizable(false)
            ->setEcts(9)
            ->setCreationDate(new \DateTime());
        $this->addReference(self::COURSE_INFO_3, $courseInfo);
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
            YearFixture::class,
            LevelFixture::class,
            CampusFixture::class,
            LanguageFixture::class,
            PeriodFixture::class,
            DomainFixture::class
        ];
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}