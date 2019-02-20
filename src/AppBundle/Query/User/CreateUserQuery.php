<?php

namespace AppBundle\Query\User;

use AppBundle\Command\User\CreateUserCommand;
use AppBundle\Entity\User;
use AppBundle\Port\Query\QueryInterface;
use AppBundle\Port\Repository\UserRepositoryInterface;

/**
 * Class CreateUserQuery
 * @package AppBundle\Query\User
 */
class CreateUserQuery implements QueryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CreateUserCommand
     */
    private $createUserCommand;

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
     * @param CreateUserCommand $createUserCommand
     * @return CreateUserQuery
     */
    public function setCreateUserCommand(CreateUserCommand $createUserCommand): CreateUserQuery
    {
        $this->createUserCommand = $createUserCommand;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function execute(): void
    {
        try{
            $this->userRepository->create($this->createUserCommand->filledEntity(new User()));
        }catch (\Exception $e){
            throw $e;
        }
    }
}