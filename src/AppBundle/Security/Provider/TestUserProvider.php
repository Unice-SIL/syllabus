<?php

namespace AppBundle\Security\Provider;

use AppBundle\Model\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class TestUserProvider
 * @package AppBundle\Security\Provider
 */
class TestUserProvider implements UserProviderInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * TestUserProvider constructor.
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        if(!array_key_exists($username, $this->config['users'])){
            throw new UsernameNotFoundException(sprintf("User %s not found in users configured for test_authenticator", $username));
        }
        $credentials = $this->config['users'][$username];
        $user = new User();
        $user->setUsername($username);
        if(array_key_exists('id', $credentials)){
            $user->setId($credentials['id']);
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
     * @param UserInterface $user
     * @return User
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
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