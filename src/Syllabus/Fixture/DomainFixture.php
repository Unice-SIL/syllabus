<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Domain;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DomainFixture extends AbstractFixture  implements FixtureGroupInterface
{
    public const DOMAIN_1 = 'Science';
    public const DOMAIN_2 = 'Littéraire';
    public const DOMAIN_3 = 'Biologie';

    /**
     * @return array[]
     */
    protected function getDataEntities(): array
    {
        return [
            self::DOMAIN_1 => ['label' => self::DOMAIN_1],
            self::DOMAIN_2 => ['label' => self::DOMAIN_2],
            self::DOMAIN_3 => ['label' => self::DOMAIN_3]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Domain::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}