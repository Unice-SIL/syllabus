<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFixture
 * @package App\Syllabus\Fixture
 */
class UserFixture extends AbstractFixture  implements FixtureGroupInterface, DependentFixtureInterface
{
    public const USER_1 = 'user1';
    public const USER_2 = 'user2';
    public const USER_3 = 'user3';
    public const PASSWORD_TEST = 'Administrator42';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::USER_1 => ['username' => self::USER_1,
                'firstname' => 'User1',
                'lastname' => 'User1',
                'email' => self::USER_1 . '@gmail.com',
                'roles' => [UserRole::ROLE_USER],
                '@groups' => [GroupsFixture::SUPER_ADMIN]
            ],
            self::USER_2 => [
                'username' => self::USER_2,
                'firstname' => 'User2',
                'lastname' => 'User2',
                'email' => self::USER_2 . '@gmail.com',
                'roles' => [UserRole::ROLE_USER]
            ],
            [
                'username' => self::USER_3,
                'firstname' => 'User3',
                'lastname' => 'User3',
                'email' => self::USER_3 . '@gmail.com',
                'roles' => [UserRole::ROLE_USER]
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return User::class;
    }

    /**
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }

    public function getDependencies(): array
    {
        return [
            GroupsFixture::class
        ];
    }
}