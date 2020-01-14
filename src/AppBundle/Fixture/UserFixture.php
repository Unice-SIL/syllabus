<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class UserFixture
 * @package AppBundle\Fixture
 */
class UserFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const USER_1 = 'user1';
    public const USER_2 = 'user2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // User 1
        $user = new User();
        $user->setId(Uuid::uuid4())
            ->setUsername('user1')
            ->setFirstname('User1')
            ->setLastname('User1')
            ->setEmail('user1@unice.fr')
            ->setRoles(['ROLE_USER']);
        $this->addReference(self::USER_1, $user);
        $manager->persist($user);

        // User 2
        $user = new User();
        $user->setId(Uuid::uuid4())
            ->setUsername('user2')
            ->setFirstname('User2')
            ->setLastname('User2')
            ->setEmail('user2@unice.fr')
            ->setRoles(['ROLE_USER']);
        $this->addReference(self::USER_2, $user);
        $manager->persist($user);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

}