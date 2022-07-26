<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Period;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class PeriodFixture extends AbstractFixture  implements FixtureGroupInterface
{
    public const PERIOD_1 = 'Mensuelle';
    public const PERIOD_2 = 'Trimestrielle';
    public const PERIOD_3 = 'Semestrielle';
    public const PERIOD_4 = 'Annuelle';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::PERIOD_1 => ['label' => self::PERIOD_1],
            self::PERIOD_2 => ['label' => self::PERIOD_2],
            self::PERIOD_3 => ['label' => self::PERIOD_3],
            self::PERIOD_4 => ['label' => self::PERIOD_4]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Period::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}