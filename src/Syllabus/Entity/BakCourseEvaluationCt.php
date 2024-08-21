<?php

namespace App\Syllabus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * CourseEvaluationCt
 */
#[ORM\Entity]
#[ORM\Table(name: 'bak_course_evaluation_ct')]
class BakCourseEvaluationCt
{
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private $id;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true)]
    private $description;

    /**
     * @var float|null
     */
    #[ORM\Column(name: 'evaluation_rate', type: 'float', nullable: true)]
    private $evaluationRate;

    /**
     * @var int
     */
    #[ORM\Column(name: 'ord', type: 'integer', nullable: false)]
    private $position = 0;

    /**
     * @var BakActivity
     */
    #[ORM\ManyToOne(targetEntity: BakActivity::class)]
    #[ORM\JoinColumn(name: 'activity_id', referencedColumnName: 'id', nullable: false)]
    private $activity;

    /**
     * @var CourseInfo
     *
     *
     */
    #[ORM\ManyToOne(targetEntity: CourseInfo::class)]
    #[ORM\JoinColumn(name: 'course_info_id', referencedColumnName: 'id', nullable: false)]
    private $courseInfo;

    public function getId(): string
    {
        return $this->id;
    }

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
     */
    public function setEvaluationRate($evaluationRate): self
    {
        $this->evaluationRate = $evaluationRate;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getActivity(): BakActivity
    {
        return $this->activity;
    }

    /**
     * @return $this
     */
    public function setActivity(BakActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getCourseInfo(): CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @return $this
     */
    public function setCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}