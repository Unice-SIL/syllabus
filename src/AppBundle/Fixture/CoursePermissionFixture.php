<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\CoursePermission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CoursePermissionFixture
 * @package AppBundle\Fixture
 */
class CoursePermissionFixture extends Fixture implements DependentFixtureInterface,  FixtureGroupInterface
{
       /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Permission 1
        $permission = new CoursePermission();
        $permission->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setUser($this->getReference(UserFixture::USER_1))
            ->setPermission('WRITE');
        $manager->persist($permission);
        // Permission 2
        $permission = new CoursePermission();
        $permission->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_2))
            ->setUser($this->getReference(UserFixture::USER_1))
            ->setPermission('WRITE');
        $manager->persist($permission);
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

    public static function getGroups(): array
    {
        return ['test'];
    }
}