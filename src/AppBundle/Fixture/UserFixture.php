<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class UserFixture
 * @package AppBundle\Fixture
 */
class UserFixture extends Fixture  implements FixtureGroupInterface
{
    const REF_PREFIX = 'user_';
    public const USER_1 = 'user1';
    public const USER_2 = 'user2';
    public const USER_FREDERIC = 'Frederic';
    public const USER_STEPHANE = 'Stéphane';
    public const USER_KEVIN = 'Kevin';
    public const USER_SALIM = 'Salim';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'username' => self::USER_1,
                'firstname' => 'User1',
                'lastname' => 'User1',
                'email' => self::USER_1,
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => self::USER_2,
                'firstname' => 'User2',
                'lastname' => 'User2',
                'email' => self::USER_2,
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => self::USER_FREDERIC,
                'firstname' => 'Frederic',
                'lastname' => 'DevTeam',
                'email' => self::USER_FREDERIC,
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => self::USER_STEPHANE,
                'firstname' => 'Stéphane',
                'lastname' => 'DevTeam',
                'email' => self::USER_STEPHANE,
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => self::USER_KEVIN,
                'firstname' => 'Kevin',
                'lastname' => 'DevTeam',
                'email' => self::USER_KEVIN,
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => self::USER_SALIM,
                'firstname' => 'Salim',
                'lastname' => 'DevTeam',
                'email' => self::USER_SALIM,
                'roles' => ['ROLE_USER']
            ],
        ];

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($users as $userFixture) {

            $user = new User();
            $user->setId(Uuid::uuid4());

            foreach ($userFixture as $property => $value) {
                switch ($property) {
                    case 'email':
                        $value .= '@unice.fr';
                        break;
                }

                $propertyAccessor->setValue($user, $property, $value);
            }

            $this->addReference(self::REF_PREFIX . $userFixture['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

}