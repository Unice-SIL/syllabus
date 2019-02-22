<?php

namespace tests\Query\User;

use AppBundle\Entity\User;
use AppBundle\Exception\UserNotFoundException;
use AppBundle\Query\User\FindUserByIdQuery;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FindUserByIdQueryTest
 * @package tests\Query\User
 */
class FindUserByIdQueryTest extends TestCase
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
        $this->userRepository = $this->getMockBuilder(UserDoctrineRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();
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
    public function findByIdSuccessful(){
        $this->userRepository->expects($this->once())
            ->method('find')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $findUserByIdQuery = new FindUserByIdQuery($this->userRepository);
        $user = $findUserByIdQuery->setId($this->user->getId())->execute();
        $this->assertEquals($this->user, $user);
    }

    /**
     * @test
     */
    public function findByIdException(){
        $this->expectException(\Exception::class);
        $this->userRepository->expects($this->once())
            ->method('find')
            ->with($this->user->getId())
            ->willThrowException(new \Exception());
        $findUserByIdQuery = new FindUserByIdQuery($this->userRepository);
        $user = $findUserByIdQuery->setId($this->user->getId())->execute();
        $this->assertNull($user);
    }

    /**
     * @test
     */
    public function findByIdUserNotFoundException(){
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->expects($this->once())
            ->method('find')
            ->with($this->user->getId())
            ->willReturn(null);
        $findUserByIdQuery = new FindUserByIdQuery($this->userRepository);
        $user = $findUserByIdQuery->setId($this->user->getId())->execute();
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