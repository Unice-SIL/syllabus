<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\ActivityMode;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ActivityModeFixture extends AbstractFixture implements FixtureGroupInterface
{
    const ACTIVITY_MODE_1 = 'Together';
    const ACTIVITY_MODE_2 = 'Groups';
    const ACTIVITY_MODE_3 = 'Individual';

    /**
     * @return array[]
     */
    protected function getDataEntities(): array
    {
        return [
            self::ACTIVITY_MODE_1 => [
                'label' => self::ACTIVITY_MODE_1,
                'obsolete' => false
            ],
            self::ACTIVITY_MODE_2 => [
                'label' => self::ACTIVITY_MODE_2,
                'obsolete' => false
            ],
            self::ACTIVITY_MODE_3 => [
                'label' => self::ACTIVITY_MODE_3,
                'obsolete' => false
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return ActivityMode::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }

}