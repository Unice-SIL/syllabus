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

/**
 * Course
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_COURSE_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_POST\')')
        ],
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'parents' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'parents' => new Link(fromClass: self::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'children' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'children' => new Link(fromClass: self::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: self::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/parents/{parents}/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/childrens/{children}/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: self::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: self::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'code.search_filter']
    )
]
#[UniqueEntity(fields: ['code', 'source'], message: 'Le cours avec pour code établissement {{ value }} existe déjà pour cette source', errorPath: 'code')]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\CourseDoctrineRepository::class)]
#[ORM\Table(name: 'course')]
#[ORM\UniqueConstraint(name: 'code_source_on_course_UNIQUE', columns: ['code', 'source'])]
class Course
{
    use Importable;

    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'type', type: 'string', length: 5, nullable: false, options: ['fixed' => true])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 5)]
    private string $type;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'title', type: 'string', length: 150, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 150)]
    private string $title;

    
    #[ORM\JoinTable(name: 'course_hierarchy')]
    #[ORM\JoinColumn(name: 'course_child_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'course_parent_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'children', cascade: ['persist'])]
    private Collection $parents;

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'parents')]
    private Collection $children;

    
    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseInfo::class, cascade: ['persist'])]
    private Collection $courseInfos;

    #[ORM\ManyToMany(targetEntity: CriticalAchievement::class, inversedBy: 'courses', cascade: ['persist'])]
    private Collection $criticalAchievements;


    /**
     * @Gedmo\Locale
     */
    private string $locale = 'fr';

    #[ORM\ManyToMany(targetEntity: CoursePrerequisite::class, inversedBy: 'courses', cascade: ['persist'])]
    private Collection $coursePrerequisites;

    private array $hours = [];

    
    private ?float $ects;

    
    private ?string $structureCode;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->courseInfos = new ArrayCollection();
        $this->criticalAchievements = new ArrayCollection();
        $this->coursePrerequisites = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function setParents(Collection $parents): self
    {
        $this->parents = $parents;

        return $this;
    }

    public function addParent(Course $course): self
    {
        if (!$this->parents->contains($course)) {
            $this->parents->add($course);
            $course->addChild($this);
        }

        return $this;
    }

    public function removeParent(Course $course): self
    {
        if ($this->parents->contains($course)) {
            $this->parents->removeElement($course);
            $course->removeChild($this);
        }

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function setChildren(Collection $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function addChild(Course $course): self
    {

        if (!$this->children->contains($course)) {
            $this->children->add($course);
            $course->addParent($this);
        }

        return $this;
    }

    public function removeChild(Course $course): self
    {
        if ($this->children->contains($course)) {
            $this->children->removeElement($course);
            $course->removeParent($this);
        }

        return $this;
    }

    public function getCourseInfo(string $yearId): ?CourseInfo
    {
        foreach ($this->courseInfos as $courseInfo) {
            if ($courseInfo->getYear()->getId() === $yearId) {
                return $courseInfo;
            }
        }
        return null;
    }

    public function getCourseInfos(): Collection
    {
        return $this->courseInfos;
    }

    public function setCourseInfos(Collection $courseInfos): self
    {
        $this->courseInfos = $courseInfos;

        return $this;
    }

    public function addCourseInfo(CourseInfo $courseInfo): self
    {
        if (!$this->courseInfos->contains($courseInfo)) {
            $this->courseInfos->add($courseInfo);
            if ($courseInfo->getCourse() !== $this) {
                $courseInfo->setCourse($this);
            }
        }
        $this->courseInfos->add($courseInfo);

        return $this;
    }

    public function removeCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfos->removeElement($courseInfo);
        // Do not set course $courseInfo->course to null !

        return $this;
    }

    public function addCriticalAchievement(CriticalAchievement $criticalAchievement): self
    {
        if (!$this->criticalAchievements->contains($criticalAchievement)) {
            $this->criticalAchievements->add($criticalAchievement);
            if (!$criticalAchievement->getCourses()->contains($this)) {
                $criticalAchievement->getCourses()->add($this);
            }
        }
        return $this;
    }

    public function removeCriticalAchievement(CriticalAchievement $criticalAchievement): self
    {
        if ($this->criticalAchievements->contains($criticalAchievement)) {
            $this->criticalAchievements->removeElement($criticalAchievement);
            if ($criticalAchievement->getCourses()->contains($this)) {
                $criticalAchievement->getCourses()->removeElement($this);
            }
        }
        return $this;
    }

    public function getCriticalAchievements(): Collection
    {
        return $this->criticalAchievements;
    }

    public function setCriticalAchievements(Collection $criticalAchievements): Course
    {
        $this->criticalAchievements = $criticalAchievements;
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getCode();
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCoursePrerequisites(): Collection
    {
        return $this->coursePrerequisites;
    }

    /**
     * @param $coursePrerequisites
     * @return $this
     */
    public function setCoursePrerequisites($coursePrerequisites): self
    {
        $this->coursePrerequisites = $coursePrerequisites;
        return $this;
    }

    public function addCoursePrerequisite(CoursePrerequisite $coursePrerequisite): self
    {
        if (!$this->coursePrerequisites->contains($coursePrerequisite)) {
            $this->coursePrerequisites->add($coursePrerequisite);
            if (!$coursePrerequisite->getCourses()->contains($this)) {
                $coursePrerequisite->getCourses()->add($this);
            }
        }
        return $this;
    }

    public function removeCoursePrerequisite(CoursePrerequisite $coursePrerequisite): self
    {
        if ($this->coursePrerequisites->contains($coursePrerequisite)) {
            $this->coursePrerequisites->removeElement($coursePrerequisite);
            if ($coursePrerequisite->getCourses()->contains($this)) {
                $coursePrerequisite->getCourses()->removeElement($this);
            }
        }
        return $this;
    }

    public function getHours(): array
    {
        return $this->hours;
    }

    public function setHours(array $hours): void
    {
        $this->hours = $hours;
    }

    public function getEcts(): ?float
    {
        return $this->ects;
    }

    public function setEcts(?float $ects): void
    {
        $this->ects = $ects;
    }

    public function getStructureCode(): ?string
    {
        return $this->structureCode;
    }

    public function setStructureCode(?string $structureCode): void
    {
        $this->structureCode = $structureCode;
    }

}
