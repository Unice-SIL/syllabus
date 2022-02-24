<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class UserFixture
 * @package App\Syllabus\Fixture
 */
class UserFixture extends Fixture  implements FixtureGroupInterface
{
    const REF_PREFIX = 'user_';
    public const USER_1 = 'user1';
    public const USER_2 = 'user2';
    public const USER_FREDERIC = 'casazza@unice.fr';
    public const USER_STEPHANE = 'shauser';
    public const USER_KEVIN = 'genes';
    public const USER_SALIM = 'Salim';

    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        $groups = new ArrayCollection();
        $groups->add($this->getReference(GroupsFixture::SUPER_ADMIN));

        $users = [
            [
                'username' => self::USER_1,
                'firstname' => 'User1',
                'lastname' => 'User1',
                'email' => self::USER_1,
                'roles' => ['ROLE_USER'],
                'groups' => clone $groups
            ],
            [
                'username' => self::USER_2,
                'firstname' => 'User2',
                'lastname' => 'User2',
                'email' => self::USER_2,
                'roles' => ['ROLE_USER'],
                'groups' => new ArrayCollection()
            ],
            [
                'username' => self::USER_FREDERIC,
                'firstname' => 'Frederic',
                'lastname' => 'Casazza',
                'email' => self::USER_FREDERIC,
                'password' => self::USER_FREDERIC,
                'roles' => ['ROLE_USER'],
                'groups' => clone $groups
            ],
            [
                'username' => self::USER_STEPHANE,
                'firstname' => 'Stéphane',
                'lastname' => 'DevTeam',
                'email' => self::USER_STEPHANE,
                'password' => self::USER_STEPHANE,
                'roles' => ['ROLE_USER'],
                'groups' => clone $groups
            ],
            [
                'username' => self::USER_KEVIN,
                'firstname' => 'Kevin',
                'lastname' => 'DevTeam',
                'email' => self::USER_KEVIN,
                'password' => self::USER_KEVIN,
                'roles' => ['ROLE_USER'],
                'groups' => clone $groups
            ],
            [
                'username' => self::USER_SALIM,
                'firstname' => 'Salim',
                'lastname' => 'DevTeam',
                'email' => self::USER_SALIM,
                'roles' => ['ROLE_USER'],
                'groups' => clone $groups
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
                    case 'password':
                        $value = $this->encoder->hashPassword($user, $value);
                        break;
/*
                    case 'groups':
                        foreach ($userFixture['groups'] as $group )
                        {
                            $user->addGroups($group);
                        }
                        continue;
                        break;*/
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