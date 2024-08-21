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
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Groups
 *
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
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\GroupsDoctrineRepository::class)]
#[ORM\Table(name: 'groups')]
class Groups
{
    
    #[ORM\Column(type: 'string', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'label', type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank]
    private string $label;

    
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private bool $obsolete = false;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'groups')]
    private $users;

    
    #[ORM\Column(name: 'roles', type: 'array', nullable: true)]
    #[Assert\Count(min: 1, minMessage: 'Vous devez selectionner au moins un rôle')]
    private array $roles = [];

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param $label
     */
    public function setLabel($label): Groups
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    public function setObsolete(bool $obsolete): void
    {
        $this->obsolete = $obsolete;
    }

    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    /**
     * @return $this
     */
    public function setUsers(?Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
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
