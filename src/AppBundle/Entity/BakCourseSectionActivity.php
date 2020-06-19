<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="bak_course_section_activity")
 * @ORM\Entity
 */
class BakCourseSectionActivity
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
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
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $position = 0;

    /**
     * @var \AppBundle\Entity\BakActivity
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BakActivity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $activity;

    /**
     * @var \AppBundle\Entity\CourseSection
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
     * @return BakCourseSectionActivity
     */
    public function setId(string $id): self
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
     * @param $description
     * @return $this
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
     * @param $evaluationRate
     * @return $this
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
     * @return BakCourseSectionActivity
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
     * @return BakCourseSectionActivity
     */
    public function setEvaluationPeer(bool $evaluationPeer): self
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
     * @return BakCourseSectionActivity
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }


    /**
     * @return BakActivity
     */
    public function getActivity(): BakActivity
    {
        return $this->activity;
    }

    /**
     * @param BakActivity $activity
     * @return BakCourseSectionActivity
     */
    public function setActivity(BakActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return CourseSection
     */
    public function getCourseSection(): CourseSection
    {
        return $this->courseSection;
    }

    /**
     * @param CourseSection $courseSection
     * @return BakCourseSectionActivity
     */
    public function setCourseSection(CourseSection $courseSection): self
    {
        $this->courseSection = $courseSection;

        return $this;
    }
}