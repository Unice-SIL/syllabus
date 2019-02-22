<?php

namespace AppBundle\Query\User;

use AppBundle\Command\User\EditUserCommand;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\UserRepositoryInterface;

/**
 * Class EditUserQuery
 * @package AppBundle\Query\User
 */
class EditUserQuery implements QueryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EditUserCommand
     */
    private $editUserCommand;

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
     * @param EditUserCommand $editUserCommand
     * @return EditUserQuery
     */
    public function setEditUserCommand(EditUserCommand $editUserCommand): EditUserQuery
    {
        $this->editUserCommand = $editUserCommand;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function execute(): void
    {
        $id = $this->editUserCommand->getId();
        try{
            $user = $this->userRepository->find($id);
            if(is_null($user)){
                throw new UserNotFoundException(sprintf("User with id %s not found", $id));
            }
            $this->userRepository->update($this->editUserCommand->filledEntity($user));
        }catch (\Exception $e){
            throw $e;
        }
    }
}