<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseResourceEquipment\CourseResourceEquipmentCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseResourceEquipment;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var null|string
     */
    private $educationalResources;

    /**
     * @var null|string
     */
    private $bibliographicResources;

    /**
     * @var ArrayCollection
     */
    private $equipments;

    /**
     * EditEquipmentsCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->educationalResources = $courseInfo->getEducationalResources();
        $this->bibliographicResources = $courseInfo->getBibliographicResources();
        $this->equipments = new ArrayCollection();
            foreach($courseInfo->getCourseResourceEquipments() as $courseEquipment){
                $this->equipments->add(new CourseResourceEquipmentCommand($courseEquipment));
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
            $courseEquipment = $entity->getCourseResourceEquipments()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseEquipment){
                $courseEquipment = new CourseResourceEquipment();
            }
            $equipment->setCourseInfo($entity);
            $courseEquipment = $equipment->filledEntity($courseEquipment);
            $courseEquipments->add($courseEquipment);
        }
        $entity->setCourseResourceEquipments($courseEquipments);

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