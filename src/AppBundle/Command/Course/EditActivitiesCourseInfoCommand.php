<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseEvaluationCt\CourseEvaluationCtCommand;
use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Entity\CourseEvaluationCt;
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
     * @var ArrayCollection
     */
    private $evaluations;

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
        $this->evaluations = new ArrayCollection();
        foreach ($courseInfo->getCourseEvaluationCts() as $courseEvaluationCt) {
            $this->evaluations->add(new CourseEvaluationCtCommand($courseEvaluationCt));
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
    public function addSection(CourseSectionCommand $section): EditActivitiesCourseInfoCommand
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
     * @return array
     */
    public function getEvaluations(): ArrayCollection
    {
        return $this->evaluations;
    }

    /**
     * @param ArrayCollection $evaluations
     * @return EditActivitiesCourseInfoCommand
     */
    public function setEvaluations(ArrayCollection $evaluations): EditActivitiesCourseInfoCommand
    {
        $this->evaluations = $evaluations;

        return $this;
    }

    /**
     * @param CourseEvaluationCtCommand $evaluation
     * @return EditActivitiesCourseInfoCommand
     */
    public function addEvaluation(CourseEvaluationCtCommand $evaluation): EditActivitiesCourseInfoCommand
    {
        if(!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
        }
        return $this;
    }

    /**
     * @param CourseEvaluationCtCommand $evaluation
     * @return EditActivitiesCourseInfoCommand
     */
    public function removeEvaluation(CourseEvaluationCtCommand $evaluation): EditActivitiesCourseInfoCommand
    {
        $this->evaluations->removeElement($evaluation);

        return $this;
    }

    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        // Set sections
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

        // Set evaluations
        $courseEvaluationCts = new ArrayCollection();
        foreach ($this->evaluations as $evaluation){
            $id = $evaluation->getId();
            $courseEvaluationCt = $entity->getCourseEvaluationCts()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseEvaluationCt){
                $courseEvaluationCt = new CourseEvaluationCt();
            }
            $evaluation->setCourseInfo($entity);
            $courseEvaluationCt = $evaluation->filledEntity($courseEvaluationCt);
            $courseEvaluationCts->add($courseEvaluationCt);
        }
        $entity->setCourseEvaluationCts($courseEvaluationCts);

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
        $this->sections = clone $this->sections;
        foreach ($this->sections as $key => $section){
            $this->sections->offsetSet($key, clone $section);
        }
        $this->evaluations = clone $this->evaluations;
        foreach ($this->evaluations as $key => $evaluation){
            $this->evaluations->offsetSet($key, clone $evaluation);
        }
    }
}