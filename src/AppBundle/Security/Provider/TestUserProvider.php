<?php

namespace AppBundle\Security\Provider;

use AppBundle\Command\User\CreateUserCommand;
use AppBundle\Command\User\EditUserCommand;
use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\User\CreateUserQuery;
use AppBundle\Query\User\EditUserQuery;
use AppBundle\Query\User\FindUserByIdQuery;
use AppBundle\Query\User\FindUserByUsernameQuery;
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
     * @var FindUserByUsernameQuery
     */
    private $findUserByUsernameQuery;

    /**
     * @var CreateUserQuery
     */
    private $createUserQuery;

    /**
     * @var EditUserQuery
     */
    private $editUserQuery;

    /**
     * @var FindUserByIdQuery
     */
    private $findUserByIdQuery;

    /**
     * TestUserProvider constructor.
     * @param array $config
     * @param FindUserByUsernameQuery $findUserByUsernameQuery
     * @param CreateUserQuery $createUserQuery
     * @param EditUserQuery $editUserQuery
     * @param FindUserByIdQuery $findUserByIdQuery
     */
    public function __construct(
        array $config = array(),
        FindUserByUsernameQuery $findUserByUsernameQuery,
        CreateUserQuery $createUserQuery,
        EditUserQuery $editUserQuery,
        FindUserByIdQuery $findUserByIdQuery
    )
    {
        $this->config = $config;
        $this->findUserByUsernameQuery = $findUserByUsernameQuery;
        $this->createUserQuery = $createUserQuery;
        $this->editUserQuery = $editUserQuery;
        $this->findUserByIdQuery = $findUserByIdQuery;
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

        $user = null;
        $command = null;
        try {
            $user = $this->findUserByUsernameQuery->setUsername($username)->execute();
            $command = new EditUserCommand($user);
        }catch (UserNotFoundException $e){
            $command = new CreateUserCommand();
            $command->setUsername($username);
        }

        if(array_key_exists('firstname', $credentials)){
            $command->setFirstname($credentials['firstname']);
        }
        if(array_key_exists('lastname', $credentials)){
            $command->setLastname($credentials['lastname']);
        }
        if(array_key_exists('email', $credentials)){
            $command->setEmail($credentials['email']);
        }
        if(array_key_exists('roles', $credentials)){
            $command->setRoles($credentials['roles']);
        }

        if(is_a($command, CreateUserCommand::class)){
            $this->createUserQuery->setCreateUserCommand($command)->execute();
        }else{
            $this->editUserQuery->setEditUserCommand($command)->execute();
        }

        $user = $this->findUserByIdQuery->setId($command->getId())->execute();

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