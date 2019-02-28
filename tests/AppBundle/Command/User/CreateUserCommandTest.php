<?php

namespace tests\Command\User;

use AppBundle\Command\User\CreateUserCommand;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class CreateUserCommandTest
 * @package tests\Command\User
 */
class CreateUserCommandTest extends TestCase
{
    /**
     * @var CreateUserCommand
     */
    private $createUserCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->createUserCommand = new CreateUserCommand();
        $this->createUserCommand->setUsername('username')
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
    public function getId(){
        $this->assertNotEmpty($this->createUserCommand->getId());
        $this->assertTrue(is_string($this->createUserCommand->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->createUserCommand->getId()));
    }

    /**
     * @test
     */
    public function getUsername(){
        $this->assertNotEmpty($this->createUserCommand->getUsername());
        $this->assertTrue(is_string($this->createUserCommand->getUsername()));
        $this->assertEquals('username', $this->createUserCommand->getUsername());
    }

    /**
     * @test
     */
    public function getFirstname(){
        $this->assertNotEmpty($this->createUserCommand->getFirstname());
        $this->assertTrue(is_string($this->createUserCommand->getFirstname()));
        $this->assertEquals('firstname', $this->createUserCommand->getFirstname());
    }

    /**
     * @test
     */
    public function getLastname(){
        $this->assertNotEmpty($this->createUserCommand->getLastname());
        $this->assertTrue(is_string($this->createUserCommand->getLastname()));
        $this->assertEquals('lastname', $this->createUserCommand->getLastname());
    }

    /**
     * @test
     */
    public function getEmail(){
        $this->assertNotEmpty($this->createUserCommand->getEmail());
        $this->assertTrue(is_string($this->createUserCommand->getEmail()));
        $this->assertEquals('email', $this->createUserCommand->getEmail());
    }

    /**
     * @test
     */
    public function getPassword(){
        $this->assertNotEmpty($this->createUserCommand->getPassword());
        $this->assertTrue(is_string($this->createUserCommand->getPassword()));
        $this->assertEquals('password', $this->createUserCommand->getPassword());
    }

    /**
     * @test
     */
    public function getSalt(){
        $this->assertNotEmpty($this->createUserCommand->getSalt());
        $this->assertTrue(is_string($this->createUserCommand->getSalt()));
        $this->assertEquals('salt', $this->createUserCommand->getSalt());
    }

    /**
     * @test
     */
    public function getRole(){
        $this->assertNotEmpty($this->createUserCommand->getRoles());
        $this->assertTrue(is_array($this->createUserCommand->getRoles()));
        $this->assertEquals(['USER_ROLE'], $this->createUserCommand->getRoles());
    }

    /**
     * @test
     */
    public function filledEntity(){
        $user = new User();
        $user->setId($this->createUserCommand->getId())
            ->setUsername($this->createUserCommand->getUsername())
            ->setFirstname($this->createUserCommand->getFirstname())
            ->setLastname($this->createUserCommand->getLastname())
            ->setEmail($this->createUserCommand->getEmail())
            ->setPassword($this->createUserCommand->getPassword())
            ->setSalt($this->createUserCommand->getSalt())
            ->setRoles($this->createUserCommand->getRoles());
       $this->assertEquals($user, $this->createUserCommand->filledEntity(new User()));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->createUserCommand);
    }
}