<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Groups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class YearFixture
 * @package AppBundle\Fixture
 */
class GroupsFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const GROUP_1 = 'groupe 1';
    public const GROUP_2 = 'groupe 2';
    public const GROUP_3 = 'groupe 3';
    public const GROUP_4 = 'groupe 4';
    public const GROUP_5 = 'groupe 5';
    public const GROUP_6 = 'groupe 6';
    public const GROUP_7 = 'groupe 7';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $groups = [
            [
                'label' => self::GROUP_1,
                'ref' => self::GROUP_1,
            ],
            [
                'label' => self::GROUP_2,
                'ref' => self::GROUP_2,
            ],
            [
                'label' => self::GROUP_3,
                'ref' => self::GROUP_3,
            ],
            [
                'label' => self::GROUP_4,
                'ref' => self::GROUP_4,
            ],
            [
                'label' => self::GROUP_5,
                'ref' => self::GROUP_5,
            ],
            [
                'label' => self::GROUP_6,
                'ref' => self::GROUP_6,
            ],
            [
                'label' => self::GROUP_7,
                'ref' => self::GROUP_7,
            ],
        ];

        foreach ($groups as $g) {

            $group = new Groups();
            $group->setLabel($g['label']);
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