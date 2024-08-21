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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CourseSectionActivity
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseSectionActivityTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_COURSE_SECTION_ACTIVITY_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_SECTION_ACTIVITY_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_SECTION_ACTIVITY_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_SECTION_ACTIVITY_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_SECTION_ACTIVITY_POST\')')
        ],
        filters: ['id.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE_SECTION_ACTIVITY\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: self::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section')
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'course_section_activity')]
class CourseSectionActivity
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true)]
    private ?string $description;

    
    #[ORM\Column(name: 'evaluation_rate', type: 'float', nullable: true)]
    private ?float $evaluationRate;

    
    #[ORM\Column(name: 'evaluable', type: 'boolean', nullable: false)]
    private bool $evaluable = false;

    
    #[ORM\Column(name: 'evaluation_ct', type: 'boolean', nullable: false)]
    private bool $evaluationCt = false;

    
    #[ORM\Column(name: 'evaluation_teacher', type: 'boolean', nullable: false)]
    private bool $evaluationTeacher = false;

    
    #[ORM\Column(name: 'evaluation_peer', type: 'boolean', nullable: false)]
    private bool $evaluationPeer = false;

    
    #[ORM\Column(name: 'position', type: 'integer', nullable: false)]
    private int $position = 0;

    
    #[ORM\ManyToOne(targetEntity: Activity::class)]
    #[Assert\NotBlank(groups: ['new'])]
    #[ORM\JoinColumn(name: 'activity_id', referencedColumnName: 'id', nullable: false)]
    private Activity $activity;

    
    #[ORM\ManyToOne(targetEntity: ActivityType::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(name: 'activity_type_id', referencedColumnName: 'id', nullable: false)]
    private ?ActivityType $activityType;

    
    #[ORM\ManyToOne(targetEntity: ActivityMode::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(name: 'activity_mode_id', referencedColumnName: 'id', nullable: false)]
    private ?ActivityMode $activityMode;

    
    #[ORM\ManyToOne(targetEntity: CourseSection::class, inversedBy: 'courseSectionActivities')]
    #[ORM\JoinColumn(name: 'course_section_id', referencedColumnName: 'id', nullable: false)]
    private ?CourseSection $courseSection;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(? string $id): self
    {
        $this->id = $id;

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

    public function getEvaluationRate(): ?float
    {
        return $this->evaluationRate;
    }

    public function isEvaluable(): bool
    {
        return $this->evaluable;
    }

    public function setEvaluable(bool $evaluable): self
    {
        $this->evaluable = $evaluable;
        return $this;
    }

    public function isEvaluationCt(): bool
    {
        return $this->evaluationCt;
    }

    public function setEvaluationCt(bool $evaluationCt): self
    {
        $this->evaluationCt = $evaluationCt;
        return $this;
    }

    public function setEvaluationRate(?float $evaluationRate): self
    {
        $this->evaluationRate = $evaluationRate;

        return $this;
    }

    public function isEvaluationTeacher(): bool
    {
        return $this->evaluationTeacher;
    }

    public function setEvaluationTeacher(bool $evaluationTeacher): self
    {
        $this->evaluationTeacher = $evaluationTeacher;

        return $this;
    }

    public function isEvaluationPeer(): bool
    {
        return $this->evaluationPeer;
    }

    public function setEvaluationPeer(bool $evaluationPeer): self
    {
        $this->evaluationPeer = $evaluationPeer;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }


    /**
     * @return Activity
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getCourseSection(): ?CourseSection
    {
        return $this->courseSection;
    }

    public function setCourseSection(?CourseSection $courseSection): self
    {
        $this->courseSection = $courseSection;

        return $this;
    }

    public function getActivityType(): ?ActivityType
    {
        return $this->activityType;
    }

    public function setActivityType(?ActivityType $activityType): self
    {
        $this->activityType = $activityType;
        return $this;
    }

    public function getActivityMode(): ?ActivityMode
    {
        return $this->activityMode;
    }

    public function setActivityMode(?ActivityMode $activityMode): self
    {
        $this->activityMode = $activityMode;
        return $this;
    }

    
    public function getActivityApi(): ?string
    {
        return $this->getActivity()->getId();
    }

    
    public function getActivityTypeApi(): ?string
    {
        return $this->getActivityType()->getId();
    }


    
    public function getActivityModeApi(): ?string
    {
        return $this->getActivityMode()->getId();
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getActivity()->getLabel();
    }
}
