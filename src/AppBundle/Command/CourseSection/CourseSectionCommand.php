<?php

namespace AppBundle\Command\CourseSection;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseSectionActivity\CourseSectionActivityCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseSectionActivity;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var null|string
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var int
     */
    private $order = 0;

    /**
     * @var CourseInfo|null
     */
    private $courseInfo;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     */
    private $activities;

    /**
     * CourseSectionCommand constructor.
     * @param CourseSection|null $courseSection
     */
    public function __construct(CourseSection $courseSection = null)
    {
        if(is_null($courseSection)) {
            $this->id = Uuid::uuid4();
            $this->activities = new ArrayCollection();
        }else{
            $this->id = $courseSection->getId();
            $this->courseInfo = $courseSection->getCourseInfo();
            $this->title = $courseSection->getTitle();
            $this->description = $courseSection->getDescription();
            $this->order = $courseSection->getOrder();
            $this->activities = new ArrayCollection();
            foreach ($courseSection->getCourseSectionActivities() as $courseSectionActivity) {
                $this->activities->add(new CourseSectionActivityCommand($courseSectionActivity));
            }
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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return CourseSectionCommand
     */
    public function setTitle($title): CourseSectionCommand
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
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int|null $order
     * @return CourseSectionCommand
     */
    public function setOrder($order = 0): CourseSectionCommand
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return CourseInfo|null
     */
    public function getCourseInfo(): ?CourseInfo
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
     * @return array
     */
    public function getActivities(): ArrayCollection
    {
        return $this->activities;
    }

    /**
     * @param ArrayCollection $sectionActivities
     * @return CourseSectionCommand
     */
    public function setActivities(ArrayCollection $activities): CourseSectionCommand
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * @param CourseSectionActivityCommand $activity
     * @return CourseSectionCommand
     */
    public function addActivity(CourseSectionActivityCommand $activity): CourseSectionCommand
    {
        if(!$this->activities->contains($activity)) {
            $this->activities->add($activity);
        }

        return $this;
    }

    /**
     * @param CourseSectionActivityCommand $activity
     * @return CourseSectionCommand
     */
    public function removeActivity(CourseSectionActivityCommand $activity): CourseSectionCommand
    {
        $this->activities->removeElement($activity);

        return $this;
    }

    /**
     * @param CourseSection $entity
     * @return CourseSection
     */
    public function filledEntity($entity): CourseSection
    {
        $entity->setId($this->getId())
            ->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setOrder($this->getOrder());
        $courseSectionActivities = new ArrayCollection();
        foreach ($this->activities as $activity){
            $id = $activity->getId();
            $courseSectionActivity = $entity->getCourseSectionActivities()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseSectionActivity){
                $courseSectionActivity = new CourseSectionActivity();
            }
            $activity->setCourseSection($entity);
            $courseSectionActivity = $activity->filledEntity($courseSectionActivity);
            $courseSectionActivities->add($courseSectionActivity);
        }
        $entity->setCourseSectionActivities($courseSectionActivities);

        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
        $this->activities = clone $this->activities;
        foreach ($this->activities as $key => $activity){
            $this->activities->offsetSet($key, clone $activity);
        }
    }
}