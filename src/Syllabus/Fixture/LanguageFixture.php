<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Language;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class LanguageFixture extends AbstractFixture  implements FixtureGroupInterface
{
    public const LANGUAGE_FR = 'Francais';
    public const LANGUAGE_EN = 'Anglais';
    public const LANGUAGE_DE = 'Allemand';
    public const LANGUAGE_IT = 'Italien';
    public const LANGUAGE_ES = 'Espagnol';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return  [
            self::LANGUAGE_FR => ['label' => self::LANGUAGE_FR],
            self::LANGUAGE_EN => ['label' => self::LANGUAGE_EN],
            self::LANGUAGE_DE => ['label' => self::LANGUAGE_DE],
            self::LANGUAGE_IT => ['label' => self::LANGUAGE_IT],
            self::LANGUAGE_ES => ['label' => self::LANGUAGE_ES]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Language::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}