<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use JMS\Serializer\Annotation as JMS;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Validator\Constraints as AssertCustom;

/**
 * CourseInfo
 *
 * @ORM\Table(name="course_info")
 * @ORM\Entity
 * @UniqueEntity(fields={"year", "course"}, message="Le cours {{ value }} existe déjà pour cette année", errorPath="course")
 *
 */
class CourseInfo
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"default", "course_info"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=false)
     * @Assert\NotBlank(groups={"new", "edit"})
     * @JMS\Groups(groups={"default", "course_info"})
     */
    private $title;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ects", type="float", nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $ects;

    /**
     * @var string|null
     *
     * @ORM\Column(name="level", type="string", length=15, nullable=true, options={"fixed"=true})
     * @Assert\NotBlank(groups={"presentation"})
     * @JMS\Groups(groups={"api"})
     * @JMS\Groups(groups={"course_info"})
     *
     */
    private $level;

    /**
     * @var int|null
     *
     * @ORM\Column(name="semester", type="integer", nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $semester;

    /**
     * @var string|null
     *
     * @ORM\Column(name="summary", type="text", length=65535, nullable=true)
     * @Assert\NotBlank(groups={"presentation"})
     * @JMS\Groups(groups={"api"})
     * @JMS\Groups(groups={"course_info"})
     */
    private $summary;

    /**
     * @var string|null
     *
     * @ORM\Column(name="media_type", type="string", length=10, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mediaType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     * @Assert\File(
     *    maxSize="2M",
     *     mimeTypes={ "image/jpeg", "image/png" }
     *     )
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $video;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_mode", type="string", length=15, nullable=true, options={"fixed"=true})
     * @JMS\Groups(groups={"course_info"})
     *
     */
    private $teachingMode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingCmClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingTdClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_tp_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingTpClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     *
     */
    private $teachingOtherClass;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_class", type="string", length=65, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     *
     */
    private $teachingOtherTypeClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingCmHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingTdHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_tp_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingTpHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingOtherHybridClass;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_hybrid_class", type="string", length=65, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingOtherTypeHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_hybrid_dist", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingCmHybridDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_hybrid_dist", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingTdHybridDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_hybrid_dist", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingOtherHybridDist;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_hybrid_distant", type="string", length=65, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingOtherTypeHybridDistant;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_dist", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingCmDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_dist", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingTdDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_dist", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingOtherDist;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_distant", type="string", length=65, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $teachingOtherTypeDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_weight", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccWeight;

    /**
     * @var bool
     *
     * @ORM\Column(name="mcc_compensable", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCompensable = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="mcc_capitalizable", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCapitalizable = false;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_cc_coeff_session_1", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCcCoeffSession1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="mcc_cc_nb_eval_session_1", type="integer", nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCcNbEvalSession1;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_ct_coeff_session_1", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCtCoeffSession1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_nat_session_1", type="string", length=100, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCtNatSession1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_duration_session_1", type="string", length=100, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCtDurationSession1;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_ct_coeff_session_2", type="float", precision=10, scale=0, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCtCoeffSession2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_nat_session_2", type="string", length=100, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCtNatSession2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_duration_session_2", type="string", length=100, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccCtDurationSession2;


    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_advice", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $mccAdvice;

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info"})
     */
    private $tutoring = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring_teacher", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info"})
     */
    private $tutoringTeacher = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring_student", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info"})
     */
    private $tutoringStudent = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tutoring_description", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $tutoringDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="educational_resources", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $educationalResources;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bibliographic_resources", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $bibliographicResources;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agenda", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $agenda;

    /**
     * @var string|null
     *
     * @ORM\Column(name="organization", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $organization;

    /**
     * @var string|null
     *
     * @ORM\Column(name="closing_remarks", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $closingRemarks;

    /**
     * @var string|null
     *
     * @ORM\Column(name="closing_video", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $closingVideo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     * @JMS\Groups(groups={"course_info"})
     */
    private $creationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="modification_date", type="datetime", nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $modificationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="publication_date", type="datetime", nullable=true)
     * @JMS\Groups(groups={"course_info"})
     */
    private $publicationDate;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="courseInfos", cascade={ "persist" })
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     * @JMS\Type("AppBundle\Entity\Course")
     * @JMS\Groups(groups={"course_info"})
     */
    private $course;

    /**
     * @var \AppBundle\Entity\Structure
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Structure", cascade={ "persist" })
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="structure_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank(groups={"new", "edit"})
     * @JMS\Type("AppBundle\Entity\Structure")
     * @JMS\Groups(groups={"course_info"})
     */
    private $structure;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Campus", inversedBy="courseInfos")
     * @ORM\JoinTable(name="course_info_campus")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Campus>")
     * @JMS\Groups(groups={"course_info"})
     */
    private $campuses;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Language", inversedBy="courseInfos")
     * @ORM\JoinTable(name="course_info_language")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Language>")
     * @JMS\Groups(groups={"course_info"})
     *
     */
    private $languages;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Domain", inversedBy="courseInfos")
     * @ORM\JoinTable(name="course_info_domain")
     * @Assert\NotBlank(groups={"presentation"})
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Domain>")
     * @JMS\Groups(groups={"course_info"})
     */
    private $domains;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Period", inversedBy="courseInfos")
     * @ORM\JoinTable(name="course_info_period")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Period>")
     * @JMS\Groups(groups={"course_info"})
     */
    private $periods;


    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="last_updater", referencedColumnName="id")
     * })
     * @Gedmo\Blameable(on="update")
     * @JMS\Groups(groups={"course_info"})
     */
    private $lastUpdater;

    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="publisher", referencedColumnName="id", nullable=true)
     * })
     * @Gedmo\Blameable(on="create")
     * @JMS\Groups(groups={"course_info"})
     */
    private $publisher;

    /**
     * @var \AppBundle\Entity\Year
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="year_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank(groups={"new"})
     * @JMS\Type("AppBundle\Entity\Year")
     * @JMS\Groups(groups={"course_info"})
     */
    private $year;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CoursePermission", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     */
    private $coursePermissions;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CourseTeacher", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     * @ORM\OrderBy({"lastname" = "ASC"})
     * @JMS\Type("ArrayCollection<AppBundle\Entity\CourseTeacher>")
     * @JMS\Groups(groups={"course_info"})
     */
    private $courseTeachers;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CourseSection", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @Assert\NotBlank(groups={"contentActivities"})
     * @JMS\Type("ArrayCollection<AppBundle\Entity\CourseSection>")
     * @JMS\Groups(groups={"course_info"})
     */
    private $courseSections;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CourseAchievement", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @JMS\Type("ArrayCollection<AppBundle\Entity\CourseAchievement>")
     * @AssertCustom\AchievementConstraintValidator
     * @JMS\Groups(groups={"course_info"})
     */
    private $courseAchievements;

    /**
     * @OneToMany(targetEntity="CourseCriticalAchievement", mappedBy="courseInfo")
     * @Assert\NotBlank(groups={"objectives"})
     * @AssertCustom\AchievementConstraintValidator
     */
    private $courseCriticalAchievements;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CoursePrerequisite", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @Assert\Count(
     *     groups={"objectives"},
     *     min = 1
     *     )
     * @JMS\Type("ArrayCollection<AppBundle\Entity\CoursePrerequisite>")
     * @JMS\Groups(groups={"course_info"})
     */
    private $coursePrerequisites;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CourseTutoringResource", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @JMS\Groups(groups={"course_info"})
     */
    private $courseTutoringResources;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CourseResourceEquipment", mappedBy="courseInfo", cascade={ "persist" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @JMS\Groups(groups={"course_info"})
     */
    private $courseResourceEquipments;

    /**
     * @var string|null
     * @JMS\Groups(groups={"api"})
     */
    private $previousImage = null;

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
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return CourseInfo
     */
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

    /**
     * @param string $title
     * @return CourseInfo
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getEcts()
    {
        return $this->ects;
    }

    /**
     * @param int|null $ects
     * @return CourseInfo
     */
    public function setEcts($ects)
    {
        $this->ects = $ects;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param null|string $level
     * @return CourseInfo
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param int|null $semester
     * @return CourseInfo
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param null|string $summary
     * @return CourseInfo
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return null|string|File
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param null|string|File $image
     * @return CourseInfo
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param null|string $video
     * @return CourseInfo
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTeachingMode()
    {
        return $this->teachingMode;
    }

    /**
     * @param null|string $teachingMode
     * @return CourseInfo
     */
    public function setTeachingMode($teachingMode)
    {
        $this->teachingMode = $teachingMode;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingCmClass()
    {
        return $this->teachingCmClass;
    }

    /**
     * @param float|null $teachingCmClass
     * @return CourseInfo
     */
    public function setTeachingCmClass($teachingCmClass)
    {
        $this->teachingCmClass = $teachingCmClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdClass()
    {
        return $this->teachingTdClass;
    }

    /**
     * @param float|null $teachingTdClass
     * @return CourseInfo
     */
    public function setTeachingTdClass($teachingTdClass)
    {
        $this->teachingTdClass = $teachingTdClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTpClass()
    {
        return $this->teachingTpClass;
    }

    /**
     * @param float|null $teachingTpClass
     * @return CourseInfo
     */
    public function setTeachingTpClass($teachingTpClass)
    {
        $this->teachingTpClass = $teachingTpClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherClass()
    {
        return $this->teachingOtherClass;
    }

    /**
     * @param float|null $teachingOtherClass
     * @return CourseInfo
     */
    public function setTeachingOtherClass($teachingOtherClass)
    {
        $this->teachingOtherClass = $teachingOtherClass;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTeachingOtherTypeClass()
    {
        return $this->teachingOtherTypeClass;
    }

    /**
     * @param null|string $teachingOtherTypeClass
     * @return CourseInfo
     */
    public function setTeachingOtherTypeClass($teachingOtherTypeClass)
    {
        $this->teachingOtherTypeClass = $teachingOtherTypeClass;

        return $this;
    }


    /**
     * @return float|null
     */
    public function getTeachingCmHybridClass()
    {
        return $this->teachingCmHybridClass;
    }

    /**
     * @param float|null $teachingCmHybridClass
     * @return CourseInfo
     */
    public function setTeachingCmHybridClass($teachingCmHybridClass)
    {
        $this->teachingCmHybridClass = $teachingCmHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdHybridClass()
    {
        return $this->teachingTdHybridClass;
    }

    /**
     * @param float|null $teachingTdHybridClass
     * @return CourseInfo
     */
    public function setTeachingTdHybridClass($teachingTdHybridClass)
    {
        $this->teachingTdHybridClass = $teachingTdHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTpHybridClass()
    {
        return $this->teachingTpHybridClass;
    }

    /**
     * @param float|null $teachingTpHybridClass
     * @return CourseInfo
     */
    public function setTeachingTpHybridClass($teachingTpHybridClass)
    {
        $this->teachingTpHybridClass = $teachingTpHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherHybridClass()
    {
        return $this->teachingOtherHybridClass;
    }

    /**
     * @param float|null $teachingOtherHybridClass
     * @return CourseInfo
     */
    public function setTeachingOtherHybridClass($teachingOtherHybridClass)
    {
        $this->teachingOtherHybridClass = $teachingOtherHybridClass;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTeachingOtherTypeHybridClass()
    {
        return $this->teachingOtherTypeHybridClass;
    }

    /**
     * @param null|string $teachingOtherTypeHybridClass
     * @return CourseInfo
     */
    public function setTeachingOtherTypeHybridClass($teachingOtherTypeHybridClass)
    {
        $this->teachingOtherTypeHybridClass = $teachingOtherTypeHybridClass;

        return $this;
    }


    /**
     * @return float|null
     */
    public function getTeachingCmHybridDist()
    {
        return $this->teachingCmHybridDist;
    }

    /**
     * @param float|null $teachingCmHybridDist
     * @return CourseInfo
     */
    public function setTeachingCmHybridDist($teachingCmHybridDist)
    {
        $this->teachingCmHybridDist = $teachingCmHybridDist;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdHybridDist()
    {
        return $this->teachingTdHybridDist;
    }

    /**
     * @param float|null $teachingTdHybridDist
     * @return CourseInfo
     */
    public function setTeachingTdHybridDist($teachingTdHybridDist)
    {
        $this->teachingTdHybridDist = $teachingTdHybridDist;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherHybridDist()
    {
        return $this->teachingOtherHybridDist;
    }

    /**
     * @param float|null $teachingOtherHybridDist
     * @return CourseInfo
     */
    public function setTeachingOtherHybridDist($teachingOtherHybridDist)
    {
        $this->teachingOtherHybridDist = $teachingOtherHybridDist;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTeachingOtherTypeHybridDistant()
    {
        return $this->teachingOtherTypeHybridDistant;
    }

    /**
     * @param null|string $teachingOtherTypeHybridDistant
     * @return CourseInfo
     */
    public function setTeachingOtherTypeHybridDistant($teachingOtherTypeHybridDistant)
    {
        $this->teachingOtherTypeHybridDistant = $teachingOtherTypeHybridDistant;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingCmDist(): ?float
    {
        return $this->teachingCmDist;
    }

    /**
     * @param float|null $teachingCmDist
     * @return CourseInfo
     */
    public function setTeachingCmDist(?float $teachingCmDist): self
    {
        $this->teachingCmDist = $teachingCmDist;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdDist(): ?float
    {
        return $this->teachingTdDist;
    }

    /**
     * @param float|null $teachingTdDist
     * @return CourseInfo
     */
    public function setTeachingTdDist(?float $teachingTdDist): self
    {
        $this->teachingTdDist = $teachingTdDist;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherDist(): ?float
    {
        return $this->teachingOtherDist;
    }

    /**
     * @param float|null $teachingOtherDist
     * @return CourseInfo
     */
    public function setTeachingOtherDist(?float $teachingOtherDist): self
    {
        $this->teachingOtherDist = $teachingOtherDist;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTeachingOtherTypeDist(): ?string
    {
        return $this->teachingOtherTypeDist;
    }

    /**
     * @param null|string $teachingOtherTypeDist
     * @return CourseInfo
     */
    public function setTeachingOtherTypeDist(?string $teachingOtherTypeDist): self
    {
        $this->teachingOtherTypeDist = $teachingOtherTypeDist;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMccWeight()
    {
        return $this->mccWeight;
    }

    /**
     * @param float|null $mccWeight
     * @return CourseInfo
     */
    public function setMccWeight($mccWeight)
    {
        $this->mccWeight = $mccWeight;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMccCompensable(): bool
    {
        return $this->mccCompensable;
    }

    /**
     * @param bool $mccCompensable
     * @return CourseInfo
     */
    public function setMccCompensable(bool $mccCompensable): self
    {
        $this->mccCompensable = $mccCompensable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMccCapitalizable(): bool
    {
        return $this->mccCapitalizable;
    }

    /**
     * @param bool $mccCapitalizable
     * @return CourseInfo
     */
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
     * @param float|null $mccCcCoeffSession1
     * @return CourseInfo
     */
    public function setMccCcCoeffSession1($mccCcCoeffSession1)
    {
        $this->mccCcCoeffSession1 = $mccCcCoeffSession1;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMccCcNbEvalSession1()
    {
        return $this->mccCcNbEvalSession1;
    }

    /**
     * @param int|null $mccCcNbEvalSession1
     * @return CourseInfo
     */
    public function setMccCcNbEvalSession1(?int $mccCcNbEvalSession1)
    {
        $this->mccCcNbEvalSession1 = $mccCcNbEvalSession1;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMccCtCoeffSession1()
    {
        return $this->mccCtCoeffSession1;
    }

    /**
     * @param float|null $mccCtCoeffSession1
     * @return CourseInfo
     */
    public function setMccCtCoeffSession1($mccCtCoeffSession1)
    {
        $this->mccCtCoeffSession1 = $mccCtCoeffSession1;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMccCtNatSession1()
    {
        return $this->mccCtNatSession1;
    }

    /**
     * @param null|string $mccCtNatSession1
     * @return CourseInfo
     */
    public function setMccCtNatSession1(?string $mccCtNatSession1)
    {
        $this->mccCtNatSession1 = $mccCtNatSession1;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMccCtDurationSession1()
    {
        return $this->mccCtDurationSession1;
    }

    /**
     * @param null|string $mccCtDurationSession1
     * @return CourseInfo
     */
    public function setMccCtDurationSession1($mccCtDurationSession1)
    {
        $this->mccCtDurationSession1 = $mccCtDurationSession1;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMccCtCoeffSession2()
    {
        return $this->mccCtCoeffSession2;
    }

    /**
     * @param float|null $mccCtCoeffSession2
     * @return CourseInfo
     */
    public function setMccCtCoeffSession2($mccCtCoeffSession2)
    {
        $this->mccCtCoeffSession2 = $mccCtCoeffSession2;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMccCtNatSession2()
    {
        return $this->mccCtNatSession2;
    }

    /**
     * @param null|string $mccCtNatSession2
     * @return CourseInfo
     */
    public function setMccCtNatSession2($mccCtNatSession2)
    {
        $this->mccCtNatSession2 = $mccCtNatSession2;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMccCtDurationSession2()
    {
        return $this->mccCtDurationSession2;
    }

    /**
     * @param null|string $mccCtDurationSession2
     * @return CourseInfo
     */
    public function setMccCtDurationSession2($mccCtDurationSession2)
    {
        $this->mccCtDurationSession2 = $mccCtDurationSession2;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMccAdvice()
    {
        return $this->mccAdvice;
    }

    /**
     * @param null|string $mccAdvice
     * @return CourseInfo
     */
    public function setMccAdvice($mccAdvice)
    {
        $this->mccAdvice = $mccAdvice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTutoring(): bool
    {
        return $this->tutoring;
    }

    /**
     * @param bool $tutoring
     * @return CourseInfo
     */
    public function setTutoring(bool $tutoring): self
    {
        $this->tutoring = $tutoring;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTutoringTeacher(): bool
    {
        return $this->tutoringTeacher;
    }

    /**
     * @param bool $tutoringTeacher
     * @return CourseInfo
     */
    public function setTutoringTeacher(bool $tutoringTeacher): self
    {
        $this->tutoringTeacher = $tutoringTeacher;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTutoringStudent(): bool
    {
        return $this->tutoringStudent;
    }

    /**
     * @param bool $tutoringStudent
     * @return CourseInfo
     */
    public function setTutoringStudent(bool $tutoringStudent): self
    {
        $this->tutoringStudent = $tutoringStudent;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTutoringDescription()
    {
        return $this->tutoringDescription;
    }

    /**
     * @param null|string $tutoringDescription
     * @return CourseInfo
     */
    public function setTutoringDescription($tutoringDescription)
    {
        $this->tutoringDescription = $tutoringDescription;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEducationalResources()
    {
        return $this->educationalResources;
    }

    /**
     * @param null|string $educationalResources
     * @return CourseInfo
     */
    public function setEducationalResources($educationalResources)
    {
        $this->educationalResources = $educationalResources;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBibliographicResources()
    {
        return $this->bibliographicResources;
    }

    /**
     * @param null|string $bibliographicResources
     * @return CourseInfo
     */
    public function setBibliographicResources($bibliographicResources)
    {
        $this->bibliographicResources = $bibliographicResources;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAgenda()
    {
        return $this->agenda;
    }

    /**
     * @param null|string $agenda
     * @return CourseInfo
     */
    public function setAgenda($agenda)
    {
        $this->agenda = $agenda;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param null|string $organization
     * @return CourseInfo
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClosingRemarks()
    {
        return $this->closingRemarks;
    }

    /**
     * @param null|string $closingRemarks
     * @return CourseInfo
     */
    public function setClosingRemarks($closingRemarks)
    {
        $this->closingRemarks = $closingRemarks;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClosingVideo()
    {
        return $this->closingVideo;
    }

    /**
     * @param null|string $closingVideo
     * @return CourseInfo
     */
    public function setClosingVideo($closingVideo)
    {
        $this->closingVideo = $closingVideo;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime|null $creationDate
     * @return CourseInfo
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * @param \DateTime|null $modificationDate
     * @return CourseInfo
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime|null $publicationDate
     * @return CourseInfo
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * @param null|string $mediaType
     * @return CourseInfo
     */
    public function setMediaType($mediaType)
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
     * @JMS\VirtualProperty()
     * @JMS\Groups(groups={"default", "course_info"})
     * @JMS\SerializedName("course")
     */
    public function getCourseApi()
    {
        return $this->getCourse()->getId();
    }

    /**
    /**
     * @param Course $course
     * @return CourseInfo
     */
    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Structure
     */
    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups(groups={"default", "course_info"})
     * @JMS\SerializedName("structure")
     */
    public function getStructureApi()
    {
        return $this->getStructure()->getId();
    }

    /**
     * @param Structure $structure
     * @return CourseInfo
     */
    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getLastUpdater()
    {
        return $this->lastUpdater;
    }

    /**
     * @param User|null $lastUpdater
     * @return CourseInfo
     */
    public function setLastUpdater(?User $lastUpdater): self
    {
        $this->lastUpdater = $lastUpdater;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param User|null $publisher
     * @return CourseInfo
     */
    public function setPublisher(?User $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Year
     */
    public function getYear(): ?Year
    {
        return $this->year;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups(groups={"default", "course_info"})
     * @JMS\SerializedName("year")
     */
    public function getYearApi()
    {
        return $this->getYear()->getId();
    }

    /**
     * @param Year $year
     * @return CourseInfo
     */
    public function setYear(Year $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCoursePermissions(): ?Collection
    {
        return $this->coursePermissions;
    }

    /**
     * @param Collection $coursePermissions
     * @return CourseInfo
     */
    public function setCoursePermissions(Collection $coursePermissions): self
    {
        $this->coursePermissions = $coursePermissions;

        return $this;
    }

    /**
     * @param CoursePermission $coursePermission
     * @return CourseInfo
     */
    public function addPermission(CoursePermission $coursePermission): self
    {
        if(!$this->coursePermissions->contains($coursePermission))
        {
            $this->coursePermissions->add($coursePermission);
            if($coursePermission->getCourseInfo() !== $this)
            {
                $coursePermission->setCourseInfo($this);
            }
        }

        return $this;
    }

    /**
     * @param CoursePermission $coursePermission
     * @return CourseInfo
     */
    public function removePermission(CoursePermission $coursePermission): self
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

    /**
     * @return Collection
     */
    public function getCourseTeachers(): Collection
    {
        return $this->courseTeachers;
    }

    /**
     * @param Collection $courseTeachers
     * @return CourseInfo
     */
    public function setCourseTeachers(Collection $courseTeachers): self
    {
        $this->courseTeachers = $courseTeachers;

        return $this;
    }

    /**
     * @param CourseTeacher $courseTeacher
     * @return CourseInfo
     */
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

    /**
     * @param CourseTeacher $courseTeacher
     * @return CourseInfo
     */
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

    /**
     * @return Collection
     */
    public function getCourseSections(): Collection
    {
        return $this->courseSections;
    }

    /**
     * @param Collection $courseSections
     * @return CourseInfo
     */
    public function setCourseSections(Collection $courseSections): self
    {
        $this->courseSections = $courseSections;

        return $this;
    }

    /**
     * @param CourseSection $courseSection
     * @return CourseInfo
     */
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

    /**
     * @param CourseSection $courseSection
     * @return CourseInfo
     */
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


    /**
     * @return Collection
     */
    public function getCourseAchievements(): Collection
    {
        return $this->courseAchievements;
    }

    /**
     * @param Collection $courseAchievements
     * @return CourseInfo
     */
    public function setCourseAchievements(Collection $courseAchievements): self
    {
        $this->courseAchievements = $courseAchievements;

        return $this;
    }

    /**
     * @param CourseAchievement $courseAchievement
     * @return CourseInfo
     */
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

    /**
     * @param CourseAchievement $courseAchievement
     * @return CourseInfo
     */
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

    /**
     * @return Collection
     */
    public function getCoursePrerequisites(): Collection
    {
        return $this->coursePrerequisites;
    }

    /**
     * @param Collection $coursePrerequisites
     * @return CourseInfo
     */
    public function setCoursePrerequisites(Collection $coursePrerequisites): self
    {
        $this->coursePrerequisites = $coursePrerequisites;

        return $this;
    }

    /**
     * @param CoursePrerequisite $coursePrerequisite
     * @return CourseInfo
     */
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

    /**
     * @param CoursePrerequisite $coursePrerequisite
     * @return CourseInfo
     */
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

    /**
     * @return Collection
     */
    public function getCourseTutoringResources(): Collection
    {
        return $this->courseTutoringResources;
    }

    /**
     * @param Collection $courseTutoringResources
     * @return CourseInfo
     */
    public function setCourseTutoringResources(Collection $courseTutoringResources): self
    {
        $this->courseTutoringResources = $courseTutoringResources;

        return $this;
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     * @return CourseInfo
     */
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

    /**
     * @param CourseTutoringResource $courseTutoringResource
     * @return CourseInfo
     */
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

    /**
     * @param Collection $courseResourceEquipments
     * @return CourseInfo
     */
    public function setCourseResourceEquipments(Collection $courseResourceEquipments): self
    {
        $this->courseResourceEquipments = $courseResourceEquipments;

        return $this;
    }

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     * @return CourseInfo
     */
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

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     * @return CourseInfo
     */
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

    /**
     * @return null|string
     */
    public function getPreviousImage()
    {
        return $this->previousImage;
    }

    /**
     * @return CourseInfo
     */
    public function setPreviousImage()
    {
        $this->previousImage = $this->getImage();

        return $this;
    }

    /**
     * @param Language $language
     * @return CourseInfo
     */
    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language))
        {
            $this->languages->add($language);
            if (!$language->getCourseInfos()->contains($this))
            {
                $language->getCourseInfos()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Language $language
     * @return CourseInfo
     */
    public function removeLanguage(Language $language): self
    {
        if ($this->languages->contains($language))
        {
            $this->languages->removeElement($language);
            if ($language->getCourseInfos()->contains($this))
            {
                $language->getCourseInfos()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param Campus $campus
     * @return CourseInfo
     */
    public function addCampus(Campus $campus): self
    {
        if (!$this->campuses->contains($campus))
        {
            $this->campuses->add($campus);
            if (!$campus->getCourseInfos()->contains($this))
            {
                $campus->getCourseInfos()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Campus $campus
     * @return CourseInfo
     */
    public function removeCampus(Campus $campus): self
    {
        if ($this->campuses->contains($campus))
        {
            $this->campuses->removeElement($campus);
            if ($campus->getCourseInfos()->contains($this))
            {
                $campus->getCourseInfos()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCampuses()
    {
        return $this->campuses;
    }

    /**
     * @param Domain $domain
     * @return CourseInfo
     */
    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain))
        {
            $this->domains->add($domain);
            if (!$domain->getCourseInfos()->contains($this))
            {
                $domain->getCourseInfos()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Domain $domain
     * @return CourseInfo
     */
    public function removeDomain(Domain $domain): self
    {
        if ($this->domains->contains($domain))
        {
            $this->domains->removeElement($domain);
            if ($domain->getCourseInfos()->contains($this))
            {
                $domain->getCourseInfos()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param Period $period
     * @return CourseInfo
     */
    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period))
        {
            $this->periods->add($period);
            if (!$period->getCourseInfos()->contains($this))
            {
                $period->getCourseInfos()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Period $period
     * @return CourseInfo
     */
    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period))
        {
            $this->periods->removeElement($period);
            if ($period->getCourseInfos()->contains($this))
            {
                $period->getCourseInfos()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPeriods()
    {
        return $this->periods;
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @return CourseInfo
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
     * @return CourseInfo
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
     * @return mixed
     */
    public function getCourseCriticalAchievements()
    {
        return $this->courseCriticalAchievements;
    }

    /**
     * @param $courseCriticalAchievements
     * @return CourseInfo
     */
    public function setCourseCriticalAchievements($courseCriticalAchievements): CourseInfo
    {
        $this->courseCriticalAchievements = $courseCriticalAchievements;
        return $this;
    }

    /**
     *
     */
    public function __clone()
    {

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
                $coursePermission->setId(Uuid::uuid4())
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
                $courseTeacher->setId(Uuid::uuid4())
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
                $courseSection->setId(Uuid::uuid4())
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
                $courseAchievement->setId(Uuid::uuid4())
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
                $coursePrerequisite->setId(Uuid::uuid4())
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
                $courseTutoringResource->setId(Uuid::uuid4())
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
                $courseResourceEquipment->setId(Uuid::uuid4())
                    ->setCourseInfo($this);
                $this->courseResourceEquipments->offsetSet($k, $courseResourceEquipment);
            }
        }
    }

    /**
     * Checks media consistency.
     */
    public function checkMedia()
    {
        $mediaType = $this->getMediaType();

        if (in_array($mediaType, ['image', 'video'])) {

            if ($mediaType == "video") {
                $mediaTypeAlt = "image";
            } else {
                $mediaTypeAlt = "video";
            }

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

        } else {
            if(!empty($this->getImage())){
                $this->setMediaType('image');
            }elseif(!empty($this->getVideo())){
                $this->setMediaType('video');
            }else{
                $this->setMediaType(null);
            }
        }
    }

    public function getCodeYear(bool $dev = null)
    {
        if ($dev) {
            return $this->course->getCode() . '__UNION__' . $this->year->getId();
        }
        return $this->course->getCode() . '-' . $this->year->getId();
    }

    public function setAllRelations()
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
