<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\ActivityType;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActivityTypeFixture extends AbstractFixture implements FixtureGroupInterface, DependentFixtureInterface
{
    const ACTIVITY_TYPE_DISTANT = 'Distant';
    const ACTIVITY_TYPE_AUTONOMY = 'Autonomy';
    const ACTIVITY_TYPE_CLASS = 'Class';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::ACTIVITY_TYPE_DISTANT => [
                'label' => self::ACTIVITY_TYPE_DISTANT,
                '@activities' => [
                    ActivityFixture::ACTIVITY_1,
                    ActivityFixture::ACTIVITY_2,
                    ActivityFixture::ACTIVITY_4,
                    ActivityFixture::ACTIVITY_5
                ],
                '@activityModes' => [
                    ActivityModeFixture::ACTIVITY_MODE_1,
                    ActivityModeFixture::ACTIVITY_MODE_2
                ]
            ],
            self::ACTIVITY_TYPE_AUTONOMY => [
                'label' => self::ACTIVITY_TYPE_AUTONOMY,
                '@activities' => [
                    ActivityFixture::ACTIVITY_1,
                    ActivityFixture::ACTIVITY_2,
                    ActivityFixture::ACTIVITY_3,
                    ActivityFixture::ACTIVITY_4,
                    ActivityFixture::ACTIVITY_5,
                    ActivityFixture::ACTIVITY_6
                ],
                '@activityModes' => [
                    ActivityModeFixture::ACTIVITY_MODE_1
                ]
            ],
            self::ACTIVITY_TYPE_CLASS => [
                'label' => self::ACTIVITY_TYPE_CLASS,
                '@activities' => [
                    ActivityFixture::ACTIVITY_2,
                    ActivityFixture::ACTIVITY_3,
                    ActivityFixture::ACTIVITY_4,
                ],
                '@activityModes' => [
                    ActivityModeFixture::ACTIVITY_MODE_2
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return ActivityType::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }

    public function getDependencies()
    {
        return [
            ActivityFixture::class,
            ActivityModeFixture::class
        ];
    }
}