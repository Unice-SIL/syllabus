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

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setId(Uuid::uuid4())
            ->setUsername('user1')
            ->setFirstname('User1')
            ->setLastname('User1')
            ->setEmail('user1@unice.fr')
            ->setRoles(['USER_ROLE']);
        $this->addReference(self::USER_1, $user);
        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

}