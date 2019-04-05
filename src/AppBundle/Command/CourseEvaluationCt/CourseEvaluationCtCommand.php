<?php

namespace AppBundle\Command\CourseEvaluationCt;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\Activity;
use AppBundle\Entity\CourseEvaluationCt;
use AppBundle\Entity\CourseInfo;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class CourseEvaluationCtCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var null|string
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var null|float
     *
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     */
    private $evaluationRate;

    /**
     * @var int
     */
    private $order;

    /**
     * @var Activity|null
     */
    private $activity;

    /**
     * @var CourseInfo
     */
    private $courseInfo;


    /**
     * CourseEvaluationCtCommand constructor.
     * @param CourseEvaluationCt $courseEvaluationCt
     */
    public function __construct(CourseEvaluationCt $courseEvaluationCt = null)
    {
        if(is_null($courseEvaluationCt)) {
            $this->id = Uuid::uuid4();
            $this->order = 0;
        }else{
            $this->id = $courseEvaluationCt->getId();
            $this->courseInfo = $courseEvaluationCt->getCourseInfo();
            $this->activity = $courseEvaluationCt->getActivity();
            $this->description = $courseEvaluationCt->getDescription();
            $this->evaluationRate = $courseEvaluationCt->getEvaluationRate();
            $this->order = $courseEvaluationCt->getOrder();
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
     * @return CourseEvaluationCtCommand
     */
    public function setId(string $id): CourseEvaluationCtCommand
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
     * @return CourseEvaluationCtCommand
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
     * @return CourseEvaluationCtCommand
     */
    public function setEvaluationRate($evaluationRate)
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
     * @return CourseEvaluationCtCommand
     */
    public function setOrder(int $order): CourseEvaluationCtCommand
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return CourseEvaluationCtCommand
     */
    public function setActivity($activity)
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
     * @return CourseEvaluationCtCommand
     */
    public function setCourseInfo(CourseInfo $courseInfo): CourseEvaluationCtCommand
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }


    /**
     * @param CourseEvaluationCt $entity
     * @return CourseEvaluationCt
     */
    public function filledEntity($entity): CourseEvaluationCt
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setEvaluationRate($this->getEvaluationRate())
            ->setOrder($this->getOrder());
        if(!is_null($this->getActivity())){
            $entity->setActivity($this->getActivity());
        }
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}