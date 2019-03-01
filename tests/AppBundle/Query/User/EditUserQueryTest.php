<?php

namespace tests\Query\User;

use AppBundle\Command\User\EditUserCommand;
use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\User\EditUserQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditUserQueryTest
 * @package tests\Query\User
 */
class EditUserQueryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $userRepository;

    /**
     * @var User
     */
    private $user;

    /**
     * @var EditUserCommand
     */
    private $editUserCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mock Repository
        $this->userRepository = $this->getMockBuilder('AppBundle\Repository\UserRepositoryInterface')
            ->getMock();

        // User
        $this->user = new User();
        $this->user
            ->setId(Uuid::uuid4())
            ->setUsername('username')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email')
            ->setPassword('password')
            ->setSalt('salt')
            ->setRoles(['USER_ROLE']);

        // Command
        $this->editUserCommand = new EditUserCommand($this->user);
    }

    /**
 * @test
 */
    public function editSuccessful(){
        $this->userRepository->expects($this->once())
            ->method('find')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->userRepository->expects($this->once())
            ->method('update')
            ->with($this->user);
        $editUserQuery = new EditUserQuery($this->userRepository);
        $editUserQuery->setEditUserCommand($this->editUserCommand);
        $this->assertNull($editUserQuery->execute());
    }

    /**
     * @test
     */
    public function editException(){
        $this->expectException(\Exception::class);
        $this->userRepository->expects($this->once())
            ->method('find')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->userRepository->expects($this->once())
            ->method('update')
            ->with($this->user)
            ->willThrowException(new \Exception());
        $editUserQuery = new EditUserQuery($this->userRepository);
        $editUserQuery->setEditUserCommand($this->editUserCommand)->execute();
    }


    /**
     * @test
     */
    public function editUserNotFoundException(){
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->expects($this->once())
            ->method('find')
            ->with($this->user->getId())
            ->willReturn(null);
        $this->userRepository->expects($this->never())
            ->method('update')
            ->with($this->user);
        $editUserQuery = new EditUserQuery($this->userRepository);
        $editUserQuery->setEditUserCommand($this->editUserCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->userRepository);
        unset($this->user);
        unset($this->editUserCommand);
    }
}