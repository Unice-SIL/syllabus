<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @ORM\Entity
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\UserTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "user.search_filter", "username.search_filter"},
 *     "access_control"="is_granted('ROLE_API_USER')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_USER_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_USER_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_USER_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_USER_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_USER_DELETE')"},
 *     }
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, Serializable
{

    /**
     * @var string|null
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=100, nullable=true, options={"fixed"=true})
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=100, nullable=true, options={"fixed"=true})
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min = 8,
     *     groups={"reset_password"},
     * )
     * @Assert\Regex(
     *     pattern     = "/(?=(.*\d){1})(?=(.*[a-z]){1})(?=(.*[A-Z]){1})/",
     *     groups={"reset_password"},
     *     message="Votre mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre"
     * )
     * @Assert\NotBlank(groups={"reset_password"})
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var array|null
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "Vous devez selectionner au moins un rôle",
     * )
     */
    private $roles;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetPasswordToken;

    /**
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\Groups", inversedBy="users")
     */
    private $groups;

    /**
     * User constructor.
     * @param $groups
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }


    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return User
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     * @return User
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return User
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return User
     */
    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return User
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     * @return User
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param null|string $salt
     * @return User
     */
    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getRoles(): ?array
    {
        if ($this->roles === null) {
            $this->roles = [];
        }
        $roles = $this->roles;
        $groups = $this->getGroups();
        foreach ($groups as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }
        return array_values(array_unique($roles));
    }

    /**
     * @param null|array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param $role
     * @return $this
     */
    public function addRole($role): self
    {
        if(!in_array($role, $this->roles)){
            $this->roles[] = $role;
        }
        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    /**
     * @return string|null
     */
    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    /**
     * @param null|string $resetPasswordToken
     * @return User
     */
    public function setResetPasswordToken(?string $resetPasswordToken): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }


    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSelect2Name()
    {
        return $this->lastname . ' ' . $this->firstname . ' (' . $this->username . ')';
    }

    /**
     * @return null|Collection
     */
    public function getGroups(): ?Collection
    {
        return $this->groups;
    }

    /**
     * @param null|Collection $groups
     * @return User
     */
    public function setGroups(?Collection $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @param Groups|null $groups
     * @return $this
     */
    public function addGroups(?Groups $groups): self
    {
        if(!$this->getGroups()->contains($groups)){
            $this->getGroups()->add($groups);

            if (!$groups->getUsers()->contains($this)) {
                $groups->getUsers()->add($this);
            }
        }

        return $this;
    }

    /**
     * @param Groups $groups
     * @return $this
     */
    public function removeGroups(Groups $groups): self
    {
        if($this->getGroups()->contains($groups))
        {
            $this->getGroups()->removeElement($groups);
            if ($groups->getUsers()->contains($this))
            {
                $groups->removeUser($this);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function serialize(): ?string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->firstname,
            $this->lastname,
            $this->email,
            $this->password,
            $this->salt,
            $this->roles
        ]);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        list(
            $this->id,
            $this->username,
            $this->firstname,
            $this->lastname,
            $this->email,
            $this->password,
            $this->salt,
            $this->roles
            ) = unserialize($data);
    }

}
