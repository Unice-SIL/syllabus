<?php

namespace AppBundle\Command\CourseSection;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseSection;

/**
 * Class CourseSectionCommand
 * @package AppBundle\Command\CourseSection
 */
class CourseSectionCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var null|string
     */
    private $description;

    /**
     * CourseSectionCommand constructor.
     * @param CourseSection $courseSection
     */
    public function __construct(CourseSection $courseSection)
    {
        $this->title = $courseSection->getTitle();
        $this->description = $courseSection->getDescription();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CourseSectionCommand
     */
    public function setTitle(string $title): CourseSectionCommand
    {
        $this->title = $title;

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
     * @return CourseSectionCommand
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function filledEntity($entity)
    {
        // TODO: Implement filledEntity() method.
    }
}