<?php

namespace AppBundle\Query\User;

use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Port\Query\QueryInterface;
use AppBundle\Port\Repository\UserRepositoryInterface;

/**
 * Class FindUserByUsernameQuery
 * @package AppBundle\Query\User
 */
class FindUserByUsernameQuery implements QueryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var string
     */
    private $username;

    /**
     * FindUserByUsernameQuery constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     * @return FindUserByUsernameQuery
     */
    public function setUsername(string $username): FindUserByUsernameQuery
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return User|null
     * @throws \Exception
     */
    public function execute(): ?User
    {
        $user = null;
        try{
            $user = $this->userRepository->findByUsername($this->username);
            if(is_null($user)){
                throw new UserNotFoundException(sprintf("User with username %s not found", $this->username));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $user;
    }
}