<?php

namespace AppBundle\Command\User;

use AppBundle\Entity\User;
use AppBundle\Port\Command\CommandInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateUserCommand
 * @package AppBundle\Command\User
 */
class CreateUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email = null;

    /**
     * @var string
     */
    private $password = null;

    /**
     * @var string
     */
    private $salt = null;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * CreateUserCommand constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CreateUserCommand
     */
    public function setId(string $id): CreateUserCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return CreateUserCommand
     */
    public function setUsername(string $username): CreateUserCommand
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return CreateUserCommand
     */
    public function setFirstname(string $firstname): CreateUserCommand
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return CreateUserCommand
     */
    public function setLastname(string $lastname): CreateUserCommand
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CreateUserCommand
     */
    public function setEmail(string $email): CreateUserCommand
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return CreateUserCommand
     */
    public function setPassword(string $password): CreateUserCommand
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return CreateUserCommand
     */
    public function setSalt(string $salt): CreateUserCommand
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return CreateUserCommand
     */
    public function setRoles(array $roles): CreateUserCommand
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param User $entity
     * @return User
     */
    public function filledEntity($entity): User
    {
        $entity->setId($this->getId())
            ->setUsername($this->getUsername())
            ->setFirstname($this->getFirstname())
            ->setLastname($this->getLastname())
            ->setEmail($this->getEmail())
            ->setPassword($this->getPassword())
            ->setSalt($this->getSalt())
            ->setRoles($this->getRoles());
        return $entity;
    }
}