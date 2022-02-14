<?php

namespace App\Syllabus\Security\Provider;

use App\Syllabus\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use UniceSIL\ShibbolethBundle\Security\Provider\AbstractShibbolethUserProvider;

/**
 * Class ShibbolethUserProvider
 * @package App\Syllabus\Security\Provider
 */
class ShibbolethUserProvider extends AbstractShibbolethUserProvider
{
    const DEFAULT_ROLE = 'ROLE_USER';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @param ManagerRegistry $registry
     * @param RequestStack $requestStack
     */
    public function __construct(ManagerRegistry $registry, RequestStack $requestStack)
    {
        $this->em = $registry->getManager();
        parent::__construct($requestStack);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->loadUserByUsername($identifier);
    }

    public function loadUserByUsername(string $username)
    {
        $user = $this->findUserByUsername($username);

        if (!$user instanceof User) {
            $user = new User();
            $user->setUsername($username);
        }

        $attributes = $this->getAttributes();
        $user
            ->setFirstname($attributes['givenName'] ?? '')
            ->setLastname($attributes['sn'] ?? '')
            ->setEmail($attributes['mail'] ?? '')
            ->addRole(self::DEFAULT_ROLE);

        $this->em->flush();
    }

    /**
     * @param UserInterface $user
     * @return User|UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        $refreshedUser = $this->findUserByUsername($user->getUserIdentifier());
        return $refreshedUser ?? $user;
    }


    /**
     * @param $username
     * @return User|null
     */
    private function findUserByUsername($username): ?User
    {
        return $this->em->getRepository(User::class)->findOneByUsername($username);
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return $class === User::class;
    }
}