<?php

namespace AppBundle\Command\CourseSectionActivity;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\Activity;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseSectionActivity;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CourseSectionActivityCommand
 * @package AppBundle\Command\CourseSection
 */
class CourseSectionActivityCommand implements CommandInterface
{
    /**
     * @var string
     */

    private $id;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var null|float
     */
    private $evaluationRate;

    /**
     * @var bool
     *
     * //@Assert\Expression(
     * //    "not ( this.getActivity().getType() == 'evaluation' and this.isEvaluationTeacher() == false and this.isEvaluationPeer() == false)",
     * //)
     */
    private $evaluationTeacher;

    /**
     * @var bool
     *
     * //@Assert\Expression(
     * //    "not ( this.getActivity().getType() == 'evaluation' and this.isEvaluationTeacher() == false and this.isEvaluationPeer() == false)"
     * //)
     */
    private $evaluationPeer;

    /**
     * @var int
     */
    private $position;

    /**
     * @var CourseSection|null
     */
    private $courseSection;

    /**
     * @var Activity|null
     */
    private $activity;

    /**
     * CourseSectionActivityCommand constructor.
     * @param CourseSectionActivity|null $courseSectionActivity
     */
    public function __construct(CourseSectionActivity $courseSectionActivity = null)
    {
        if(is_null($courseSectionActivity)) {
            $this->id = Uuid::uuid4();
            $this->evaluationTeacher = false;
            $this->evaluationPeer = false;
            $this->position = 0;
        }else{
            $this->id = $courseSectionActivity->getId();
            $this->courseSection = $courseSectionActivity->getCourseSection();
            $this->activity = $courseSectionActivity->getActivity();
            $this->description = $courseSectionActivity->getDescription();
            $this->evaluationRate = $courseSectionActivity->getEvaluationRate();
            $this->evaluationTeacher = $courseSectionActivity->isEvaluationTeacher();
            $this->evaluationPeer = $courseSectionActivity->isEvaluationPeer();
            $this->position = $courseSectionActivity->getPosition();
        }
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
     * @return CourseSectionActivityCommand
     */
    public function setId(string $id): CourseSectionActivityCommand
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
     * @return CourseSectionActivityCommand
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
     * @param float|null $evaluationRate
     * @return CourseSectionActivityCommand
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
     * @return CourseSectionActivityCommand
     */
    public function setEvaluationTeacher(bool $evaluationTeacher): CourseSectionActivityCommand
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
     * @return CourseSectionActivityCommand
     */
    public function setEvaluationPeer(bool $evaluationPeer): CourseSectionActivityCommand
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
     * @return CourseSectionActivityCommand
     */
    public function setPosition(int $position): CourseSectionActivityCommand
    {
        $this->position = $position;

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
     * @param CourseSection $courseSection
     * @return CourseSectionActivityCommand
     */
    public function setCourseSection(CourseSection $courseSection): CourseSectionActivityCommand
    {
        $this->courseSection = $courseSection;

        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity $activity
     * @return CourseSectionActivityCommand
     */
    public function setActivity(Activity $activity): CourseSectionActivityCommand
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @param CourseSectionActivity $entity
     * @return CourseSectionActivity
     */
    public function filledEntity($entity): CourseSectionActivity
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setEvaluationRate($this->getEvaluationRate())
            ->setEvaluationTeacher($this->isEvaluationTeacher())
            ->setEvaluationPeer($this->isEvaluationPeer())
            ->setPosition($this->getPosition());
        if(!is_null($this->getActivity())){
            $entity->setActivity($this->getActivity());
        }
        if(!is_null($this->getCourseSection())){
            $entity->setCourseSection($this->getCourseSection());
        }
        return $entity;
    }
}