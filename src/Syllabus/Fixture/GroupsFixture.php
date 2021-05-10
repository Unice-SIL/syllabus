<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Groups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class YearFixture
 * @package App\Syllabus\Fixture
 */
class GroupsFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const SUPER_ADMIN = 'Super Administrateur';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $groups = [
            [
                'label' => self::SUPER_ADMIN,
                'roles' => UserRole::ROLES,
                'ref' => self::SUPER_ADMIN,
            ]
        ];

        foreach ($groups as $g) {
            $group = new Groups();
            $group->setLabel($g['label'])
                ->setRoles($g['roles']);
            $this->addReference($g['ref'], $group);
            $manager->persist($group);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}