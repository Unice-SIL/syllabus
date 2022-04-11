<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CourseResourceEquipment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseAchievementFixture
 * @package App\Syllabus\Fixture
 */
class CourseResourceEquipmentFixture extends Fixture implements DependentFixtureInterface,  FixtureGroupInterface
{
    /**
     *
     */
    const COURSE_RESOURCE_EQUIPMENT_1 = 'courseResourceEquipment1';
    const COURSE_RESOURCE_EQUIPMENT_2 = 'courseResourceEquipment2';
    const COURSE_RESOURCE_EQUIPMENT_3 = 'courseResourceEquipment3';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // CourseResourceEquipment 1
        $courseResourceEquipment1 = new CourseResourceEquipment();
        $courseResourceEquipment1->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setEquipment($this->getReference(EquipmentFixture::EQUIPMENT_1));
        $this->addReference(self::COURSE_RESOURCE_EQUIPMENT_1, $courseResourceEquipment1);
        $manager->persist($courseResourceEquipment1);

        // CourseResourceEquipment 2
        $courseResourceEquipment2 = new CourseResourceEquipment();
        $courseResourceEquipment2->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setEquipment($this->getReference(EquipmentFixture::EQUIPMENT_2))
            ->setDescription('Texas Instruments ');
        $this->addReference(self::COURSE_RESOURCE_EQUIPMENT_2, $courseResourceEquipment2);
        $manager->persist($courseResourceEquipment2);

        // CourseResourceEquipment 3
        $courseResourceEquipment3 = new CourseResourceEquipment();
        $courseResourceEquipment3->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setEquipment($this->getReference(EquipmentFixture::EQUIPMENT_3));
        $this->addReference(self::COURSE_RESOURCE_EQUIPMENT_3, $courseResourceEquipment3);
        $manager->persist($courseResourceEquipment3);

        // Flush
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

    public static function getGroups(): array
    {
        return ['test'];
    }
}