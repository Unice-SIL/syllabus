<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity()
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, unique=true)
     * @Assert\NotBlank()
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="groups")
     */
    private $users;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "Vous devez selectionner au moins un rôle",
     * )
     */
    private $roles = [];

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return Groups
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return bool
     */
    public function isObsolete()
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     */
    public function setObsolete($obsolete)
    {
        $this->obsolete = $obsolete;
    }

    /**
     * @return null|Collection
     */
    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    /**
     * @param null|Collection $users
     * @return $this
     */
    public function setUsers(?Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function addUser(?User $user): self
    {
        if(!$this->getUsers()->contains($user)){

            $this->getUsers()->add($user);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user): self
    {
        if($this->getUsers()->contains($user))
        {
            $this->getUsers()->removeElement($user);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }


}
