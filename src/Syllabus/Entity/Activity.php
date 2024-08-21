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
 * Activity
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\ActivityTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_ACTIVITY_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_ACTIVITY_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_ACTIVITY_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_ACTIVITY_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_ACTIVITY_POST\')')
        ],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_ACTIVITY\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\ActivityDoctrineRepository::class)]
#[ORM\Table(name: 'activity')]
class Activity
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'label', type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank]
    private string $label;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'description', type: 'string', length: 400, nullable: true)]
    #[Assert\Length(max: 200)]
    private ?string $description;

    
    #[ORM\Column(name: 'label_visibility', type: 'boolean', nullable: false, options: ['comment' => "Témoin affichage de l'intitulé de l'activité"])]
    private bool $labelVisibility = true;

    
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private bool $obsolete = false;

    
    #[ORM\Column(name: 'position', type: 'integer', nullable: false)]
    private int $position = 0;

    
    #[ORM\ManyToMany(targetEntity: ActivityType::class, mappedBy: 'activities')]
    #[Assert\Count(min: 1)]
    private Collection|ArrayCollection $activityTypes;

    /**
     * Activity constructor.
     */
    public function __construct()
    {
        $this->activityTypes = new ArrayCollection();
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

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function isLabelVisibility(): bool
    {
        return $this->labelVisibility;
    }

    public function setLabelVisibility(bool $labelVisibility): self
    {
        $this->labelVisibility = $labelVisibility;

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

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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

    /**
     * @return Collection
     */
    public function getActivityTypes(): ?Collection
    {
        return $this->activityTypes;
    }

    public function setActivityTypes(Collection $activityTypes): self
    {
        $this->activityTypes = $activityTypes;
        return $this;
    }

    public function addActivityType(ActivityType $activityType): self
    {
        if (!$this->activityTypes->contains($activityType))
        {
            $this->activityTypes->add($activityType);
            if (!$activityType->getActivities()->contains($this))
            {
                $activityType->getActivities()->add($this);
            }
        }
        return $this;
    }

    public function removeActivityType(ActivityType $activityType): self
    {
        if ($this->activityTypes->contains($activityType))
        {
            $this->activityTypes->removeElement($activityType);
            if ($activityType->getActivities()->contains($this))
            {
                $activityType->getActivities()->removeElement($this);
            }
        }
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
