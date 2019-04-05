<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CourseInfo
 *
 * @ORM\Table(name="course_info", indexes={@ORM\Index(name="fk_course_info_user2_idx", columns={"publisher"}), @ORM\Index(name="fk_course_info_course1_idx", columns={"course_id"}), @ORM\Index(name="fk_course_info_structure1_idx", columns={"structure_id"}), @ORM\Index(name="fk_course_info_user1_idx", columns={"last_updater"}), @ORM\Index(name="fk_course_info_year1_idx", columns={"year_id"})})
 * @ORM\Entity
 */
class CourseInfo
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=false)
     */
    private $title;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ects", type="integer", nullable=true)
     */
    private $ects;

    /**
     * @var string|null
     *
     * @ORM\Column(name="level", type="string", length=15, nullable=true, options={"fixed"=true})
     *
     */
    private $level;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain", type="string", length=100, nullable=true, options={"fixed"=true})
     *
     */
    private $domain;

    /**
     * @var int|null
     *
     * @ORM\Column(name="semester", type="integer", nullable=true)
     */
    private $semester;

    /**
     * @var string|null
     *
     * @ORM\Column(name="summary", type="text", length=65535, nullable=true)
     */
    private $summary;

    /**
     * @var string|null
     *
     * @ORM\Column(name="period", type="string", length=255, nullable=true)
     */
    private $period;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="text", length=65535, nullable=true)
     */
    private $video;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_mode", type="string", length=15, nullable=true, options={"fixed"=true})
     *
     */
    private $teachingMode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingCmClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingTdClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_tp_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingTpClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_class", type="float", precision=10, scale=0, nullable=true)
     *
     */
    private $teachingOtherClass;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_class", type="string", length=65, nullable=true)
     *
     */
    private $teachingOtherTypeClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingCmHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingTdHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_tp_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingTpHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_hybrid_class", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingOtherHybridClass;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_hybrid_class", type="string", length=65, nullable=true)
     */
    private $teachingOtherTypeHybridClass;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_cm_hybrid_dist", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingCmHybridDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_td_hybrid_dist", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingTdHybridDist;

    /**
     * @var float|null
     *
     * @ORM\Column(name="teaching_other_hybrid_dist", type="float", precision=10, scale=0, nullable=true)
     */
    private $teachingOtherHybridDist;

    /**
     * @var string|null
     *
     * @ORM\Column(name="teaching_other_type_hybrid_distant", type="string", length=65, nullable=true)
     */
    private $teachingOtherTypeHybridDistant;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_weight", type="float", precision=10, scale=0, nullable=true)
     */
    private $mccWeight;

    /**
     * @var bool
     *
     * @ORM\Column(name="mcc_capitalizable", type="boolean", nullable=false)
     */
    private $mccCapitalizable = false;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_cc_coeff_session_1", type="float", precision=10, scale=0, nullable=true)
     */
    private $mccCcCoeffSession1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="mcc_cc_nb_eval_session_1", type="integer", nullable=true)
     */
    private $mccCcNbEvalSession1;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_ct_coeff_session_1", type="float", precision=10, scale=0, nullable=true)
     */
    private $mccCtCoeffSession1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_nat_session_1", type="string", length=100, nullable=true)
     */
    private $mccCtNatSession1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_duration_session_1", type="string", length=100, nullable=true)
     */
    private $mccCtDurationSession1;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mcc_ct_coeff_session_2", type="float", precision=10, scale=0, nullable=true)
     */
    private $mccCtCoeffSession2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_nat_session_2", type="string", length=100, nullable=true)
     */
    private $mccCtNatSession2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_ct_duration_session_2", type="string", length=100, nullable=true)
     */
    private $mccCtDurationSession2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mcc_advice", type="text", length=65535, nullable=true)
     */
    private $mccAdvice;

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring", type="boolean", nullable=false)
     */
    private $tutoring = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring_teacher", type="boolean", nullable=false)
     */
    private $tutoringTeacher = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring_student", type="boolean", nullable=false)
     */
    private $tutoringStudent = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tutoring_description", type="text", length=65535, nullable=true)
     */
    private $tutoringDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="educational_resources", type="text", length=65535, nullable=true)
     */
    private $educationalResources;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bibliographic_resources", type="text", length=65535, nullable=true)
     */
    private $bibliographicResources;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agenda", type="text", length=65535, nullable=true)
     */
    private $agenda;

    /**
     * @var string|null
     *
     * @ORM\Column(name="organization", type="text", length=65535, nullable=true)
     */
    private $organization;

    /**
     * @var string|null
     *
     * @ORM\Column(name="closing_remarks", type="text", length=65535, nullable=true)
     */
    private $closingRemarks;

    /**
     * @var string|null
     *
     * @ORM\Column(name="closing_video", type="text", length=65535, nullable=true)
     */
    private $closingVideo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="modification_date", type="datetime", nullable=true)
     */
    private $modificationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="publication_date", type="datetime", nullable=true)
     */
    private $publicationDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="media_type", type="string", length=10, nullable=true)
     */
    private $mediaType;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_presentation_tab_valid", type="boolean", nullable=false)
     */
    private $temPresentationTabValid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_activities_tab_valid", type="boolean", nullable=false)
     */
    private $temActivitiesTabValid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_objectives_tab_valid", type="boolean", nullable=false)
     */
    private $temObjectivesTabValid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_mcc_tab_valid", type="boolean", nullable=false)
     */
    private $temMccTabValid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_equipments_tab_valid", type="boolean", nullable=false)
     */
    private $temEquipmentsTabValid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_infos_tab_valid", type="boolean", nullable=false)
     */
    private $temInfosTabValid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tem_closing_remarks_tab_valid", type="boolean", nullable=false)
     */
    private $temClosingRemarksTabValid = false;

    /**
     * @var \AppBundle\Entity\Course
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course", inversedBy="courseInfos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $course;

    /**
     * @var \AppBundle\Entity\Structure
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="structure_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $structure;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="last_updater", referencedColumnName="id")
     * })
     */
    private $lastUpdater;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="publisher", referencedColumnName="id")
     * })
     */
    private $publisher;

    /**
     * @var \AppBundle\Entity\Year
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="year_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $year;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseTeacher", mappedBy="courseInfo", cascade={ "persist" })
     * @ORM\OrderBy({"lastname" = "ASC"})
     */
    private $courseTeachers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseSection", mappedBy="courseInfo", cascade={ "persist" })
     * @ORM\OrderBy({"order" = "ASC", "title" = "ASC"})
     */
    private $courseSections;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseEvaluationCt", mappedBy="courseInfo", cascade={ "persist" })
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $courseEvaluationCts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseAchievement", mappedBy="courseInfo", cascade={ "persist" })
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $courseAchievements;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoursePrerequisite", mappedBy="courseInfo", cascade={ "persist" })
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $coursePrerequisites;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseTutoringResource", mappedBy="courseInfo", cascade={ "persist" })
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $courseTutoringResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseResourceEquipment", mappedBy="courseInfo", cascade={ "persist" })
     */
    private $courseResourceEquipments;

    /**
     * CourseInfo constructor.
     */
    public function __construct()
    {
        $this->courseTeachers = new ArrayCollection();
        $this->courseSections = new ArrayCollection();
        $this->courseEvaluationCts = new ArrayCollection();
        $this->courseAchievements = new ArrayCollection();
        $this->coursePrerequisites = new ArrayCollection();
        $this->courseTutoringResources = new ArrayCollection();
        $this->courseResourceEquipments = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseInfo
     */
    public function setId(string $id): CourseInfo
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CourseInfo
     */
    public function setTitle(string $title): CourseInfo
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
     * @return null|string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param null|string $domain
     * @return CourseInfo
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

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
     * @return null|string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param null|string $period
     * @return CourseInfo
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param null|string $image
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
    public function isMccCapitalizable(): bool
    {
        return $this->mccCapitalizable;
    }

    /**
     * @param bool $mccCapitalizable
     * @return CourseInfo
     */
    public function setMccCapitalizable(bool $mccCapitalizable): CourseInfo
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
    public function setMccCcNbEvalSession1($mccCcNbEvalSession1)
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
    public function setMccCtNatSession1($mccCtNatSession1)
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
    public function setTutoring(bool $tutoring): CourseInfo
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
    public function setTutoringTeacher(bool $tutoringTeacher): CourseInfo
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
    public function setTutoringStudent(bool $tutoringStudent): CourseInfo
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
     * @return bool
     */
    public function isTemPresentationTabValid(): bool
    {
        return $this->temPresentationTabValid;
    }

    /**
     * @param bool $temPresentationTabValid
     * @return CourseInfo
     */
    public function setTemPresentationTabValid(bool $temPresentationTabValid): CourseInfo
    {
        $this->temPresentationTabValid = $temPresentationTabValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemActivitiesTabValid(): bool
    {
        return $this->temActivitiesTabValid;
    }

    /**
     * @param bool $temActivitiesTabValid
     * @return CourseInfo
     */
    public function setTemActivitiesTabValid(bool $temActivitiesTabValid): CourseInfo
    {
        $this->temActivitiesTabValid = $temActivitiesTabValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemObjectivesTabValid(): bool
    {
        return $this->temObjectivesTabValid;
    }

    /**
     * @param bool $temObjectivesTabValid
     * @return CourseInfo
     */
    public function setTemObjectivesTabValid(bool $temObjectivesTabValid): CourseInfo
    {
        $this->temObjectivesTabValid = $temObjectivesTabValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemMccTabValid(): bool
    {
        return $this->temMccTabValid;
    }

    /**
     * @param bool $temMccTabValid
     * @return CourseInfo
     */
    public function setTemMccTabValid(bool $temMccTabValid): CourseInfo
    {
        $this->temMccTabValid = $temMccTabValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemEquipmentsTabValid(): bool
    {
        return $this->temEquipmentsTabValid;
    }

    /**
     * @param bool $temEquipmentsTabValid
     * @return CourseInfo
     */
    public function setTemEquipmentsTabValid(bool $temEquipmentsTabValid): CourseInfo
    {
        $this->temEquipmentsTabValid = $temEquipmentsTabValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemInfosTabValid(): bool
    {
        return $this->temInfosTabValid;
    }

    /**
     * @param bool $temInfosTabValid
     * @return CourseInfo
     */
    public function setTemInfosTabValid(bool $temInfosTabValid): CourseInfo
    {
        $this->temInfosTabValid = $temInfosTabValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemClosingRemarksTabValid(): bool
    {
        return $this->temClosingRemarksTabValid;
    }

    /**
     * @param bool $temClosingRemarksTabValid
     * @return CourseInfo
     */
    public function setTemClosingRemarksTabValid(bool $temClosingRemarksTabValid): CourseInfo
    {
        $this->temClosingRemarksTabValid = $temClosingRemarksTabValid;

        return $this;
    }

    /**
     * @return Course
     */
    public function getCourse(): Course
    {
        return $this->course;
    }

    /**
     * @param Course $course
     * @return CourseInfo
     */
    public function setCourse(Course $course): CourseInfo
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Structure
     */
    public function getStructure(): Structure
    {
        return $this->structure;
    }

    /**
     * @param Structure $structure
     * @return CourseInfo
     */
    public function setStructure(Structure $structure): CourseInfo
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * @return User
     */
    public function getLastUpdater(): User
    {
        return $this->lastUpdater;
    }

    /**
     * @param User $lastUpdater
     * @return CourseInfo
     */
    public function setLastUpdater(User $lastUpdater): CourseInfo
    {
        $this->lastUpdater = $lastUpdater;

        return $this;
    }

    /**
     * @return User
     */
    public function getPublisher(): User
    {
        return $this->publisher;
    }

    /**
     * @param User $publisher
     * @return CourseInfo
     */
    public function setPublisher(User $publisher): CourseInfo
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Year
     */
    public function getYear(): Year
    {
        return $this->year;
    }

    /**
     * @param Year $year
     * @return CourseInfo
     */
    public function setYear(Year $year): CourseInfo
    {
        $this->year = $year;

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
    public function setCourseTeachers(Collection $courseTeachers): CourseInfo
    {
        $this->courseTeachers = $courseTeachers;

        return $this;
    }

    /**
     * @param CourseTeacher $courseTeacher
     * @return CourseInfo
     */
    public function addCourseTeacher(CourseTeacher $courseTeacher): CourseInfo
    {
        $this->courseTeachers->add($courseTeacher);

        return $this;
    }

    /**
     * @param CourseTeacher $courseTeacher
     * @return CourseInfo
     */
    public function removeCourseTeacher(CourseTeacher $courseTeacher): CourseInfo
    {
        $this->courseTeachers->removeElement($courseTeacher);

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
    public function setCourseSections(Collection $courseSections): CourseInfo
    {
        $this->courseSections = $courseSections;

        return $this;
    }

    /**
     * @param CourseSection $courseSection
     * @return CourseInfo
     */
    public function addCourseSection(CourseSection $courseSection): CourseInfo
    {
        $this->courseSections->add($courseSection);

        return $this;
    }

    /**
     * @param CourseSection $courseSection
     * @return CourseInfo
     */
    public function removeCourseSection(CourseSection $courseSection): CourseInfo
    {
        $this->courseSections->removeElement($courseSection);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseEvaluationCts(): Collection
    {
        return $this->courseEvaluationCts;
    }

    /**
     * @param Collection $courseEvaluationCts
     * @return CourseInfo
     */
    public function setCourseEvaluationCts(Collection $courseEvaluationCts): CourseInfo
    {
        $this->courseEvaluationCts = $courseEvaluationCts;

        return $this;
    }

    /**
     * @param CourseEvaluationCt $courseEvaluationCt
     * @return CourseInfo
     */
    public function addCourseEvaluationCt(CourseEvaluationCt $courseEvaluationCt): CourseInfo
    {
        $this->courseEvaluationCts->add($courseEvaluationCt);

        return $this;
    }

    /**
     * @param CourseSection $courseEvaluationCt
     * @return CourseInfo
     */
    public function removeCourseEvaluationCt(CourseSection $courseEvaluationCt): CourseInfo
    {
        $this->courseEvaluationCts->removeElement($courseEvaluationCt);

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
    public function setCourseAchievements(Collection $courseAchievements): CourseInfo
    {
        $this->courseAchievements = $courseAchievements;

        return $this;
    }

    /**
     * @param CourseAchievement $courseAchievement
     * @return CourseInfo
     */
    public function addCourseAchievement(CourseAchievement $courseAchievement): CourseInfo
    {
        $this->courseAchievements->add($courseAchievement);

        return $this;
    }

    /**
     * @param CourseAchievement $courseAchievement
     * @return CourseInfo
     */
    public function removeCourseAchievement(CourseAchievement $courseAchievement): CourseInfo
    {
        $this->courseAchievements->removeElement($courseAchievement);

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
    public function setCoursePrerequisites(Collection $coursePrerequisites): CourseInfo
    {
        $this->coursePrerequisites = $coursePrerequisites;

        return $this;
    }

    /**
     * @param CoursePrerequisite $coursePrerequisite
     * @return CourseInfo
     */
    public function addCoursePrerequisite(CoursePrerequisite $coursePrerequisite): CourseInfo
    {
        $this->coursePrerequisites->add($coursePrerequisite);

        return $this;
    }

    /**
     * @param CoursePrerequisite $coursePrerequisite
     * @return CourseInfo
     */
    public function removeCoursePrerequisite(CoursePrerequisite $coursePrerequisite): CourseInfo
    {
        $this->coursePrerequisites->removeElement($coursePrerequisite);

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
    public function setCourseTutoringResources(Collection $courseTutoringResources): CourseInfo
    {
        $this->courseTutoringResources = $courseTutoringResources;

        return $this;
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     * @return CourseInfo
     */
    public function addCourseTutoringResource(CourseTutoringResource $courseTutoringResource): CourseInfo
    {
        $this->courseTutoringResources->add($courseTutoringResource);

        return $this;
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     * @return CourseInfo
     */
    public function removeCourseTutoringResource(CourseTutoringResource $courseTutoringResource): CourseInfo
    {
        $this->courseTutoringResources->removeElement($courseTutoringResource);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseResourceEquipments(): Collection
    {
        return $this->courseResourceEquipments;
    }

    /**
     * @param Collection $courseResourceEquipments
     * @return CourseInfo
     */
    public function setCourseResourceEquipments(Collection $courseResourceEquipments): CourseInfo
    {
        $this->courseResourceEquipments = $courseResourceEquipments;

        return $this;
    }

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     * @return CourseInfo
     */
    public function addCourseResourceEquipment(CourseResourceEquipment $courseResourceEquipment): CourseInfo
    {
        $this->courseResourceEquipments->add($courseResourceEquipment);

        return $this;
    }

    /**
     * @param CourseResourceEquipment $courseResourceEquipment
     * @return CourseInfo
     */
    public function removeCourseResourceEquipment(CourseResourceEquipment $courseResourceEquipment): CourseInfo
    {
        $this->courseResourceEquipments->removeElement($courseResourceEquipment);

        return $this;

    }
}
