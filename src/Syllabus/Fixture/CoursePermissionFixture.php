<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePermission;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CoursePermissionFixture
 * @package App\Syllabus\Fixture
 */
class CoursePermissionFixture extends AbstractFixture implements DependentFixtureInterface, FixtureGroupInterface
{
    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            CourseInfoFixture::COURSE_INFO_1 . '_' . UserFixture::USER_1 => [
                'permission' => Permission::WRITE,
                '@courseInfo' => CourseInfoFixture::COURSE_INFO_1,
                '@user' => UserFixture::USER_1
            ],
            CourseInfoFixture::COURSE_INFO_2 . '_' . UserFixture::USER_1 => [
                'permission' => Permission::WRITE,
                '@courseInfo' => CourseInfoFixture::COURSE_INFO_2,
                '@user' => UserFixture::USER_1
            ],
            CourseInfoFixture::COURSE_INFO_1 . '_' . UserFixture::USER_2 => [
                'permission' => Permission::WRITE,
                '@courseInfo' => CourseInfoFixture::COURSE_INFO_1,
                '@user' => UserFixture::USER_2
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return CoursePermission::class;
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            CourseInfoFixture::class,
            UserFixture::class
        ];
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}