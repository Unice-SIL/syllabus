<?php

namespace tests\Query\User;

use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\User\FindUserByUsernameQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FindUserByUsernameQueryTest
 * @package tests\Query\User
 */
class FindUserByUsernameQueryTest extends TestCase
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
    }

    /**
     * @test
     */
    public function findByUsernameSuccessful(){
        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with($this->user->getUsername())
            ->willReturn($this->user);
        $findUserByUsernameQuery = new FindUserByUsernameQuery($this->userRepository);
        $user = $findUserByUsernameQuery->setUsername($this->user->getUsername())->execute();
        $this->assertEquals($this->user, $user);
    }

    /**
     * @test
     */
    public function findByUsernameException(){
        $this->expectException(\Exception::class);
        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with($this->user->getUsername())
            ->willThrowException(new \Exception());
        $findUserByUsernameQuery = new FindUserByUsernameQuery($this->userRepository);
        $user = $findUserByUsernameQuery->setUsername($this->user->getUsername())->execute();
        $this->assertNull($user);
    }

    /**
     * @test
     */
    public function findUserNotFoundException(){
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with($this->user->getUsername())
            ->willReturn(null);
        $findUserByUsernameQuery = new FindUserByUsernameQuery($this->userRepository);
        $user = $findUserByUsernameQuery->setUsername($this->user->getUsername())->execute();
        $this->assertNull($user);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->userRepository);
        unset($this->user);
    }
}