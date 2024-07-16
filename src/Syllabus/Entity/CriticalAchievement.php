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
use Doctrine\ORM\Mapping\OneToMany;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CriticalAchievement
 * @package App\Syllabus\Entity
 * @ORM\Table(name="critical_achievement")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\CriticalAchievementDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CriticalAchievementTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_CRITICAL_ACHIEVEMENT_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_CRITICAL_ACHIEVEMENT_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_CRITICAL_ACHIEVEMENT_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_CRITICAL_ACHIEVEMENT_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_CRITICAL_ACHIEVEMENT_POST\')')
        ], filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_CRITICAL_ACHIEVEMENT\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id'], toProperty: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/parents/{parents}/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/childrens/{children}/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_critical_achievements/{id}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']), '
            courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromProperty: 'criticalAchievements', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_critical_achievements/{courseCriticalAchievements}/critical_achievement.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(fromProperty: 'criticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
class CriticalAchievement
{
    use Importable;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private ?string $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private string $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private bool $obsolete = false;

    /**
     * @OneToMany(targetEntity="CourseCriticalAchievement", mappedBy="criticalAchievement")
     */
    private ArrayCollection $courseCriticalAchievements;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="criticalAchievements")
     */
    private Collection $courses;


    /**
     * CriticalAchievement constructor.
     */
    public function __construct() {
        $this->courseCriticalAchievements = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CriticalAchievement
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return $this
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
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
     * @return CriticalAchievement
     */
    public function setObsolete(bool $obsolete): CriticalAchievement
    {
        $this->obsolete = $obsolete;
        return $this;
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @return CriticalAchievement
     */
    public function addCourseCriticalAchievement(CourseCriticalAchievement $courseCriticalAchievement): self
    {
        if (!$this->courseCriticalAchievements->contains($courseCriticalAchievement))
        {
            $this->courseCriticalAchievements->add($courseCriticalAchievement);
        }
        return $this;
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @return CriticalAchievement
     */
    public function removeCourseCriticalAchievement(CourseCriticalAchievement $courseCriticalAchievement): self
    {
        if ($this->courseCriticalAchievements->contains($courseCriticalAchievement))
        {
            $this->courseCriticalAchievements->removeElement($courseCriticalAchievement);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourseCriticalAchievements(): ArrayCollection
    {
        return $this->courseCriticalAchievements;
    }

    /**
     * @param $courseCriticalAchievements
     * @return CriticalAchievement
     */
    public function setCourseCriticalAchievements($courseCriticalAchievements): CriticalAchievement
    {
        $this->courseCriticalAchievements = $courseCriticalAchievements;
        return $this;
    }

    /**
     * @param Course $course
     * @return CriticalAchievement
     */
    public function addCourse(Course $course): self
    {
        if(!$this->courses->contains($course))
        {
            $this->courses->add($course);
            if($course->getCriticalAchievements() !== $this)
            {
                $course->getCriticalAchievements()->add($this);
            }
        }
        $this->courses->add($course);

        return $this;
    }

    /**
     * @param Course $course
     * @return CriticalAchievement
     */
    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course))
        {
            $this->courses->removeElement($course);
            if ($course->getCriticalAchievements()->contains($this))
            {
                $course->getCriticalAchievements()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    /**
     * @param Collection $courses
     * @return CriticalAchievement
     */
    public function setCourses(Collection $courses): CriticalAchievement
    {
        $this->courses = $courses;
        return $this;
    }

}