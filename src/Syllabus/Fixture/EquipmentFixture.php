<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Equipment;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class EquipmentFixture extends AbstractFixture  implements FixtureGroupInterface
{
    public const EQUIPMENT_1 = 'Autre';
    public const EQUIPMENT_2 = 'Calculatrice programmable';
    public const EQUIPMENT_3 = 'Ordinateur personnel / tablette';

    /**
     * @return array[]
     */
    protected function getDataEntities(): array
    {
        return [
            self::EQUIPMENT_1 => [
                'label' => self::EQUIPMENT_1,
                'labelVisibility' => false
            ],
            self::EQUIPMENT_2 => [
                'label' => self::EQUIPMENT_2,
                'labelVisibility' => true
            ],
            self::EQUIPMENT_3 => [
                'label' => self::EQUIPMENT_3,
                'labelVisibility' => true
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Equipment::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }


}