<?php

namespace AppBundle\Entity;

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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="level", type="string", length=4, nullable=true, options={"fixed"=true})
     */
    private $level;

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
     */
    private $teachingOtherClass;

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
    private $mccCapitalizable = '0';

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
    private $tutoring = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring_teacher", type="boolean", nullable=false)
     */
    private $tutoringTeacher = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="tutoring_student", type="boolean", nullable=false)
     */
    private $tutoringStudent = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="tutoring_description", type="string", length=255, nullable=true)
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
     * @var \AppBundle\Entity\Course
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     * })
     */
    private $course;

    /**
     * @var \AppBundle\Entity\Structure
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="structure_id", referencedColumnName="id")
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
     *   @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     * })
     */
    private $year;


}
