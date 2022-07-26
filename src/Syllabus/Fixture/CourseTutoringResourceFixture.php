<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CourseTutoringResource;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseTutoringResourceFixture extends AbstractFixture implements DependentFixtureInterface, FixtureGroupInterface
{
    const COURSE_TUTORING_RESOURCE_1 = 'Tutoring resource n°1';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::COURSE_TUTORING_RESOURCE_1 => [
                'description' => self::COURSE_TUTORING_RESOURCE_1,
                '@courseInfo' => CourseInfoFixture::COURSE_INFO_1
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return CourseTutoringResource::class;
    }

    /**
     * @return array
     */
    public function getDependencies(): array
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