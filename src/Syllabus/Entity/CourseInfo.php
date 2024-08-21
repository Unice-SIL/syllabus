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
use App\Syllabus\Validator\Constraints as AssertCustom;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use App\Syllabus\Controller\Api\CourseInfoController;
/**
 * CourseInfo
 * @package App\Syllabus\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseInfoTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(uriTemplate: '/course_infos/duplicate/{code1}/{year1}/{code2}/{year2}', controller: CourseInfoController::class),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_INFO_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_INFO_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_INFO_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_INFO_POST\')')
        ],
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE_INFO\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: self::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course')
        ],
        status: 200,
        filters: ['id.search_filter', 'title.search_filter', 'year.search_filter']
    )
]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository::class)]
#[UniqueEntity(fields: ['year', 'course'], message: 'Le cours {{ value }} existe déjà pour cette année', errorPath: 'course')]
#[ORM\Table(name: 'course_info')]
class CourseInfo
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'title', type: 'string', length: 200, nullable: false)]
    #[Assert\NotBlank(groups: ['new', 'edit'])]
    #[Assert\Length(max: 200, groups: ['new', 'edit'])]
    private string $title;

    
    #[ORM\Column(name: 'ects', type: 'float', nullable: true)]
    private ?float $ects;

    
    #[ORM\Column(name: 'bak_languages', type: 'string', length: 200, nullable: true)]
    private string $bakLanguages;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'summary', type: 'text', length: 65535, nullable: true)]
    #[Assert\NotBlank(groups: ['presentation'])]
    private ?string $summary;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'media_type', type: 'string', length: 10, nullable: true)]
    private ?string $mediaType;

    
    #[ORM\Column(name: 'image', type: 'text', length: 65535, nullable: true)]
    #[Assert\File(maxSize: '2M', mimeTypes: ['image/jpeg', 'image/png'])]
    private ?string $image = null;

    
    #[ORM\Column(name: 'video', type: 'text', length: 65535, nullable: true)]
    private ?string $video;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'teaching_mode', type: 'string', length: 15, nullable: true, options: ['fixed' => true])]
    #[Assert\NotBlank(groups: ['presentation'])]
    #[Assert\Expression("value not in ['distant'] or (this.getTeachingCmDist() != null or this.getTeachingTdDist() != null or this.getTeachingsByMode('distant').count() > 0)", message: 'teaching_mode.distant_hourly_empty', groups: ['presentation'])]
    #[Assert\Expression("value not in ['hybrid'] or (this.getTeachingCmHybridClass() != null or this.getTeachingTdHybridClass() != null or this.getTeachingTpHybridClass() != null or this.getTeachingsByMode('class').count() > 0)", message: 'teaching_mode.hybrid_class_hourly_empty', groups: ['presentation'])]
    #[Assert\Expression("value not in ['hybrid'] or (this.getTeachingCmHybridDist() != null or this.getTeachingTdHybridDist() != null or this.getTeachingsByMode('distant').count() > 0)", message: 'teaching_mode.hybrid_distant_hourly_empty', groups: ['presentation'])]
    private ?string $teachingMode;

    
    #[ORM\Column(name: 'teaching_cm_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingCmClass;

    
    #[ORM\Column(name: 'teaching_td_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingTdClass;

    
    #[ORM\Column(name: 'teaching_tp_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingTpClass;

    
    #[ORM\Column(name: 'teaching_other_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingOtherClass;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'teaching_other_type_class', type: 'string', length: 65, nullable: true)]
    private ?string $teachingOtherTypeClass;

    
    #[ORM\Column(name: 'teaching_cm_hybrid_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingCmHybridClass;

    
    #[ORM\Column(name: 'teaching_td_hybrid_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingTdHybridClass;

    
    #[ORM\Column(name: 'teaching_tp_hybrid_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingTpHybridClass;

    
    #[ORM\Column(name: 'teaching_other_hybrid_class', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingOtherHybridClass;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'teaching_other_type_hybrid_class', type: 'string', length: 65, nullable: true)]
    private ?string $teachingOtherTypeHybridClass;

    
    #[ORM\Column(name: 'teaching_cm_hybrid_dist', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingCmHybridDist;

    
    #[ORM\Column(name: 'teaching_td_hybrid_dist', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingTdHybridDist;

    
    #[ORM\Column(name: 'teaching_other_hybrid_dist', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingOtherHybridDist;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'teaching_other_type_hybrid_distant', type: 'string', length: 65, nullable: true)]
    private ?string $teachingOtherTypeHybridDistant;

    
    #[ORM\Column(name: 'teaching_cm_dist', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingCmDist;

    
    #[ORM\Column(name: 'teaching_td_dist', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingTdDist;

    
    #[ORM\Column(name: 'teaching_other_dist', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $teachingOtherDist;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'teaching_other_type_distant', type: 'string', length: 65, nullable: true)]
    private ?string $teachingOtherTypeDist;

    
    #[ORM\OneToMany(mappedBy: 'courseInfo', targetEntity: Teaching::class, cascade: ['persist'], orphanRemoval: true)]
    #[Assert\Valid]
    private Collection $teachings;

    
    #[ORM\Column(name: 'mcc_weight', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $mccWeight;

    
    #[ORM\Column(name: 'mcc_compensable', type: 'boolean', nullable: false)]
    private bool $mccCompensable = false;

    
    #[ORM\Column(name: 'mcc_capitalizable', type: 'boolean', nullable: false)]
    private bool $mccCapitalizable = false;

    
    #[ORM\Column(name: 'mcc_cc_coeff_session_1', type: 'float', precision: 10, scale: 0, nullable: true)]
    #[Assert\Blank(groups: ['evaluation_empty'])]
    private ?float $mccCcCoeffSession1;

    
    #[ORM\Column(name: 'mcc_cc_nb_eval_session_1', type: 'integer', nullable: true)]
    private ?int $mccCcNbEvalSession1;

    
    #[ORM\Column(name: 'mcc_ct_coeff_session_1', type: 'float', precision: 10, scale: 0, nullable: true)]
    #[Assert\Blank(groups: ['evaluation_empty'])]
    private ?float $mccCtCoeffSession1;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'mcc_ct_nat_session_1', type: 'string', length: 100, nullable: true)]
    private ?string $mccCtNatSession1;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'mcc_ct_duration_session_1', type: 'string', length: 100, nullable: true)]
    private ?string $mccCtDurationSession1;

    
    #[ORM\Column(name: 'mcc_ct_coeff_session_2', type: 'float', precision: 10, scale: 0, nullable: true)]
    private ?float $mccCtCoeffSession2;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'mcc_ct_nat_session_2', type: 'string', length: 100, nullable: true)]
    private ?string $mccCtNatSession2;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'mcc_ct_duration_session_2', type: 'string', length: 100, nullable: true)]
    private ?string $mccCtDurationSession2;


    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'mcc_advice', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['evaluation_empty'])]
    private ?string $mccAdvice;

    
    #[ORM\Column(name: 'tutoring', type: 'boolean', nullable: false)]
    private bool $tutoring = false;

    
    #[ORM\Column(name: 'tutoring_teacher', type: 'boolean', nullable: false)]
    private bool $tutoringTeacher = false;

    
    #[ORM\Column(name: 'tutoring_student', type: 'boolean', nullable: false)]
    private bool $tutoringStudent = false;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'tutoring_description', type: 'text', length: 65535, nullable: true)]
    private ?string $tutoringDescription;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'educational_resources', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['equipments_empty'])]
    private ?string $educationalResources;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'bibliographic_resources', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['equipments_empty'])]
    private ?string $bibliographicResources;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'agenda', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['info_empty'])]
    private ?string $agenda;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'organization', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['info_empty'])]
    private ?string $organization;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'closing_remarks', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['closing_remarks_empty'])]
    private ?string $closingRemarks;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'closing_video', type: 'text', length: 65535, nullable: true)]
    #[Assert\Blank(groups: ['closing_remarks_empty'])]
    private ?string $closingVideo;

    
    #[ORM\Column(name: 'creation_date', type: 'datetime', nullable: false)]
    private ?DateTime $creationDate;

    
    #[ORM\Column(name: 'modification_date', type: 'datetime', nullable: true)]
    private ?DateTime $modificationDate;

    
    #[ORM\Column(name: 'publication_date', type: 'datetime', nullable: true)]
    private ?DateTime $publicationDate;

    
    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'courseInfos', cascade: ['persist'])]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id', nullable: false)]
    private Course $course;

    
    #[ORM\ManyToOne(targetEntity: Structure::class, cascade: ['persist'])]
    #[Assert\NotBlank(groups: ['new', 'edit'])]
    #[ORM\JoinColumn(name: 'structure_id', referencedColumnName: 'id', nullable: false)]
    private Structure $structure;

    
    #[ORM\JoinTable(name: 'course_info_campus')]
    #[ORM\JoinColumn(name: 'courseinfo_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'campus_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Campus::class)]
    #[Assert\Count(min: 1, groups: ['presentation'])]
    private Collection $campuses;

    
    #[ORM\JoinTable(name: 'course_info_language')]
    #[ORM\JoinColumn(name: 'courseinfo_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'language_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Language::class)]
    #[Assert\Count(min: 1, groups: ['presentation'])]
    #[ORM\OrderBy(['label' => 'ASC'])]
    private Collection $languages;

    
    #[ORM\JoinTable(name: 'course_info_domain')]
    #[ORM\JoinColumn(name: 'courseinfo_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'domain_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Domain::class)]
    #[Assert\Count(min: 1, groups: ['presentation'])]
    private Collection $domains;

    /**
     * @var ArrayCollection
     */
    #[ORM\JoinTable(name: 'course_info_period')]
    #[ORM\JoinColumn(name: 'courseinfo_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'period_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Period::class)]
    #[Assert\Count(min: 1, groups: ['presentation'])]
    private $periods;


    
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'last_updater', referencedColumnName: 'id')]
    private ?User $lastUpdater;

    
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'publisher', referencedColumnName: 'id', nullable: true)]
    private ?User $publisher;

    
    #[ORM\ManyToOne(targetEntity: Year::class, inversedBy: 'courseInfos')]
    #[Assert\NotBlank(groups: ['new', 'edit'])]
    #[ORM\JoinColumn(name: 'year_id', referencedColumnName: 'id', nullable: false)]
    private Year $year;

    
    #[ORM\OneToMany(targetEntity: CoursePermission::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    private Collection $coursePermissions;

    
    #[ORM\OneToMany(targetEntity: CourseTeacher::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['lastname' => 'ASC'])]
    #[Assert\Count(min: 1, groups: ['presentation'])]
    private Collection $courseTeachers;

    
    #[ORM\OneToMany(targetEntity: CourseSection::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Assert\Count(min: 1, groups: ['contentActivities'])]
    #[Assert\Valid]
    private Collection $courseSections;

    /**
     * @AssertCustom\AchievementConstraintValidator
     */
    #[ORM\OneToMany(targetEntity: CourseAchievement::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Assert\NotBlank]
    #[Assert\Count(min: 1, groups: ['objectives'])]
    private Collection $courseAchievements;

    /**
     * @AssertCustom\AchievementConstraintValidator
     */
    #[OneToMany(targetEntity: CourseCriticalAchievement::class, mappedBy: 'courseInfo')]
    #[Assert\NotBlank(groups: ['objectives'])]
    private Collection $courseCriticalAchievements;

    
    #[ORM\OneToMany(targetEntity: CoursePrerequisite::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $coursePrerequisites;

    
    #[ORM\OneToMany(targetEntity: CourseTutoringResource::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $courseTutoringResources;

    
    #[ORM\OneToMany(targetEntity: CourseResourceEquipment::class, mappedBy: 'courseInfo', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC', 'equipment' => 'ASC'])]
    #[Assert\Count(max: 0, groups: ['info_empty'])]
    #[Assert\Valid]
    private Collection $courseResourceEquipments;

    /**
     * @var ArrayCollection
     */
    #[ORM\JoinTable(name: 'courseinfo_level')]
    #[ORM\JoinColumn(name: 'courseinfo_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'level_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Level::class)]
    #[Assert\Count(min: 1, groups: ['presentation'])]
    private $levels;

    private ?string $previousImage = null;

    #[ORM\Column(name: 'duplicate_next_year', type: 'boolean', nullable: false)]
    private bool $duplicateNextYear = true;

    /**
     * CourseInfo constructor.
     */
    public function __construct()
    {
        $this->coursePermissions = new ArrayCollection();
        $this->courseTeachers = new ArrayCollection();
        $this->courseSections = new ArrayCollection();
        $this->courseAchievements = new ArrayCollection();
        $this->coursePrerequisites = new ArrayCollection();
        $this->courseTutoringResources = new ArrayCollection();
        $this->courseResourceEquipments = new ArrayCollection();
        $this->campuses = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->domains = new ArrayCollection();
        $this->periods = new ArrayCollection();
        $this->courseCriticalAchievements = new ArrayCollection();
        $this->teachings = new ArrayCollection();
        $this->levels = new ArrayCollection();
    }

    public function setCampuses(Collection $campuses): CourseInfo
    {
        $this->campuses = $campuses;
        return $this;
    }

    public function setLanguages(Collection $languages): CourseInfo
    {
        $this->languages = $languages;
        return $this;
    }

    public function setDomains(Collection $domains): CourseInfo
    {
        $this->domains = $domains;
        return $this;
    }

    public function setPeriods(ArrayCollection $periods): CourseInfo
    {
        $this->periods = $periods;
        return $this;
    }

    public function getDuplicateNextYear(): mixed
    {
        return $this->duplicateNextYear;
    }

    /**
     * @param $duplicateNextYear
     * @return $this
     */
    public function setDuplicateNextYear($duplicateNextYear):self
    {
        $this->duplicateNextYear = $duplicateNextYear;

        return $this;
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEcts(): ?float
    {
        return $this->ects;
    }

    /**
     * @return $this
     */
    public function setEcts(?int $ects): static
    {
        $this->ects = $ects;

        return $this;
    }

    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * @param $levels
     * @return $this
     */
    public function setLevels($levels): static
    {
        $this->levels = $levels;

        return $this;
    }

    public function addLevel(Level $level): self
    {
        if (!$this->levels->contains($level))
        {
            $this->levels->add($level);
        }
        return $this;
    }

    public function removeLevel(Level $level): self
    {
        if ($this->levels->contains($level))
        {
            $this->levels->removeElement($level);
        }
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param $summary
     * @return $this
     */
    public function setSummary($summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getTeachingMode(): ?string
    {
        return $this->teachingMode;
    }

    /**
     * @param $teachingMode
     * @return $this
     */
    public function setTeachingMode($teachingMode): static
    {
        $this->teachingMode = $teachingMode;

        return $this;
    }

    public function getTeachingCmClass(): ?float
    {
        return $this->teachingCmClass;
    }

    /**
     * @param $teachingCmClass
     * @return $this
     */
    public function setTeachingCmClass($teachingCmClass): static
    {
        $this->teachingCmClass = $teachingCmClass;

        return $this;
    }

    public function getTeachingTdClass(): ?float
    {
        return $this->teachingTdClass;
    }

    /**
     * @param $teachingTdClass
     * @return $this
     */
    public function setTeachingTdClass($teachingTdClass): static
    {
        $this->teachingTdClass = $teachingTdClass;

        return $this;
    }

    public function getTeachingTpClass(): ?float
    {
        return $this->teachingTpClass;
    }

    /**
     * @param $teachingTpClass
     * @return $this
     */
    public function setTeachingTpClass($teachingTpClass): static
    {
        $this->teachingTpClass = $teachingTpClass;

        return $this;
    }

    public function getTeachingOtherClass(): ?float
    {
        return $this->teachingOtherClass;
    }

    /**
     * @param $teachingOtherClass
     * @return $this
     */
    public function setTeachingOtherClass($teachingOtherClass): static
    {
        $this->teachingOtherClass = $teachingOtherClass;

        return $this;
    }

    public function getTeachingOtherTypeClass(): ?string
    {
        return $this->teachingOtherTypeClass;
    }

    /**
     * @param $teachingOtherTypeClass
     * @return $this
     */
    public function setTeachingOtherTypeClass($teachingOtherTypeClass): static
    {
        $this->teachingOtherTypeClass = $teachingOtherTypeClass;

        return $this;
    }


    public function getTeachingCmHybridClass(): ?float
    {
        return $this->teachingCmHybridClass;
    }

    /**
     * @param $teachingCmHybridClass
     * @return $this
     */
    public function setTeachingCmHybridClass($teachingCmHybridClass): static
    {
        $this->teachingCmHybridClass = $teachingCmHybridClass;

        return $this;
    }

    public function getTeachingTdHybridClass(): ?float
    {
        return $this->teachingTdHybridClass;
    }

    /**
     * @param $teachingTdHybridClass
     * @return $this
     */
    public function setTeachingTdHybridClass($teachingTdHybridClass): static
    {
        $this->teachingTdHybridClass = $teachingTdHybridClass;

        return $this;
    }

    public function getTeachingTpHybridClass(): ?float
    {
        return $this->teachingTpHybridClass;
    }

    /**
     * @param $teachingTpHybridClass
     * @return $this
     */
    public function setTeachingTpHybridClass($teachingTpHybridClass): static
    {
        $this->teachingTpHybridClass = $teachingTpHybridClass;

        return $this;
    }

    public function getTeachingOtherHybridClass(): ?float
    {
        return $this->teachingOtherHybridClass;
    }

    /**
     * @param $teachingOtherHybridClass
     * @return $this
     */
    public function setTeachingOtherHybridClass($teachingOtherHybridClass): static
    {
        $this->teachingOtherHybridClass = $teachingOtherHybridClass;

        return $this;
    }

    public function getTeachingOtherTypeHybridClass(): ?string
    {
        return $this->teachingOtherTypeHybridClass;
    }

    /**
     * @param $teachingOtherTypeHybridClass
     * @return $this
     */
    public function setTeachingOtherTypeHybridClass($teachingOtherTypeHybridClass): static
    {
        $this->teachingOtherTypeHybridClass = $teachingOtherTypeHybridClass;

        return $this;
    }


    public function getTeachingCmHybridDist(): ?float
    {
        return $this->teachingCmHybridDist;
    }

    /**
     * @param $teachingCmHybridDist
     * @return $this
     */
    public function setTeachingCmHybridDist($teachingCmHybridDist): static
    {
        $this->teachingCmHybridDist = $teachingCmHybridDist;

        return $this;
    }

    public function getTeachingTdHybridDist(): ?float
    {
        return $this->teachingTdHybridDist;
    }

    /**
     * @param $teachingTdHybridDist
     * @return $this
     */
    public function setTeachingTdHybridDist($teachingTdHybridDist): static
    {
        $this->teachingTdHybridDist = $teachingTdHybridDist;

        return $this;
    }

    public function getTeachingOtherHybridDist(): ?float
    {
        return $this->teachingOtherHybridDist;
    }

    /**
     * @param $teachingOtherHybridDist
     * @return $this
     */
    public function setTeachingOtherHybridDist($teachingOtherHybridDist): static
    {
        $this->teachingOtherHybridDist = $teachingOtherHybridDist;

        return $this;
    }

    public function getTeachingOtherTypeHybridDistant(): ?string
    {
        return $this->teachingOtherTypeHybridDistant;
    }

    /**
     * @param $teachingOtherTypeHybridDistant
     * @return $this
     */
    public function setTeachingOtherTypeHybridDistant($teachingOtherTypeHybridDistant): static
    {
        $this->teachingOtherTypeHybridDistant = $teachingOtherTypeHybridDistant;

        return $this;
    }

    public function getTeachingCmDist(): ?float
    {
        return $this->teachingCmDist;
    }

    public function setTeachingCmDist(?float $teachingCmDist): self
    {
        $this->teachingCmDist = $teachingCmDist;
        return $this;
    }

    public function getTeachingTdDist(): ?float
    {
        return $this->teachingTdDist;
    }

    public function setTeachingTdDist(?float $teachingTdDist): self
    {
        $this->teachingTdDist = $teachingTdDist;
        return $this;
    }

    public function getTeachingOtherDist(): ?float
    {
        return $this->teachingOtherDist;
    }

    public function setTeachingOtherDist(?float $teachingOtherDist): self
    {
        $this->teachingOtherDist = $teachingOtherDist;
        return $this;
    }

    public function getTeachingOtherTypeDist(): ?string
    {
        return $this->teachingOtherTypeDist;
    }

    public function setTeachingOtherTypeDist(?string $teachingOtherTypeDist): self
    {
        $this->teachingOtherTypeDist = $teachingOtherTypeDist;
        return $this;
    }

    public function getTeachings(): Collection
    {
        return $this->teachings;
    }

    public function getTeachingsByMode(string $mode): Collection
    {
        return $this->getTeachings()->filter(function(Teaching $teaching) use($mode){
            return $teaching->getMode() === $mode;
        });
    }

    public function setTeachings(Collection $teachings): self
    {
        $this->teachings = $teachings;

        return $this;
    }



    public function addTeaching(Teaching $teaching): self
    {
        if(!$this->teachings->contains($teaching))
        {
            $this->teachings->add($teaching);
            if($teaching->getCourseInfo() !== $this)
            {
                $teaching->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeTeaching(Teaching $teaching): self
    {
        if ($this->teachings->contains($teaching))
        {
            $this->teachings->removeElement($teaching);
            if ($teaching->getCourseInfo() === $this)
            {
                $teaching->setCourseInfo(null);
            }
        }

        return $this;
    }

    public function getMccWeight(): ?float
    {
        return $this->mccWeight;
    }

    /**
     * @param $mccWeight
     * @return $this
     */
    public function setMccWeight($mccWeight): static
    {
        $this->mccWeight = $mccWeight;

        return $this;
    }

    public function isMccCompensable(): bool
    {
        return $this->mccCompensable;
    }

    public function setMccCompensable(bool $mccCompensable): self
    {
        $this->mccCompensable = $mccCompensable;

        return $this;
    }

    public function isMccCapitalizable(): bool
    {
        return $this->mccCapitalizable;
    }

    public function setMccCapitalizable(bool $mccCapitalizable): self
    {
        $this->mccCapitalizable = $mccCapitalizable;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMccCcCoeffSession1()
    {
        return $this->mccCcCoeffSession1;
    }

    /**
     * @param $mccCcCoeffSession1
     * @return $this
     */
    public function setMccCcCoeffSession1($mccCcCoeffSession1): static
    {
        $this->mccCcCoeffSession1 = $mccCcCoeffSession1;

        return $this;
    }

    public function getMccCcNbEvalSession1(): ?int
    {
        return $this->mccCcNbEvalSession1;
    }

    public function setMccCcNbEvalSession1(?int $mccCcNbEvalSession1): static
    {
        $this->mccCcNbEvalSession1 = $mccCcNbEvalSession1;

        return $this;
    }

    public function getMccCtCoeffSession1(): ?float
    {
        return $this->mccCtCoeffSession1;
    }

    public function setMccCtCoeffSession1(?float $mccCtCoeffSession1): static
    {
        $this->mccCtCoeffSession1 = $mccCtCoeffSession1;

        return $this;
    }

    public function getMccCtNatSession1(): ?string
    {
        return $this->mccCtNatSession1;
    }

    public function setMccCtNatSession1(?string $mccCtNatSession1): static
    {
        $this->mccCtNatSession1 = $mccCtNatSession1;

        return $this;
    }

    public function getMccCtDurationSession1(): ?string
    {
        return $this->mccCtDurationSession1;
    }

    public function setMccCtDurationSession1(?string $mccCtDurationSession1): static
    {
        $this->mccCtDurationSession1 = $mccCtDurationSession1;

        return $this;
    }

    public function getMccCtCoeffSession2(): ?float
    {
        return $this->mccCtCoeffSession2;
    }

    public function setMccCtCoeffSession2(?float $mccCtCoeffSession2): static
    {
        $this->mccCtCoeffSession2 = $mccCtCoeffSession2;

        return $this;
    }

    public function getMccCtNatSession2(): ?string
    {
        return $this->mccCtNatSession2;
    }

    public function setMccCtNatSession2(?string $mccCtNatSession2): static
    {
        $this->mccCtNatSession2 = $mccCtNatSession2;

        return $this;
    }

    public function getMccCtDurationSession2(): ?string
    {
        return $this->mccCtDurationSession2;
    }

    public function setMccCtDurationSession2(?string $mccCtDurationSession2): static
    {
        $this->mccCtDurationSession2 = $mccCtDurationSession2;

        return $this;
    }

    public function getMccAdvice(): ?string
    {
        return $this->mccAdvice;
    }

    /**
     * @param null|string $mccAdvice
     */
    public function setMccAdvice($mccAdvice): static
    {
        $this->mccAdvice = $mccAdvice;

        return $this;
    }

    public function isTutoring(): bool
    {
        return $this->tutoring;
    }

    public function setTutoring(bool $tutoring): self
    {
        $this->tutoring = $tutoring;

        return $this;
    }

    public function isTutoringTeacher(): bool
    {
        return $this->tutoringTeacher;
    }

    public function setTutoringTeacher(bool $tutoringTeacher): self
    {
        $this->tutoringTeacher = $tutoringTeacher;

        return $this;
    }

    public function isTutoringStudent(): bool
    {
        return $this->tutoringStudent;
    }

    public function setTutoringStudent(bool $tutoringStudent): self
    {
        $this->tutoringStudent = $tutoringStudent;

        return $this;
    }

    public function getTutoringDescription(): ?string
    {
        return $this->tutoringDescription;
    }

    public function setTutoringDescription(?string $tutoringDescription): static
    {
        $this->tutoringDescription = $tutoringDescription;

        return $this;
    }

    public function getEducationalResources(): ?string
    {
        return $this->educationalResources;
    }

    public function setEducationalResources(?string $educationalResources): static
    {
        $this->educationalResources = $educationalResources;

        return $this;
    }

    public function getBibliographicResources(): ?string
    {
        return $this->bibliographicResources;
    }

    public function setBibliographicResources(?string $bibliographicResources): static
    {
        $this->bibliographicResources = $bibliographicResources;

        return $this;
    }

    public function getAgenda(): ?string
    {
        return $this->agenda;
    }

    public function setAgenda(?string $agenda): static
    {
        $this->agenda = $agenda;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function getClosingRemarks(): ?string
    {
        return $this->closingRemarks;
    }

    public function setClosingRemarks(?string $closingRemarks): static
    {
        $this->closingRemarks = $closingRemarks;

        return $this;
    }

    public function getClosingVideo(): ?string
    {
        return $this->closingVideo;
    }

    public function setClosingVideo(?string $closingVideo): static
    {
        $this->closingVideo = $closingVideo;

        return $this;
    }

    public function getCreationDate(): ?DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(?DateTime $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModificationDate(): ?DateTime
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?DateTime $modificationDate): static
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    public function getPublicationDate(): ?DateTime
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?DateTime $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    public function setMediaType(?string $mediaType): static
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * @return Course
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     *
     */
    public function getCourseApi(): ?string
    {
        return $this->getCourse()->getId();
    }

    /**
     * @return $this
     */
    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    /**
     *
     */
    public function getStructureApi(): ?string
    {
        return $this->getStructure()->getId();
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getLastUpdater(): ?User
    {
        return $this->lastUpdater;
    }

    public function setLastUpdater(?User $lastUpdater): self
    {
        $this->lastUpdater = $lastUpdater;

        return $this;
    }

    public function getPublisher(): ?User
    {
        return $this->publisher;
    }

    public function setPublisher(?User $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getYear(): ?Year
    {
        return $this->year;
    }

    /**
     *
     */
    public function getYearApi(): ?string
    {
        return $this->getYear()->getId();
    }

    public function setYear(Year $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCoursePermissions(): ?Collection
    {
        return $this->coursePermissions;
    }

    public function setCoursePermissions(Collection $coursePermissions): self
    {
        $this->coursePermissions = $coursePermissions;

        return $this;
    }

    /**
     * @return $this
     */
    public function addCoursePermission(CoursePermission $coursePermission): self
    {
        if(!$this->coursePermissions->contains($coursePermission))
        {
            $this->coursePermissions->add($coursePermission);
            if($coursePermission->getCourseInfo() != $this)
            {
                $coursePermission->setCourseInfo($this);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeCoursePermission(CoursePermission $coursePermission): self
    {
        if($this->coursePermissions->contains($coursePermission))
        {
            $this->coursePermissions->removeElement($coursePermission);
            if ($coursePermission->getCourseInfo() === $this)
            {
                $coursePermission->setCourseInfo(null);
            }
        }

        return $this;
    }

    public function getCourseTeachers(): Collection
    {
        return $this->courseTeachers;
    }

    public function setCourseTeachers(Collection $courseTeachers): self
    {
        $this->courseTeachers = $courseTeachers;

        return $this;
    }

    public function addCourseTeacher(CourseTeacher $courseTeacher): self
    {
        if(!$this->courseTeachers->contains($courseTeacher))
        {
            $this->courseTeachers->add($courseTeacher);
            if($courseTeacher->getCourseInfo() !== $this)
            {
                $courseTeacher->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeCourseTeacher(CourseTeacher $courseTeacher): self
    {
        if ($this->courseTeachers->contains($courseTeacher))
        {
            $this->courseTeachers->removeElement($courseTeacher);
            if ($courseTeacher->getCourseInfo() === $this)
            {
                $courseTeacher->setCourseInfo(null);
            }
        }
        return $this;
    }

    public function getCourseSections(): Collection
    {
        return $this->courseSections;
    }

    public function setCourseSections(Collection $courseSections): self
    {
        $this->courseSections = $courseSections;

        return $this;
    }

    public function addCourseSection(CourseSection $courseSection): self
    {
        if(!$this->courseSections->contains($courseSection))
        {
            $this->courseSections->add($courseSection);
            if($courseSection->getCourseInfo() !== $this)
            {
                $courseSection->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeCourseSection(CourseSection $courseSection): self
    {
        if ($this->courseSections->contains($courseSection))
        {
            $this->courseSections->removeElement($courseSection);
            if ($courseSection->getCourseInfo() === $this)
            {
                $courseSection->setCourseInfo(null);
            }
        }

        return $this;
    }


    public function getCourseAchievements(): Collection
    {
        return $this->courseAchievements;
    }

    public function setCourseAchievements(Collection $courseAchievements): self
    {
        $this->courseAchievements = $courseAchievements;

        return $this;
    }

    public function addCourseAchievement(CourseAchievement $courseAchievement): self
    {
        if(!$this->courseAchievements->contains($courseAchievement))
        {
            $this->courseAchievements->add($courseAchievement);
            if($courseAchievement->getCourseInfo() !== $this)
            {
                $courseAchievement->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeCourseAchievement(CourseAchievement $courseAchievement): self
    {
        if ($this->courseAchievements->contains($courseAchievement))
        {
            $this->courseAchievements->removeElement($courseAchievement);
            if ($courseAchievement->getCourseInfo() === $this)
            {
                $courseAchievement->setCourseInfo(null);
            }
        }

        return $this;
    }

    public function getCoursePrerequisites(): Collection
    {
        return $this->coursePrerequisites;
    }

    public function setCoursePrerequisites(Collection $coursePrerequisites): self
    {
        $this->coursePrerequisites = $coursePrerequisites;

        return $this;
    }

    public function addCoursePrerequisite(CoursePrerequisite $coursePrerequisite): self
    {
        if(!$this->coursePrerequisites->contains($coursePrerequisite))
        {
            $this->coursePrerequisites->add($coursePrerequisite);
            if($coursePrerequisite->getCourseInfo() !== $this)
            {
                $coursePrerequisite->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeCoursePrerequisite(CoursePrerequisite $coursePrerequisite): self
    {
        if ($this->coursePrerequisites->contains($coursePrerequisite))
        {
            $this->coursePrerequisites->removeElement($coursePrerequisite);
            if ($coursePrerequisite->getCourseInfo() === $this)
            {
                $coursePrerequisite->setCourseInfo(null);
            }
        }

        return $this;
    }

    public function getCourseTutoringResources(): Collection
    {
        return $this->courseTutoringResources;
    }

    public function setCourseTutoringResources(Collection $courseTutoringResources): self
    {
        $this->courseTutoringResources = $courseTutoringResources;

        return $this;
    }

    public function addCourseTutoringResource(CourseTutoringResource $courseTutoringResource): self
    {
        if(!$this->courseTutoringResources->contains($courseTutoringResource))
        {
            $this->courseTutoringResources->add($courseTutoringResource);
            if($courseTutoringResource->getCourseInfo() !== $this)
            {
                $courseTutoringResource->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeCourseTutoringResource(CourseTutoringResource $courseTutoringResource): self
    {
        if ($this->courseTutoringResources->contains($courseTutoringResource))
        {
            $this->courseTutoringResources->removeElement($courseTutoringResource);
            if ($courseTutoringResource->getCourseInfo() === $this)
            {
                $courseTutoringResource->setCourseInfo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseResourceEquipments(): ?Collection
    {
        return $this->courseResourceEquipments;
    }

    public function setCourseResourceEquipments(Collection $courseResourceEquipments): self
    {
        $this->courseResourceEquipments = $courseResourceEquipments;

        return $this;
    }

    public function addCourseResourceEquipment(CourseResourceEquipment $courseResourceEquipment): self
    {
        if(!$this->courseResourceEquipments->contains($courseResourceEquipment))
        {
            $this->courseResourceEquipments->add($courseResourceEquipment);
            if($courseResourceEquipment->getCourseInfo() !== $this)
            {
                $courseResourceEquipment->setCourseInfo($this);
            }
        }

        return $this;
    }

    public function removeCourseResourceEquipment(CourseResourceEquipment $courseResourceEquipment): self
    {
        if ($this->courseResourceEquipments->contains($courseResourceEquipment))
        {
            $this->courseResourceEquipments->removeElement($courseResourceEquipment);
            if ($courseResourceEquipment->getCourseInfo() === $this)
            {
                $courseResourceEquipment->setCourseInfo(null);
            }
        }
        return $this;
    }

    public function getPreviousImage(): ?string
    {
        return $this->previousImage;
    }

    /**
     * @param $previousImage
     * @return $this
     */
    public function setPreviousImage($previousImage): static
    {
        $this->previousImage = $previousImage;

        return $this;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language))
        {
            $this->languages->add($language);
        }
        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->languages->contains($language))
        {
            $this->languages->removeElement($language);
        }
        return $this;
    }

    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addCampus(Campus $campus): self
    {
        if (!$this->campuses->contains($campus))
        {
            $this->campuses->add($campus);
        }
        return $this;
    }

    public function removeCampus(Campus $campus): self
    {
        if ($this->campuses->contains($campus))
        {
            $this->campuses->removeElement($campus);
        }
        return $this;
    }

    public function getCampuses(): Collection
    {
        return $this->campuses;
    }

    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain))
        {
            $this->domains->add($domain);
        }
        return $this;
    }

    public function removeDomain(Domain $domain): self
    {
        if ($this->domains->contains($domain))
        {
            $this->domains->removeElement($domain);
        }
        return $this;
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period))
        {
            $this->periods->add($period);
        }
        return $this;
    }

    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period))
        {
            $this->periods->removeElement($period);
        }
        return $this;
    }

    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    public function addCourseCriticalAchievement(CourseCriticalAchievement $courseCriticalAchievement): self
    {
        if (!$this->courseCriticalAchievements->contains($courseCriticalAchievement))
        {
            $this->courseCriticalAchievements->add($courseCriticalAchievement);
        }
        return $this;
    }

    public function removeCourseCriticalAchievement(CourseCriticalAchievement $courseCriticalAchievement): self
    {
        if ($this->courseCriticalAchievements->contains($courseCriticalAchievement))
        {
            $this->courseCriticalAchievements->removeElement($courseCriticalAchievement);
        }
        return $this;
    }

    public function getCourseCriticalAchievements(): mixed
    {
        return $this->courseCriticalAchievements;
    }

    /**
     * @param $courseCriticalAchievements
     */
    public function setCourseCriticalAchievements($courseCriticalAchievements): CourseInfo
    {
        $this->courseCriticalAchievements = $courseCriticalAchievements;
        return $this;
    }

    public function getBakLanguages(): ?string
    {
        return $this->bakLanguages;
    }

    public function setBakLanguages(?string $bakLanguages): CourseInfo
    {
        $this->bakLanguages = $bakLanguages;
        return $this;
    }



    /**
     *
     */
    public function __clone()
    {

        // todo: loop on field instance or ArrayCollection (use reflection)
        if ($this->teachings instanceof ArrayCollection) {
            $this->teachings = clone $this->teachings;
            /**
             * @var  $k
             * @var  Teaching $teaching
             */
            foreach ($this->teachings as $k => $teaching){
                if (!$teaching instanceof Teaching) {
                    continue;
                }
                $teaching = clone $teaching;
                $teaching->setCourseInfo($this);
                $this->teachings->offsetSet($k, $teaching);
            }
        }

        if ($this->coursePermissions instanceof ArrayCollection) {
            $this->coursePermissions = clone $this->coursePermissions;
            /**
             * @var  $k
             * @var  CoursePermission $coursePermission
             */
            foreach ($this->coursePermissions as $k => $coursePermission){
                if (!$coursePermission instanceof CoursePermission) {
                    continue;
                }
                $coursePermission = clone $coursePermission;
                $coursePermission->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->coursePermissions->offsetSet($k, $coursePermission);
            }
        }

        if ($this->courseTeachers instanceof ArrayCollection) {
            $this->courseTeachers = clone $this->courseTeachers;
            /**
             * @var  $k
             * @var  CourseTeacher $courseTeacher
             */
            foreach ($this->courseTeachers as $k => $courseTeacher) {
                if (!$courseTeacher instanceof CourseTeacher) {
                    continue;
                }
                $courseTeacher = clone $courseTeacher;
                $courseTeacher->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->courseTeachers->offsetSet($k, $courseTeacher);
            }
        }

        if ($this->courseSections instanceof ArrayCollection) {
            $this->courseSections = clone $this->courseSections;
            /**
             * @var  $k
             * @var  CourseSection $courseSection
             */
            foreach ($this->courseSections as $k => $courseSection) {
                if (!$courseSection instanceof CourseSection) {
                    continue;
                }
                $courseSection = clone $courseSection;
                $courseSection->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->courseSections->offsetSet($k, $courseSection);
            }
        }

        if ($this->courseAchievements instanceof ArrayCollection) {

            $this->courseAchievements = clone $this->courseAchievements;
            /**
             * @var  $k
             * @var  CourseAchievement $courseAchievement
             */
            foreach ($this->courseAchievements as $k => $courseAchievement){
                if (!$courseAchievement instanceof CourseAchievement) {
                    continue;
                }
                $courseAchievement = clone $courseAchievement;
                $courseAchievement->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->courseAchievements->offsetSet($k, $courseAchievement);
            }
        }

        if ($this->coursePrerequisites instanceof ArrayCollection) {

            $this->coursePrerequisites = clone $this->coursePrerequisites;
            /**
             * @var  $k
             * @var  CoursePrerequisite $coursePrerequisite
             */
            foreach ($this->coursePrerequisites as $k => $coursePrerequisite){
                if (!$coursePrerequisite instanceof CoursePrerequisite) {
                    continue;
                }
                $coursePrerequisite = clone $coursePrerequisite;
                $coursePrerequisite->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->coursePrerequisites->offsetSet($k, $coursePrerequisite);
            }
        }

        if ($this->courseTutoringResources instanceof ArrayCollection) {

            $this->courseTutoringResources = clone $this->courseTutoringResources;
            /**
             * @var  $k
             * @var  CourseTutoringResource $courseTutoringResource
             */
            foreach ($this->courseTutoringResources as $k => $courseTutoringResource){
                if (!$courseTutoringResource instanceof CourseTutoringResource) {
                    continue;
                }
                $courseTutoringResource = clone $courseTutoringResource;
                $courseTutoringResource->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->courseTutoringResources->offsetSet($k, $courseTutoringResource);
            }
        }

        if ($this->courseResourceEquipments instanceof ArrayCollection) {

            $this->courseResourceEquipments = clone $this->courseResourceEquipments;
            /**
             * @var  $k
             * @var CourseResourceEquipment $courseResourceEquipment
             */
            foreach ($this->courseResourceEquipments as $k => $courseResourceEquipment){
                if (!$courseResourceEquipment instanceof CourseResourceEquipment) {
                    continue;
                }
                $courseResourceEquipment = clone $courseResourceEquipment;
                $courseResourceEquipment->setId(Uuid::v4())
                    ->setCourseInfo($this);
                $this->courseResourceEquipments->offsetSet($k, $courseResourceEquipment);
            }
        }
    }

    /**
     * Checks media consistency.
     */
    public function checkMedia(): void
    {
        $mediaType = $this->getMediaType();

        if (in_array($mediaType, ['image', 'video'])) {
            $mediaTypeAlt = $mediaType == "video" ? "image" : "video";
            $f1 = "get" . ucfirst($mediaType);
            $f2 = "get" . ucfirst($mediaTypeAlt);
            $f3 = "set" . ucfirst($mediaType);
            if (empty($this->$f1())) {
                if (!empty($this->$f2())) {
                    $this->setMediaType($mediaTypeAlt);
                } else {
                    $this->setMediaType(null);
                }
                $this->$f3(null);
            }
        } elseif ($this->getImage() !== null && $this->getImage() !== '' && $this->getImage() !== '0') {
            $this->setMediaType('image');
        } elseif($this->getVideo() !== null && $this->getVideo() !== '' && $this->getVideo() !== '0'){
            $this->setMediaType('video');
        } else{
            $this->setMediaType(null);
        }
    }

    public function getCodeYear(bool $dev = null): string
    {
        if ($dev) {
            return $this->course->getCode() . '__UNION__' . $this->year->getId();
        }
        return $this->course->getCode() . '-' . $this->year->getId();
    }

    public function setAllRelations(): void
    {
        $relations = [
            'coursePermissions',
            'courseTeachers',
            'courseSections',
            'courseAchievements',
            'coursePrerequisites',
            'courseTutoringResources',
            'courseResourceEquipments',
        ];

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($relations as $relation) {
            $arrayCollection = $propertyAccessor->getValue($this, $relation);
            if (null === $arrayCollection) {
                continue;
            }
            foreach ($arrayCollection as $element)
            {
                $propertyAccessor->setValue($element, 'courseInfo', $this);
                if ($element instanceof CourseSection) {
                    foreach ($element->getCourseSectionActivities() as $courseSectionActivity) {
                        $courseSectionActivity->setCourseSection($element);
                    }
                }
            }
        }
    }
}
