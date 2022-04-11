<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Level;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class LevelFixture extends AbstractFixture implements FixtureGroupInterface
{
    public const LEVEL_L1 = 'Licence 1';
    public const LEVEL_L2 = 'Licence 2';
    public const LEVEL_L3 = 'Licence 3';

    /**
     * @return string[][]
     */
    protected function getDataEntities(): array
    {
        return [
            self::LEVEL_L1 => ['label' => self::LEVEL_L1],
            self::LEVEL_L2 => ['label' => self::LEVEL_L2],
            self::LEVEL_L3 => ['label' => self::LEVEL_L3],
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Level::class;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}