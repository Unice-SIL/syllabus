<?php

namespace AppBundle\Command\CourseSection;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseSection;
use AppBundle\Form\CourseSection\CourseSectionType;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseSectionCommand
 * @package AppBundle\Command\CourseSection
 */
class CourseSectionCommand implements CommandInterface
{
    /**
     * @var string
     */

    private $id;
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $type;

    /**
     * @var null|string
     */
    private $description;

    /**
     * CourseSectionCommand constructor.
     * @param CourseSection|null $courseSection
     */
    public function __construct(CourseSection $courseSection = null)
    {
        if(is_null($courseSection)) {
            $this->id = Uuid::uuid4();
        }else{
            $this->title = $courseSection->getTitle();
            $this->type = $courseSection->getSectionType()->getId();
            $this->description = $courseSection->getDescription();
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
     * @return CourseSectionCommand
     */
    public function setId(string $id): CourseSectionCommand
    {
        $this->id = $id;

        return $this;
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return CourseSectionCommand
     */
    public function setType(string $type): CourseSectionCommand
    {
        $this->type = $type;

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