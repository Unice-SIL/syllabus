<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;

/**
 * Class EditEquipmentsCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditEquipmentsCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var ArrayCollection
     */
    private $equipments;

    /**
     * @var null|string
     */
    private $educationalResources;

    /**
     * @var null|string
     */
    private $bibliographicResources;

    /**
     * EditEquipmentsCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->equipments = new ArrayCollection();
            foreach($courseInfo->getCourseResourceEquipment() as $courseEquipment){
                $this->equipment->add(new CourseResourceEquipmentCommand($courseEquipment));
            }
        $this->educationalResources = $courseInfo->getEducationalResources();
        $this->bibliographicResources = $courseInfo->getBibliographicResources();
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
     * @return EditEquipmentsCourseInfoCommand
     */
    public function setId(string $id): EditEquipmentsCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEducationalResources()
    {
        return $this->educationalResources;
    }

    /**
     * @param null|string $educationalResources
     * @return EditEquipmentsCourseInfoCommand
     */
    public function setEducationalResources($educationalResources)
    {
        $this->educationalResources = $educationalResources;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBibliographicResources()
    {
        return $this->bibliographicResources;
    }

    /**
     * @param null|string $bibliographicResources
     * @return EditEquipmentsCourseInfoCommand
     */
    public function setBibliographicResources($bibliographicResources)
    {
        $this->bibliographicResources = $bibliographicResources;

        return $this;
    }

        /**
     * @return ArrayCollection
     */
    public function getEquipments(): ArrayCollection
    {
        return $this->equipments;
    }

    /**
     * @param ArrayCollection $equipments
     * @return EditEquipmentsCourseInfoCommand
     */
    public function setEquipments(ArrayCollection $equipments): EditEquipmentsCourseInfoCommand
    {
        $this->equipments = $equipments;

        return $this;
    }

    /**
     * @param CourseResourceEquipmentCommand $equipment
     * @return EditEquipmentsCourseInfoCommand
     */
    public function addEquipment(CourseResourceEquipmentCommand $equipment): EditEquipmentsCourseInfoCommand
    {
        if(!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
        }
        return $this;
    }


    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $entity->setEducationalResources($this->getEducationalResources());
        $entity->setBibliographicResources($this->getBibliographicResources());

        // Set equipments
        $courseEquipments = new ArrayCollection();
        foreach ($this->equipments as $equipment){
            $id = $equipment->getId();
            $courseEquipment = $entity->getCourseEquipments()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseEquipment){
                $courseEquipment = new CourseEquipment();
            }
            $equipment->setCourseInfo($entity);
            $courseEquipment = $equipment->filledEntity($courseEquipment);
            $courseequipments->add($courseEquipment);
        }
        $entity->setCourseEquipments($courseEquipments);

        return $entity;
    }


    /**
     *
     */
    public function __clone()
    {
        $this->equipments = clone $this->equipments;
        foreach ($this->equipments as $key => $equipment){
            $this->equipments->offsetSet($key, clone $equipment);
        }
    }
}