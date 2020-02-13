<?php

namespace AppBundle\Command\CourseResourceEquipment;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Equipment;
use AppBundle\Entity\CourseResourceEquipment;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseResourceEquipmentCommand
 * @package AppBundle\Command\CourseResourceEquipment
 */
class CourseResourceEquipmentCommand implements CommandInterface
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
    private $position;

    /**
     * @var CourseInfo|null
     */
    private $courseInfo;

    /**
     * @var Equipment|null
     */
    private $equipment;

    /**
     * CourseResourceEquipmentCommand constructor.
     * @param CourseResourceEquipment|null $courseResourceEquipment
     */
    public function __construct(CourseResourceEquipment $courseResourceEquipment = null)
    {
        if(is_null($courseResourceEquipment)) {
            $this->id = Uuid::uuid4();
            $this->position = 0;
        }else{
            $this->id = $courseResourceEquipment->getId();
            $this->courseInfo = $courseResourceEquipment->getCourseInfo();
            $this->equipment = $courseResourceEquipment->getEquipment();
            $this->description = $courseResourceEquipment->getDescription();
            $this->position = $courseResourceEquipment->getPosition();
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
     * @return CourseResourceEquipmentCommand
     */
    public function setId(string $id): CourseResourceEquipmentCommand
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
     * @return CourseResourceEquipmentCommand
     */
    public function setDescription($description)
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
     * @return CourseResourceEquipmentCommand
     */
    public function setPosition(int $position): CourseResourceEquipmentCommand
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return CourseInfo|null
     */
    public function getCourseInfo()
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo|null $courseInfo
     * @return CourseResourceEquipmentCommand
     */
    public function setCourseInfo($courseInfo)
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return Equipment|null
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @param Equipment|null $equipment
     * @return CourseResourceEquipmentCommand
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * @param CourseResourceEquipment $entity
     * @return CourseResourceEquipment
     */
    public function filledEntity($entity): CourseResourceEquipment
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setPosition($this->getPosition());
        if(!is_null($this->getEquipment())){
            $entity->setEquipment($this->getEquipment());
        }
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}