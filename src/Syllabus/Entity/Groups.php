<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
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
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_GROUPS_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_GROUPS_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_GROUPS_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_GROUPS_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_GROUPS_POST\')')],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_GROUPS\')'
    )
]
class Groups
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", unique=true)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
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
