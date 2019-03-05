<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class EditActivitiesCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditActivitiesCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var ArrayCollection
     */
    private $sections;

    /**
     * EditActivitiesCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->sections = new ArrayCollection();
        foreach ($courseInfo->getCourseSections() as $courseSection) {
            $this->sections->add(new CourseSectionCommand($courseSection));
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
     * @return EditActivitiesCourseInfoCommand
     */
    public function setId(string $id): EditActivitiesCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return array
     */
    public function getSections(): ArrayCollection
    {
        return $this->sections;
    }

    /**
     * @param ArrayCollection $sections
     * @return EditActivitiesCourseInfoCommand
     */
    public function setSections(ArrayCollection $sections): EditActivitiesCourseInfoCommand
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * @param CourseSectionCommand $section
     * @return EditActivitiesCourseInfoCommand
     */
    public function addTeacher(CourseSectionCommand $section): EditActivitiesCourseInfoCommand
    {
        if(!$this->sections->contains($section)) {
            $this->sections->add($section);
        }

        return $this;
    }

    /**
     * @param CourseSectionCommand $section
     * @return EditActivitiesCourseInfoCommand
     */
    public function removeSection(CourseSectionCommand $section): EditActivitiesCourseInfoCommand
    {
        $this->sections->removeElement($section);

        return $this;
    }

    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $courseSections = new ArrayCollection();
        foreach ($this->sections as $section){
            $id = $section->getId();
            $courseSection = $entity->getCourseSections()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseSection){
                $courseSection = new CourseSection();
            }
            $section->setCourseInfo($entity);
            $courseSection = $section->filledEntity($courseSection);
            $courseSections->add($courseSection);
        }
        $entity->setCourseSections($courseSections);

        return $entity;
    }
}