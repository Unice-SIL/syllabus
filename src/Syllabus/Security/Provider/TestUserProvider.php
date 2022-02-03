<?php

namespace App\Syllabus\Security\Provider;

use App\Syllabus\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class TestUserProvider
 * @package App\Syllabus\Security\Provider
 */
class TestUserProvider implements UserProviderInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * TestUserProvider constructor.
     * @param array $config
     * @param ManagerRegistry $registry
     */
    public function __construct(
        array $config,
        ManagerRegistry $registry
    )
    {
        if(!is_array($config)) $config = [];
        $this->config = $config;
        $this->em = $registry->getManager();
    }

    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        if(!array_key_exists($username, $this->config['users'])){
            throw new UsernameNotFoundException(sprintf("User %s not found in users configured for test_authenticator.", $username));
        }
        $credentials = $this->config['users'][$username];

        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);

        if(!$user instanceof User)
        {
            $user = new User();
            $user->setUsername($username);
        }

        if(array_key_exists('firstname', $credentials)){
            $user->setFirstname($credentials['firstname']);
        }
        if(array_key_exists('lastname', $credentials)){
            $user->setLastname($credentials['lastname']);
        }
        if(array_key_exists('email', $credentials)){
            $user->setEmail($credentials['email']);
        }
        if(array_key_exists('roles', $credentials)){
            $user->setRoles($credentials['roles']);
        }

        return $user;
    }

    /**
     * @param $username
     * @return User|null
     */
    public function refresh($username)
    {
        return $this->loadUserByUsername($username);
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        //return $user;

        $refreshedUser = $this->refresh($user->getUsername());
        return ($refreshedUser instanceof User)? $refreshedUser : $user;

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