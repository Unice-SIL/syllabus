<?php

namespace AppBundle\Command\CourseTutoringResource;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTutoringResource;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseTutoringResourceCommand
 * @package AppBundle\Command\CoursePrerequisite
 */
class CourseTutoringResourceCommand implements CommandInterface
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
     * @var int
     */
    private $order = 0;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * CourseTutoringResourceCommand constructor.
     * @param CourseTutoringResource|null $courseTutoringResource
     */
    public function __construct(CourseTutoringResource $courseTutoringResource=null)
    {
        if (is_null($courseTutoringResource)) {
            $this->id = Uuid::uuid4();
        }else{
            $this->id = $courseTutoringResource->getId();
            $this->description = $courseTutoringResource->getDescription();
            $this->order = $courseTutoringResource->getOrder();
            $this->courseInfo = $courseTutoringResource->getCourseInfo();
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
     * @return CourseTutoringResourceCommand
     */
    public function setId(string $id): CourseTutoringResourceCommand
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
     * @return CourseTutoringResourceCommand
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @return CourseTutoringResourceCommand
     */
    public function setOrder(int $order): CourseTutoringResourceCommand
    {
        $this->order = $order;

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
     * @return CourseTutoringResourceCommand
     */
    public function setCourseInfo(CourseInfo $courseInfo): CourseTutoringResourceCommand
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }


    /**
     * @param CourseTutoringResource $entity
     * @return CourseTutoringResource
     */
    public function filledEntity($entity): CourseTutoringResource
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setOrder($this->getOrder());
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}