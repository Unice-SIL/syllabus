<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CampusFixture extends AbstractFixture  implements FixtureGroupInterface
{
    public const CAMPUS_1 = 'Valrose';
    public const CAMPUS_2 = 'Carlone';
    public const CAMPUS_3 = 'St Angely';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::CAMPUS_1 => ['label' => self::CAMPUS_1],
            self::CAMPUS_2 => ['label' => self::CAMPUS_2],
            self::CAMPUS_3 => ['label' => self::CAMPUS_3]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Campus::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}