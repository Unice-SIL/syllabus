<?php

namespace AppBundle\Command\User;

use AppBundle\Entity\User;
use AppBundle\Command\CommandInterface;

/**
 * Class EditUserCommand
 * @package AppBundle\Command\User
 */
class EditUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

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
     * EditUserCommand constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->salt = $user->getSalt();
        $this->roles = $user->getRoles();
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
     * @return EditUserCommand
     */
    public function setId(string $id): EditUserCommand
    {
        $this->id = $id;

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
     * @return EditUserCommand
     */
    public function setFirstname(string $firstname): EditUserCommand
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
     * @return EditUserCommand
     */
    public function setLastname(string $lastname): EditUserCommand
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
     * @return EditUserCommand
     */
    public function setEmail(string $email): EditUserCommand
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
     * @return EditUserCommand
     */
    public function setPassword(string $password): EditUserCommand
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
     * @return EditUserCommand
     */
    public function setSalt(string $salt): EditUserCommand
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
     * @return EditUserCommand
     */
    public function setRoles(array $roles): EditUserCommand
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
        $entity->setFirstname($this->getFirstname())
            ->setLastname($this->getLastname())
            ->setEmail($this->getEmail())
            ->setPassword($this->getPassword())
            ->setSalt($this->getSalt())
            ->setRoles($this->getRoles());
        return $entity;
    }
}