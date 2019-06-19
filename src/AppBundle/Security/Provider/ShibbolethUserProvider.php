<?php

namespace AppBundle\Security\Provider;


use AppBundle\Command\User\CreateUserCommand;
use AppBundle\Command\User\EditUserCommand;
use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\User\EditUserQuery;
use AppBundle\Query\User\FindUserByIdQuery;
use AppBundle\Query\User\FindUserByUsernameQuery;
use AppBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
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
     * @var FindUserByIdQuery
     */
    private $findUserByIdQuery;

    /**
     * @var FindUserByUsernameQuery
     */
    private $findUserByUsernameQuery;

    /**
     * @var EditUserQuery
     */
    private $editUserQuery;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * ShibbolethUserProvider constructor.
     * @param FindUserByIdQuery $findUserByIdQuery
     * @param FindUserByUsernameQuery $findUserByUsernameQuery
     * @param EditUserQuery $editUserQuery
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        FindUserByIdQuery $findUserByIdQuery,
        FindUserByUsernameQuery $findUserByUsernameQuery,
        EditUserQuery $editUserQuery,
        UserRepositoryInterface $userRepository)
    {
        $this->findUserByIdQuery = $findUserByIdQuery;
        $this->findUserByUsernameQuery = $findUserByUsernameQuery;
        $this->editUserQuery = $editUserQuery;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $credentials
     * @return User|null
     */
    public function loadUser(array $credentials)
    {
        if(!array_key_exists('username', $credentials)){
            throw new UsernameNotFoundException(sprintf("Username not found"));
        }

        $username = $credentials['username'];

        $user = null;
        $command = null;
        try {
            $user = $this->findUserByUsernameQuery->setUsername($username)->execute();
            $command = new EditUserCommand($user);
        }catch (UserNotFoundException $e){
            $user = new User();
            $command = new CreateUserCommand();
            $command->setUsername($username);
        }

        if(array_key_exists('givenName', $credentials)) {
            $command->setFirstname($credentials['givenName']);
        }else{
            $command->setFirstname("");
        }

        if(array_key_exists('sn', $credentials)) {
            $command->setLastname($credentials['sn']);
        }else{
            $command->setLastname("");
        }

        if(array_key_exists('mail', $credentials)) {
            $command->setEmail($credentials['mail']);
        }else{
            $command->setEmail("");
        }

        $command->setRoles(self::DEFAULT_ROLES);

        $user = $command->filledEntity($user);

        // On ne créé pas l'utilisateur en Bdd
        if(is_a($command, EditUserCommand::class)){
            try{
                $this->editUserQuery->setEditUserCommand($command)->execute();
            }catch(UserNotFoundException $e){

            }
        }

        //$user = $this->findUserByIdQuery->setId($command->getId())->execute();

        return $user;
    }

    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        return $this->loadUser(['username' => $username]);
    }

    /**
     * @param $username
     * @return User|null
     */
    public function refresh($username)
    {
        try{
            return $this->findUserByUsernameQuery->setUsername($username)->execute();
        }catch (\Exception $e){
            return null;
        }
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
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