<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\CriticalAchievement;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CriticalAchievementFixture extends AbstractFixture implements FixtureGroupInterface
{
    const CRITICAL_ACHIEVEMENT_1 = 'Critical Achievement 1';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::CRITICAL_ACHIEVEMENT_1 => [
                'label' => self::CRITICAL_ACHIEVEMENT_1,
                'obsolete' => false
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return CriticalAchievement::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }


}