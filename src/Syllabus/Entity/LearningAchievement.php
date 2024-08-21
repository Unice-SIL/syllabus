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
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @package App\Syllabus\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\LearningAchievementTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_LEARNING_ACHIEVEMENT_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_LEARNING_ACHIEVEMENT_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_LEARNING_ACHIEVEMENT_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_LEARNING_ACHIEVEMENT_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_LEARNING_ACHIEVEMENT_POST\')')
        ],
        filters: ['id.search_filter'],
        security: 'is_granted(\'ROLE_API_LEARNING_ACHIEVEMENT\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_critical_achievements/{id}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_critical_achievements/{courseCriticalAchievements}/learning_achievements.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseCriticalAchievements' => new Link(toProperty: 'courseCriticalAchievement', fromClass: CourseCriticalAchievement::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter']
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'learning_achievement')]
class LearningAchievement
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
    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: false)]
    private string $description;

    
    #[ORM\Column(name: 'score', type: 'integer')]
    private int $score = 0;

    #[ManyToOne(targetEntity: CourseCriticalAchievement::class, inversedBy: 'learningAchievements')]
    #[JoinColumn(name: 'course_critical_achievement_learning_achievement', referencedColumnName: 'id')]
    private mixed $courseCriticalAchievement;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): LearningAchievement
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): LearningAchievement
    {
        $this->description = $description;
        return $this;
    }

    public function getCourseCriticalAchievement(): mixed
    {
        return $this->courseCriticalAchievement;
    }

    /**
     * @param $courseCriticalAchievement
     */
    public function setCourseCriticalAchievement($courseCriticalAchievement): LearningAchievement
    {
        $this->courseCriticalAchievement = $courseCriticalAchievement;
        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}