<?php

namespace tests\AppBundle\Command\User;

use AppBundle\Command\User\EditUserCommand;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditUserCommandTest
 * @package tests\Command\User
 */
class EditUserCommandTest extends TestCase
{
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
        $this->user = new User();
        $this->user->setId(Uuid::uuid4())
            ->setUsername('username')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email')
            ->setPassword('password')
            ->setSalt('salt')
            ->setRoles(['USER_ROLE']);
        $this->editUserCommand = new EditUserCommand($this->user);
    }

    /**
     * @test
     */
    public function getId(){
        $this->assertNotEmpty($this->editUserCommand->getId());
        $this->assertTrue(is_string($this->editUserCommand->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->editUserCommand->getId()));
    }

    /**
     * @test
     */
    public function getFirstname(){
        $this->assertNotEmpty($this->editUserCommand->getFirstname());
        $this->assertTrue(is_string($this->editUserCommand->getFirstname()));
        $this->assertEquals('firstname', $this->editUserCommand->getFirstname());
    }

    /**
     * @test
     */
    public function getLastname(){
        $this->assertNotEmpty($this->editUserCommand->getLastname());
        $this->assertTrue(is_string($this->editUserCommand->getLastname()));
        $this->assertEquals('lastname', $this->editUserCommand->getLastname());
    }

    /**
     * @test
     */
    public function getEmail(){
        $this->assertNotEmpty($this->editUserCommand->getEmail());
        $this->assertTrue(is_string($this->editUserCommand->getEmail()));
        $this->assertEquals('email', $this->editUserCommand->getEmail());
    }

    /**
     * @test
     */
    public function getPassword(){
        $this->assertNotEmpty($this->editUserCommand->getPassword());
        $this->assertTrue(is_string($this->editUserCommand->getPassword()));
        $this->assertEquals('password', $this->editUserCommand->getPassword());
    }

    /**
     * @test
     */
    public function getSalt(){
        $this->assertNotEmpty($this->editUserCommand->getSalt());
        $this->assertTrue(is_string($this->editUserCommand->getSalt()));
        $this->assertEquals('salt', $this->editUserCommand->getSalt());
    }

    /**
     * @test
     */
    public function getRole(){
        $this->assertNotEmpty($this->editUserCommand->getRoles());
        $this->assertTrue(is_array($this->editUserCommand->getRoles()));
        $this->assertEquals(['USER_ROLE'], $this->editUserCommand->getRoles());
    }

    /**
     * @test
     */
    public function filledEntity(){
       $this->assertEquals($this->user, $this->editUserCommand->filledEntity($this->user));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->editUserCommand);
    }
}