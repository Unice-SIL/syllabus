<?php

namespace AppBundle\Security\Provider;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UniceSIL\ShibbolethBundle\Security\User\ShibbolethUserProviderInterface;

/**
 * Class ShibbolethUserProvider
 * @package AppBundle\Security\Provider
 */
class ShibbolethUserProvider implements ShibbolethUserProviderInterface
{

    /**
     * Default roles
     */
    const DEFAULT_ROLES = ['ROLE_USER'];

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * ShibbolethUserProvider constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $credentials
     * @return User|null
     */
    public function loadUser(array $credentials)
    {
        $username = $credentials['username'];
        // Search user in DB
        $user = $this->userRepository->findByUsername($username);
        // If user not found in DB instanciate new User
        if(!$user instanceof User){
            $user = new User();
        }
        // Set user information
        $user->setUsername($username)
            ->setFirstname($credentials['givenName'])
            ->setLastname($credentials['sn'])
            ->setEmail($credentials['mail'])
            ->setRoles(self::DEFAULT_ROLES);
        // If user id not null (user found in DB) update it
        if(!is_null($user->getId())){
            $this->userRepository->update($user);
        }else{
            $user->setId($credentials['uid']);
        }

        return $user;
    }


    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        $user = new User();
        $user->setUsername($username)
            ->setRoles(self::DEFAULT_ROLES);
        return $user;
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}