<?php

namespace LdapBundle\Entity;

/**
 * Class People
 * @package LdapBundle\Entity
 */
class People
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
     * @var string
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
     * @return People
     */
    public function setId(string $id): People
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
     * @return People
     */
    public function setUsername(string $username): People
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getCivilite(): string
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     * @return People
     */
    public function setCivilite(string $civilite): People
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
     * @return People
     */
    public function setFirstname(string $firstname): People
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
     * @return People
     */
    public function setLastname(string $lastname): People
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return People
     */
    public function setEmail(string $email): People
    {
        $this->email = $email;

        return $this;
    }

}