<?php

namespace AppBundle\Entity;

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
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $order = 0;

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
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo")
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
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return BakCourseEvaluationCt
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

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
     * @param Activity $activity
     * @return CourseEvaluationCt
     */
    public function setActivity(Activity $activity): self
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
     * @return CourseEvaluationCt
     */
    public function setCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}