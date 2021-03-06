<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\User\CreateUserCommand;
use AppBundle\Entity\User;
use AppBundle\Query\User\CreateUserQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateUserQueryTest
 * @package tests\Query\User
 */
class CreateUserQueryTest extends TestCase
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
     * @var CreateUserCommand
     */
    private $createUserCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mock Reposutory
        $this->userRepository = $this->getMockBuilder('AppBundle\Repository\UserRepositoryInterface')
            ->getMock();

        // Command
        $this->createUserCommand = new CreateUserCommand();
        $this->createUserCommand->setUsername('username')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email')
            ->setPassword('password')
            ->setSalt('salt')
            ->setRoles(['USER_ROLE']);

        // User
        $this->user = $this->createUserCommand->filledEntity(new User());
    }

    /**
     * @test
     */
    public function createSuccessful(){
        $this->userRepository->expects($this->once())
            ->method('create')
            ->with($this->user);
        $createUserQuery = new CreateUserQuery($this->userRepository);
        $createUserQuery->setCreateUserCommand($this->createUserCommand);
        $this->assertNull($createUserQuery->execute());
    }

    /**
     * @test
     */
    public function createException(){
        $this->expectException(\Exception::class);
        $this->userRepository->expects($this->once())
            ->method('create')
            ->with($this->user)
            ->willThrowException(new \Exception());
        $createUserQuery = new CreateUserQuery($this->userRepository);
        $createUserQuery->setCreateUserCommand($this->createUserCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->userRepository);
        unset($this->user);
        unset($this->createUserCommand);
    }
}