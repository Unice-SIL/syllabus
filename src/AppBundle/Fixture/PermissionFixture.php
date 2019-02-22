<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class PermissionFixture
 * @package AppBundle\Fixture
 */
class PermissionFixture extends Fixture implements DependentFixtureInterface
{
       /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Permission 1
        $permission = new Permission();
        $permission->setId(Uuid::uuid4())
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1))
            ->setUser($this->getReference(UserFixture::USER_1))
            ->setPermission('WRITE');
        $manager->persist($permission);
        // Permission 2
        $permission = new Permission();
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
}