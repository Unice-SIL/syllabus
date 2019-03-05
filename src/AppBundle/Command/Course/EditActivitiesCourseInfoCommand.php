<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Entity\CourseInfo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class EditActivitiesCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditActivitiesCourseInfoCommand implements CommandInterface
{
    /**
     * @var array
     */
    private $sections;

    /**
     * EditActivitiesCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->sections = new ArrayCollection();
        foreach ($courseInfo->getCourseSections() as $courseSection) {
            $this->sections->add(new CourseSectionCommand($courseSection));
        }
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @param array $sections
     * @return EditActivitiesCourseInfoCommand
     */
    public function setSections(array $sections): EditActivitiesCourseInfoCommand
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
     * @param $entity
     * @return mixed
     */
    public function filledEntity($entity)
    {

    }
}