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
     * @var null|string
     */
    private $educationalResources;

    /**
     * @var null|string
     */
    private $bibliographicRessources;

    /**
     * EditEquipmentsCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->educationalResources = $courseInfo->getEducationalResources();
        $this->bibliographicRessources = $courseInfo->getBibliographicResources();
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
    public function getBibliographicRessources()
    {
        return $this->bibliographicRessources;
    }

    /**
     * @param null|string $bibliographicRessources
     * @return EditEquipmentsCourseInfoCommand
     */
    public function setBibliographicRessources($bibliographicRessources)
    {
        $this->bibliographicRessources = $bibliographicRessources;

        return $this;
    }

    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $entity->setEducationalResources($this->getEducationalResources());
        $entity->setBibliographicResources($this->getBibliographicRessources());

        return $entity;
    }


    /**
     *
     */
    public function __clone()
    {
    }
}