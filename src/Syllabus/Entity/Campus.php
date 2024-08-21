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
use App\Syllabus\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups as Groups;

/**
 * Class Campus
 * @package App\Syllabus\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CampusTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_CAMPUS_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_CAMPUS_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_CAMPUS_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_CAMPUS_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_CAMPUS_POST\')')
        ],
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_CAMPUS\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/campuses.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'campuses', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['campuses']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[UniqueEntity(fields: ['code', 'source'], message: 'Le campus avec pour code établissement {{ value }} existe déjà pour cette source', errorPath: 'code')]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\CampusDoctrineRepository::class)]
#[ORM\Table(name: 'campus')]
#[ORM\UniqueConstraint(name: 'code_source_on_campus_UNIQUE', columns: ['code', 'source'])]
class Campus
{

    use Importable;

    /**
     * @Groups({"campuses"})
     */
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id;

    /**
     * @Groups({"campuses"})
     */
    #[ORM\Column(name: 'label', type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank]
    private string $label;

    /**
     *
     * @Gedmo\Translatable
     * @Groups({"campuses"})
     */
    #[ORM\Column(name: 'grp', type: 'string', length: 100, nullable: true)]
    private ?string $grp;

    /**
     * @Groups({"campuses"})
     */
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private bool $obsolete = false;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id):self
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

    public function getGrp(): ?string
    {
        return $this->grp;
    }

    public function setGrp(?string $grp): self
    {
        $this->grp = $grp;
        return $this;
    }

    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}