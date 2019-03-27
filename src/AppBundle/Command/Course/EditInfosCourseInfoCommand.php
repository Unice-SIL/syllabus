<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;

/**
 * Class EditInfosCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditInfosCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var null|string
     */
    private $agenda;

    /**
     * @var null|string
     */
    private $organization;

    /**
     * EditClosingRemarksCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->agenda = $courseInfo->getAgenda();
        $this->organization = $courseInfo->getOrganization();

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
     * @return EditInfosCourseInfoCommand
     */
    public function setId(string $id): EditInfosCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAgenda()
    {
        return $this->agenda;
    }

    /**
     * @param null|string $agenda
     * @return EditInfosCourseInfoCommand
     */
    public function setAgenda($agenda)
    {
        $this->agenda = $agenda;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param null|string $organization
     * @return EditInfosCourseInfoCommand
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }


    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $entity->setAgenda($this->getAgenda())
            ->setOrganization($this->getOrganization());

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
    }
}