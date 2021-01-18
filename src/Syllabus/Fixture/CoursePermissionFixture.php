<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePermission;
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
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $coursePermissions = [
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_1,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_1,
                'permission' => Permission::WRITE
            ],
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_2,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_1,
                'permission' => Permission::WRITE
            ],
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_1,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_2,
                'permission' => Permission::WRITE
            ],
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_1,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_FREDERIC,
                'permission' => Permission::WRITE
            ],
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_1,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_STEPHANE,
                'permission' => Permission::WRITE
            ],
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_1,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_KEVIN,
                'permission' => Permission::WRITE
            ],
            [
                'courseInfoRef' => CourseInfoFixture::COURSE_INFO_1,
                'userRef' => UserFixture::REF_PREFIX . UserFixture::USER_SALIM,
                'permission' => Permission::WRITE
            ],
        ];

        foreach ($coursePermissions as $coursePermissionFixture) {
            $permission = new CoursePermission();
            $permission->setId(Uuid::uuid4())
                ->setCourseInfo($this->getReference($coursePermissionFixture['courseInfoRef']))
                ->setUser($this->getReference($coursePermissionFixture['userRef']))
                ->setPermission($coursePermissionFixture['permission']);
            $manager->persist($permission);
        }

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