<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;

/**
 * Class EditMccCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditMccCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var null|string
     */
    private $mccAdvice;

    /**
     * EditMccCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->mccAdvice = $courseInfo->getMccAdvice();


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
    public function getMccAdvice()
    {
        return $this->mccAdvice;
    }

    /**
     * @param null|string $mccAdvice
     * @return EditInfosCourseInfoCommand
     */
    public function setMccAdvice($mccAdvice)
    {
        $this->mccAdvice = $mccAdvice;

        return $this;
    }


    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $entity->setMccAdvice($this->getMccAdvice());

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
    }
}