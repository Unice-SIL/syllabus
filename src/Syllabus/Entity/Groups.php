<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\GroupsDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\GroupsTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_GROUPS')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_GROUPS_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_GROUPS_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_GROUPS_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_GROUPS_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_GROUPS_DELETE')"},
 *     }
 * )
 */
class Groups
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, unique=true)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\User", mappedBy="groups")
     * @ApiSubresource()
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label): Groups
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
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
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return bool
     */
    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     */
    public function setObsolete(bool $obsolete)
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
     * @param User|null $user
     * @return $this
     */
    public function addUser(?User $user): self
    {
        if(!$this->getUsers()->contains($user)){

            $this->getUsers()->add($user);
            $user->addGroups($this);
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
            $user->removeGroups($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLabel();
    }


}
