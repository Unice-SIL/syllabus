<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Structure;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Class StructureFixture
 * @package App\Syllabus\Fixture
 */
class StructureFixture extends AbstractFixture  implements FixtureGroupInterface
{
    /**
     *
     */
    const SCIENCES = 'structureSciences';
    const LAS = 'structureLAS';
    const LA = 'structureLA';

    /**
     * @return string[][]
     */
    protected function getDataEntities(): array
    {
        return [
            self::SCIENCES => [
                'label' => self::SCIENCES,
                'code' => 'SCI'
            ],
            self::LAS => [
                'label' => self::LAS,
                'code' => 'LAS'
            ],
            self::LA => [
                'label' => self::LA,
                'code' => 'LA'
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Structure::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}