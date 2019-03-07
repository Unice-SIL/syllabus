<?php

namespace AppBundle\Command\CourseSectionActivity;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\Activity;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseSectionActivity;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseSectionActivityCommand
 * @package AppBundle\Command\CourseSection
 */
class CourseSectionActivityCommand implements CommandInterface
{
    /**
     * @var string
     */

    private $id;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var int
     */
    private $order;

    /**
     * @var CourseSection|null
     */
    private $courseSection;

    /**
     * @var Activity|null
     */
    private $activity;

    /**
     * CourseSectionActivityCommand constructor.
     * @param CourseSectionActivity|null $courseSectionActivity
     */
    public function __construct(CourseSectionActivity $courseSectionActivity = null)
    {
        if(is_null($courseSectionActivity)) {
            $this->id = Uuid::uuid4();
            $this->order = 0;
        }else{
            $this->id = $courseSectionActivity->getId();
            $this->courseSection = $courseSectionActivity->getCourseSection();
            $this->activity = $courseSectionActivity->getActivity();
            $this->description = $courseSectionActivity->getDescription();
            $this->order = $courseSectionActivity->getOrder();
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
     * @return CourseSectionActivityCommand
     */
    public function setId(string $id): CourseSectionActivityCommand
    {
        $this->id = $id;

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
     * @return CourseSectionActivityCommand
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
     * @return CourseSectionActivityCommand
     */
    public function setOrder(int $order): CourseSectionActivityCommand
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return CourseSection|null
     */
    public function getCourseSection(): ?CourseSection
    {
        return $this->courseSection;
    }

    /**
     * @param CourseSection $courseSection
     * @return CourseSectionActivityCommand
     */
    public function setCourseSection(CourseSection $courseSection): CourseSectionActivityCommand
    {
        $this->courseSection = $courseSection;

        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity $activity
     * @return CourseSectionActivityCommand
     */
    public function setActivity(Activity $activity): CourseSectionActivityCommand
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @param CourseSectionActivity $entity
     * @return CourseSectionActivity
     */
    public function filledEntity($entity): CourseSectionActivity
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setOrder($this->getOrder());
        if(!is_null($this->getActivity())){
            $entity->setActivity($this->getActivity());
        }
        if(!is_null($this->getCourseSection())){
            $entity->setCourseSection($this->getCourseSection());
        }
        return $entity;
    }
}