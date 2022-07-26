<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Groups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class YearFixture
 * @package App\Syllabus\Fixture
 */
class GroupsFixture extends AbstractFixture  implements FixtureGroupInterface
{
    public const SUPER_ADMIN = 'Super Administrateur';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::SUPER_ADMIN => [
                'label' => self::SUPER_ADMIN,
                'roles' => UserRole::ROLES
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Groups::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}