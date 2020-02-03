<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CourseSectionActivity
 *
 * @ORM\Table(name="course_section_activity")
 * @ORM\Entity
 */
class CourseSectionActivity
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var float|null
     *
     * @ORM\Column(name="evaluation_rate", type="float", nullable=true)
     */
    private $evaluationRate;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluable", type="boolean", nullable=false)
     */
    private $evaluable = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation_ct", type="boolean", nullable=false)
     */
    private $evaluationCt = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation_teacher", type="boolean", nullable=false)
     */
    private $evaluationTeacher = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation_peer", type="boolean", nullable=false)
     */
    private $evaluationPeer = false;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position = 0;

    /**
     * @var \AppBundle\Entity\Activity
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Activity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $activity;

    /**
     * @var ActivityType|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ActivityType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_type_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private $activityType;

    /**
     * @var \AppBundle\Entity\ActivityMode|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ActivityMode")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_mode_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private $activityMode;

    /**
     * @var \AppBundle\Entity\CourseSection|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseSection", inversedBy="courseSectionActivities",)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_section_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $courseSection;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseSectionActivity
     */
    public function setId(string $id): CourseSectionActivity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return CourseSectionActivity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getEvaluationRate()
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
    public function setEvaluable(bool $evaluable): CourseSectionActivity
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
    public function setEvaluationCt(bool $evaluationCt): CourseSectionActivity
    {
        $this->evaluationCt = $evaluationCt;
        return $this;
    }

    /**
     * @param float|null $evaluationRate
     * @return CourseSectionActivity
     */
    public function setEvaluationRate($evaluationRate)
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
    public function setEvaluationTeacher(bool $evaluationTeacher): CourseSectionActivity
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
    public function setEvaluationPeer(bool $evaluationPeer): CourseSectionActivity
    {
        $this->evaluationPeer = $evaluationPeer;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return CourseSectionActivity
     */
    public function setPosition(int $position): CourseSectionActivity
    {
        $this->position = $position;

        return $this;
    }


    /**
     * @return Activity
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity $activity
     * @return CourseSectionActivity
     */
    public function setActivity(Activity $activity): CourseSectionActivity
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
    public function setCourseSection(?CourseSection $courseSection): CourseSectionActivity
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
    public function setActivityType(?ActivityType $activityType): CourseSectionActivity
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
    public function setActivityMode(?ActivityMode $activityMode): CourseSectionActivity
    {
        $this->activityMode = $activityMode;
        return $this;
    }
}
