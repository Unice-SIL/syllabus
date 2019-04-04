<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;

/**
 * Class PublishCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class PublishCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     */
    private $publisher;

    /**
     * @var \DateTime
     */
    private $publicationDate;

    /**
     * EditCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        //$this->publisher = $courseInfo->getPublisher();
        $this->publicationDate = new \DateTime();
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
     * @return PublishCourseInfoCommand
     */
    public function setId(string $id): PublishCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\User
     */
    public function getPublisher(): \AppBundle\Entity\User
    {
        return $this->publisher;
    }

    /**
     * @param \AppBundle\Entity\User $publisher
     * @return PublishCourseInfoCommand
     */
    public function setPublisher(\AppBundle\Entity\User $publisher): PublishCourseInfoCommand
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate(): \DateTime
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime $publicationDate
     * @return PublishCourseInfoCommand
     */
    public function setPublicationDate(\DateTime $publicationDate): PublishCourseInfoCommand
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }


    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        // CourseInfo
        $entity->setPublicationDate($this->getPublicationDate());

        return $entity;
    }

}