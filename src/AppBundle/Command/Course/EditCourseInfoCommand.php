<?php

namespace AppBundle\Command\Course;

use AppBundle\Entity\CourseInfo;

/**
 * Class EditCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditCourseInfoCommand
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var null|string
     */
    private $summary;

    /**
     * EditCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->summary = $courseInfo->getSummary();
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
     * @return EditCourseInfoCommand
     */
    public function setId(string $id): EditCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param null|string $summary
     * @return EditCourseInfoCommand
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }



}