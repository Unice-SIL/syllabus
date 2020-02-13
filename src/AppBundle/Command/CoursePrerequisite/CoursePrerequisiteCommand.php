<?php

namespace AppBundle\Command\CoursePrerequisite;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CoursePrerequisiteCommand
 * @package AppBundle\Command\CoursePrerequisite
 */
class CoursePrerequisiteCommand implements CommandInterface
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
     * @var int
     */
    private $position = 0;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * CoursePrerequisiteCommand constructor.
     * @param CoursePrerequisite|null $coursePrerequisite
     */
    public function __construct(CoursePrerequisite $coursePrerequisite=null)
    {
        if (is_null($coursePrerequisite)) {
            $this->id = Uuid::uuid4();
        }else{
            $this->id = $coursePrerequisite->getId();
            $this->description = $coursePrerequisite->getDescription();
            $this->position = $coursePrerequisite->getPosition();
            $this->courseInfo = $coursePrerequisite->getCourseInfo();
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
     * @return CoursePrerequisiteCommand
     */
    public function setId(string $id): CoursePrerequisiteCommand
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
     * @return CoursePrerequisiteCommand
     */
    public function setDescription($description): CoursePrerequisiteCommand
    {
        $this->description = $description;

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
     * @return CoursePrerequisiteCommand
     */
    public function setPosition(int $position): CoursePrerequisiteCommand
    {
        $this->position = $position;

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
     * @return CoursePrerequisiteCommand
     */
    public function setCourseInfo(CourseInfo $courseInfo): CoursePrerequisiteCommand
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @param CoursePrerequisite $entity
     * @return CoursePrerequisite
     */
    public function filledEntity($entity): CoursePrerequisite
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setPosition($this->getPosition());
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}