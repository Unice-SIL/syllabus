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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups as Groups;

/**
 * Class Language
 * @package App\Syllabus\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\LanguageTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_LANGUAGE_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_LANGUAGE_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_LANGUAGE_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_LANGUAGE_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_LANGUAGE_POST\')')
        ],
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_LANGUAGE\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/languages.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'languages', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        normalizationContext: ['groups' => ['language']],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\LanguageDoctrineRepository::class)]
#[ORM\Table(name: 'language')]
class Language
{

    use Importable;

    /**
     * @Groups({"language"})
     */
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     *
     * @Gedmo\Translatable
     * @Groups({"language"})
     */
    #[ORM\Column(name: 'label', type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank]
    private string $label;

    /**
     * @Groups({"language"})
     */
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private bool $obsolete = false;

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

    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param $obsolete
     */
    public function setObsolete($obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}