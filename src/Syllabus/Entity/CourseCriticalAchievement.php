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
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * Class CourseCriticalAchievement
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseCriticalAchievementTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_COURSE_CRITICAL_ACHIEVEMENT_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_CRITICAL_ACHIEVEMENT_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_CRITICAL_ACHIEVEMENT_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_CRITICAL_ACHIEVEMENT_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_CRITICAL_ACHIEVEMENT_POST\')')
        ],
        filters: ['id.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE_CRITICAL_ACHIEVEMENT\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),

            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_critical_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'course_critical_achievement')]
class CourseCriticalAchievement
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
    #[ORM\Column(name: 'rule', type: 'text', length: 50, nullable: false)]
    private ?string $rule;

    
    #[ORM\Column(name: 'score', type: 'integer')]
    private int $score = 0;

    #[OneToMany(targetEntity: LearningAchievement::class, mappedBy: 'courseCriticalAchievement', cascade: ['persist'], orphanRemoval: true)]
    private ArrayCollection $learningAchievements;

    #[ManyToOne(targetEntity: CriticalAchievement::class, inversedBy: 'courseCriticalAchievements', cascade: ['persist'])]
    #[JoinColumn(name: 'critical_achievement_course_critical_achievement', referencedColumnName: 'id')]
    private mixed $criticalAchievement;

    #[ManyToOne(targetEntity: CourseInfo::class, inversedBy: 'courseCriticalAchievements')]
    #[JoinColumn(name: 'course_info_course_critical_achievement', referencedColumnName: 'id')]
    private mixed $courseInfo;

    /**
     * CourseCriticalAchievement constructor.
     */
    public function __construct() {
        $this->learningAchievements = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): CourseCriticalAchievement
    {
        $this->id = $id;
        return $this;
    }

    public function getRule(): ?string
    {
        return $this->rule;
    }

    public function setRule(string $rule): CourseCriticalAchievement
    {
        $this->rule = $rule;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): CourseCriticalAchievement
    {
        $this->score = $score;
        return $this;
    }

    public function addLearningAchievement(LearningAchievement $learningAchievement): self
    {
        if (!$this->learningAchievements->contains($learningAchievement))
        {
            $this->learningAchievements->add($learningAchievement);
        }
        return $this;
    }

    public function removeLearningAchievement(LearningAchievement $learningAchievement): self
    {
        if ($this->learningAchievements->contains($learningAchievement))
        {
            $this->learningAchievements->removeElement($learningAchievement);
        }
        return $this;
    }

    public function getLearningAchievements(): ArrayCollection
    {
        return $this->learningAchievements;
    }

    /**
     * @param $learningAchievements
     */
    public function setLearningAchievements($learningAchievements): CourseCriticalAchievement
    {
        $this->learningAchievements = $learningAchievements;
        return $this;
    }

    public function getCriticalAchievement(): mixed
    {
        return $this->criticalAchievement;
    }

    /**
     * @param $criticalAchievement
     */
    public function setCriticalAchievement($criticalAchievement): void
    {
        $this->criticalAchievement = $criticalAchievement;
    }

    public function getCourseInfo(): mixed
    {
        return $this->courseInfo;
    }

    /**
     * @param $courseInfo
     */
    public function setCourseInfo($courseInfo): CourseCriticalAchievement
    {
        $this->courseInfo = $courseInfo;
        return $this;
    }

}