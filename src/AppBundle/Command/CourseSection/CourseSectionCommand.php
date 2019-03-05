<?php

namespace AppBundle\Command\CourseSection;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\SectionType;
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
     * @var SectionType
     */
    private $type;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var int
     */
    private $order;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * CourseSectionCommand constructor.
     * @param CourseSection|null $courseSection
     */
    public function __construct(CourseSection $courseSection = null)
    {
        if(is_null($courseSection)) {
            $this->id = Uuid::uuid4();
        }else{
            $this->id = $courseSection->getId();
            $this->courseInfo = $courseSection->getCourseInfo();
            $this->title = $courseSection->getTitle();
            $this->type = $courseSection->getSectionType();
            $this->description = $courseSection->getDescription();
            $this->order = $courseSection->getOrder();
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
     * @return SectionType
     */
    public function getType(): SectionType
    {
        return $this->type;
    }

    /**
     * @param SectionType $type
     * @return CourseSectionCommand
     */
    public function setType(SectionType $type): CourseSectionCommand
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
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return CourseSectionCommand
     */
    public function setOrder(int $order): CourseSectionCommand
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return CourseInfo
     */
    public function getCourseInfo(): CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return CourseSectionCommand
     */
    public function setCourseInfo(CourseInfo $courseInfo): CourseSectionCommand
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @param CourseSection $entity
     * @return CourseSection
     */
    public function filledEntity($entity): CourseSection
    {
        $entity->setId($this->getId())
            ->setSectionType($this->getType())
            ->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setOrder($this->getOrder());
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}