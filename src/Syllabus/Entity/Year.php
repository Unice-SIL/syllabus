<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Metadata\Link;
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
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Year
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\YearTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_YEAR_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_YEAR_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_YEAR_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_YEAR_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_YEAR_POST\')')
        ],
        filters: ['id.search_filter', 'label.search_filter'],
        security: 'is_granted(\'ROLE_API_YEAR\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: ['id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/year.{_format}',
        operations: [new Get()],
        uriVariables: ['id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/year.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'year', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter']
    )
]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\YearDoctrineRepository::class)]
#[UniqueEntity('id')]
#[UniqueEntity('label')]
#[ORM\Table(name: 'year')]
class Year
{
    
    #[ORM\Column(name: 'id', type: 'string', length: 4, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    #[Assert\Regex(pattern: '/^\d{4}$/', message: 'Cette valeur doit respecter le format AAAA')]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'label', type: 'string', length: 45, nullable: false, options: ['fixed' => true])]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    private ?string $label;

    
    #[ORM\Column(name: 'import', type: 'boolean', nullable: true)]
    private bool $import = false;

    
    #[ORM\Column(name: 'edit', type: 'boolean', nullable: true)]
    private bool $edit = false;

    
    #[ORM\Column(name: 'current', type: 'boolean', nullable: true)]
    private bool $current = false;

    #[ORM\OneToMany(targetEntity: CourseInfo::class, mappedBy: 'year')]
    private $courseInfos;

    /**
     * Year constructor.
     */
    public function __construct()
    {
        $this->courseInfos = new ArrayCollection();
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getImport(): bool
    {
        return $this->import;
    }

    public function setImport(bool $import): self
    {
        $this->import = $import;

        return $this;
    }

    public function getEdit(): bool
    {
        return $this->edit;
    }

    public function setEdit(bool $edit): self
    {
        $this->edit = $edit;

        return $this;
    }

    public function getCurrent(): bool
    {
        return $this->current;
    }

    public function setCurrent(bool $current): self
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseInfos(): ?Collection
    {
        return $this->courseInfos;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }


}
