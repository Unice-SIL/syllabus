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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CourseSectionActivity
 *
 * @ORM\Table(name="course_section_activity")
 * @ORM\Entity
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
class CourseSectionActivity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private string $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $description;

    /**
     * @var float|null
     *
     * @ORM\Column(name="evaluation_rate", type="float", nullable=true)
     */
    private ?float $evaluationRate;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluable", type="boolean", nullable=false)
     */
    private bool $evaluable = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation_ct", type="boolean", nullable=false)
     */
    private bool $evaluationCt = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation_teacher", type="boolean", nullable=false)
     */
    private bool $evaluationTeacher = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation_peer", type="boolean", nullable=false)
     */
    private bool $evaluationPeer = false;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private int $position = 0;

    /**
     * @var Activity
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\Activity")
     * @Assert\NotBlank(groups={"new"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     * })
     */
    private Activity $activity;

    /**
     * @var ActivityType|null
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\ActivityType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_type_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private ?ActivityType $activityType;

    /**
     * @var ActivityMode|null
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\ActivityMode")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_mode_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private ?ActivityMode $activityMode;

    /**
     * @var CourseSection|null
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\CourseSection", inversedBy="courseSectionActivities",)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_section_id", referencedColumnName="id", nullable=false)
     * })
     */
    private ?CourseSection $courseSection;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return CourseSectionActivity
     */
    public function setId(? string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return CourseSectionActivity
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getEvaluationRate(): ?float
    {
        return $this->evaluationRate;
    }

    /**
     * @return bool
     */
    public function isEvaluable(): bool
    {
        return $this->evaluable;
    }

    /**
     * @param bool $evaluable
     * @return CourseSectionActivity
     */
    public function setEvaluable(bool $evaluable): self
    {
        $this->evaluable = $evaluable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEvaluationCt(): bool
    {
        return $this->evaluationCt;
    }

    /**
     * @param bool $evaluationCt
     * @return CourseSectionActivity
     */
    public function setEvaluationCt(bool $evaluationCt): self
    {
        $this->evaluationCt = $evaluationCt;
        return $this;
    }

    /**
     * @param float|null $evaluationRate
     * @return CourseSectionActivity
     */
    public function setEvaluationRate(?float $evaluationRate): self
    {
        $this->evaluationRate = $evaluationRate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEvaluationTeacher(): bool
    {
        return $this->evaluationTeacher;
    }

    /**
     * @param bool $evaluationTeacher
     * @return CourseSectionActivity
     */
    public function setEvaluationTeacher(bool $evaluationTeacher): self
    {
        $this->evaluationTeacher = $evaluationTeacher;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEvaluationPeer(): bool
    {
        return $this->evaluationPeer;
    }

    /**
     * @param bool $evaluationPeer
     * @return CourseSectionActivity
     */
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

    /**
     * @param int $position
     * @return CourseSectionActivity
     */
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

    /**
     * @param Activity $activity
     * @return CourseSectionActivity
     */
    public function setActivity(Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return CourseSection|null
     */
    public function getCourseSection(): ?CourseSection
    {
        return $this->courseSection;
    }

    /**
     * @param CourseSection|null $courseSection
     * @return CourseSectionActivity
     */
    public function setCourseSection(?CourseSection $courseSection): self
    {
        $this->courseSection = $courseSection;

        return $this;
    }

    /**
     * @return ActivityType|null
     */
    public function getActivityType(): ?ActivityType
    {
        return $this->activityType;
    }

    /**
     * @param ActivityType|null $activityType
     * @return CourseSectionActivity
     */
    public function setActivityType(?ActivityType $activityType): self
    {
        $this->activityType = $activityType;
        return $this;
    }

    /**
     * @return ActivityMode|null
     */
    public function getActivityMode(): ?ActivityMode
    {
        return $this->activityMode;
    }

    /**
     * @param ActivityMode|null $activityMode
     * @return CourseSectionActivity
     */
    public function setActivityMode(?ActivityMode $activityMode): self
    {
        $this->activityMode = $activityMode;
        return $this;
    }

    /**
     *
     * @return null|string
     */
    public function getActivityApi(): ?string
    {
        return $this->getActivity()->getId();
    }

    /**
     *
     * @return null|string
     */
    public function getActivityTypeApi(): ?string
    {
        return $this->getActivityType()->getId();
    }


    /**
     *
     * @return null|string
     */
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
