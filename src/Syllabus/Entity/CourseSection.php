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
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CourseSection
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseSectionTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_COURSE_SECTION_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_SECTION_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_SECTION_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_SECTION_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_SECTION_POST\')')
        ],
        filters: ['id.search_filter', 'title.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE_SECTION\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter']
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'course_section')]
class CourseSection
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'title', type: 'string', length: 200, nullable: true)]
    private ?string $title;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: true)]
    private ?string $description;

    
    #[ORM\Column(name: 'url', type: 'text', length: 32767, nullable: true)]
    private ?string $url;

    
    #[ORM\Column(name: 'position', type: 'integer', nullable: false)]
    private int $position = 0;

    
    #[ORM\ManyToOne(targetEntity: CourseInfo::class, inversedBy: 'courseSections')]
    #[ORM\JoinColumn(name: 'course_info_id', referencedColumnName: 'id', nullable: false)]
    private CourseInfo $courseInfo;

    
    #[ORM\OneToMany(targetEntity: CourseSectionActivity::class, mappedBy: 'courseSection', cascade: ['persist', 'remove', 'merge'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $courseSectionActivities;

    /**
     * CourseSection constructor.
     */
    public function __construct()
    {
        $this->courseSectionActivities = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCourseInfo(): ?CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @return $this
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    public function getCourseSectionActivities(): Collection
    {
        return $this->courseSectionActivities;
    }

    public function setCourseSectionActivities(Collection $courseSectionActivities): self
    {
        $this->courseSectionActivities = $courseSectionActivities;

        return $this;
    }

    public function addCourseSectionActivity(CourseSectionActivity $courseSectionActivity): self
    {
        if(!$this->courseSectionActivities->contains($courseSectionActivity))
        {
            $this->courseSectionActivities->add($courseSectionActivity);
            if($courseSectionActivity->getCourseSection() !== $this)
            {
                $courseSectionActivity->setCourseSection($this);
            }
        }

        return $this;
    }

    public function removeCourseSectionActivity(CourseSectionActivity $courseSectionActivity): self
    {
        if ($this->courseSectionActivities->contains($courseSectionActivity))
        {
            $this->courseSectionActivities->removeElement($courseSectionActivity);
            if ($courseSectionActivity->getCourseSection() === $this)
            {
                $courseSectionActivity->setCourseSection(null);
            }
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     *
     */
    public function __clone()
    {
        $this->courseSectionActivities = clone $this->courseSectionActivities;
        /**
         * @var  $k
         * @var CourseSectionActivity $courseSectionActivity
         */
        foreach ($this->courseSectionActivities as $k => $courseSectionActivity){
            $courseSectionActivity = clone $courseSectionActivity;
            $courseSectionActivity->setId(Uuid::uuid4())
                ->setCourseSection($this);
            $this->courseSectionActivities->offsetSet($k, $courseSectionActivity);
        }
    }

}
