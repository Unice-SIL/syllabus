<?php

namespace LdapBundle\Entity;

/**
 * Class Teacher
 * @package LdapBundle\Entity
 */
class Teacher
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
     * @var string|null
     */
    private $civilite;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Teacher
     */
    public function setId(string $id): Teacher
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
     * @return Teacher
     */
    public function setUsername(string $username): Teacher
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param null|string $civilite
     * @return Teacher
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

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
     * @return Teacher
     */
    public function setFirstname(string $firstname): Teacher
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
     * @return Teacher
     */
    public function setLastname(string $lastname): Teacher
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Teacher
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


}