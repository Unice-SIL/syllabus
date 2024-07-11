<?php

namespace App\Syllabus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseEvaluationCt
 *
 * @ORM\Table(name="bak_course_evaluation_ct")
 * @ORM\Entity
 */
class BakCourseEvaluationCt
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
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
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $position = 0;

    /**
     * @var \App\Syllabus\Entity\BakActivity
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\BakActivity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $activity;

    /**
     * @var \App\Syllabus\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\CourseInfo")
     * @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     *
     */
    private $courseInfo;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return BakCourseEvaluationCt
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
     * @return BakCourseEvaluationCt
     */
    public function setDescription($description): self
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
     * @return BakCourseEvaluationCt
     */
    public function setEvaluationRate($evaluationRate): self
    {
        $this->evaluationRate = $evaluationRate;

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
     * @return BakCourseEvaluationCt
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
     * @return $this
     */
    public function setActivity(BakActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return CourseInfo
     */
    public function getCourseInfo(): CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return $this
     */
    public function setCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}