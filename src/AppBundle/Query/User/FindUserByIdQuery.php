<?php

namespace AppBundle\Query\User;

use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\UserRepositoryInterface;

/**
 * Class FindUserByUsernameQuery
 * @package AppBundle\Query\User
 */
class FindUserByIdQuery implements QueryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var string
     */
    private $id;

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
     * @param string $id
     * @return FindUserByIdQuery
     */
    public function setId(string $id): FindUserByIdQuery
    {
        $this->id = $id;
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
            $user = $this->userRepository->find($this->id);
            if(is_null($user)){
                throw new UserNotFoundException(sprintf("User with id %s not found", $this->id));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $user;
    }
}