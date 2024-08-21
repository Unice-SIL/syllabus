<?php

namespace App\Syllabus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;


#[ORM\Entity]
#[ORM\Table(name: 'bak_course_section_activity')]
class BakCourseSectionActivity
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
     * @var bool
     */
    #[ORM\Column(name: 'evaluation_teacher', type: 'boolean', nullable: false)]
    private $evaluationTeacher = false;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'evaluation_peer', type: 'boolean', nullable: false)]
    private $evaluationPeer = false;

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
     * @var CourseSection
     */
    #[ORM\ManyToOne(targetEntity: CourseSection::class, inversedBy: 'courseSectionActivities')]
    #[ORM\JoinColumn(name: 'course_section_id', referencedColumnName: 'id', nullable: false)]
    private $courseSection;

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

    public function isEvaluationTeacher(): bool
    {
        return $this->evaluationTeacher;
    }

    public function setEvaluationTeacher(bool $evaluationTeacher): self
    {
        $this->evaluationTeacher = $evaluationTeacher;

        return $this;
    }

    public function isEvaluationPeer(): bool
    {
        return $this->evaluationPeer;
    }

    public function setEvaluationPeer(bool $evaluationPeer): self
    {
        $this->evaluationPeer = $evaluationPeer;

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

    public function setActivity(BakActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getCourseSection(): CourseSection
    {
        return $this->courseSection;
    }

    public function setCourseSection(CourseSection $courseSection): self
    {
        $this->courseSection = $courseSection;

        return $this;
    }
}