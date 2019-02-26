<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\Teacher\TeacherCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class EditCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditPresentationCourseInfoCommand implements CommandInterface
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $year;

    /**
     * @var null|string
     */
    private $period;

    /**
     * @var null|string
     */
    private $summary;

    /**
     * @var null|string
     */
    private $mediaType;

    /**
     * @var null|string
     */
    private $image;

    /**
     * @var null|string
     */
    private $video;

    /**
     * @var null|string
     */
    private $teachingMode;

    /**
     * @var float|null
     */
    private $teachingCmClass;

    /**
     * @var float|null
     */
    private $teachingTdClass;

    /**
     * @var float|null
     */
    private $teachingTpClass;

    /**
     * @var float|null
     */
    private $teachingOtherClass;

    /**
     * @var float|null
     */
    private $teachingCmHybridClass;

    /**
     * @var float|null
     */
    private $teachingTdHybridClass;

    /**
     * @var float|null
     */
    private $teachingTpHybridClass;

    /**
     * @var float|null
     */
    private $teachingOtherHybridClass;

    /**
     * @var float|null
     */
    private $teachingCmHybridDist;

    /**
     * @var float|null
     */
    private $teachingTdHybridDist;

    /**
     * @var float|null
     */
    private $teachingOtherHybridDist;


    /**
     * @var array
     */
    private $teachers;

    /**
     * EditCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->year = $courseInfo->getYear()->getId();
        $this->period = $courseInfo->getPeriod();
        $this->summary = $courseInfo->getSummary();
        $this->mediaType = $courseInfo->getMediaType();
        $this->image = $courseInfo->getImage();
        $this->video = $courseInfo->getVideo();
        $this->teachingMode = $courseInfo->getTeachingMode();
        $this->teachingCmClass = $courseInfo->getTeachingCmClass();
        $this->teachingTdClass = $courseInfo->getTeachingTdClass();
        $this->teachingTpClass = $courseInfo->getTeachingTpClass();
        $this->teachingOtherClass = $courseInfo->getTeachingOtherClass();
        $this->teachingCmHybridClass = $courseInfo->getTeachingCmHybridClass();
        $this->teachingTdHybridClass = $courseInfo->getTeachingTpHybridClass();
        $this->teachingTpHybridClass = $courseInfo->getTeachingTpHybridClass();
        $this->teachingOtherHybridClass = $courseInfo->getTeachingOtherHybridClass();
        $this->teachingCmHybridDist = $courseInfo->getTeachingCmHybridDist();
        $this->teachingTdHybridDist = $courseInfo->getTeachingTdHybridDist();
        $this->teachingOtherHybridDist = $courseInfo->getTeachingOtherHybridDist();
        $this->teachers = new ArrayCollection();
        foreach ($courseInfo->getCourseTeachers() as $teacher){
            $this->teachers->add(new TeacherCommand($teacher));
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
     * @return EditPresentationCourseInfoCommand
     */
    public function setId(string $id): EditPresentationCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return EditPresentationCourseInfoCommand
     */
    public function setYear(string $year): EditPresentationCourseInfoCommand
    {
        $this->year = $year;

        return $this;
    }


    /**
     * @return null|string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param null|string $period
     * @return EditPresentationCourseInfoCommand
     */
    public function setPeriod($period)
    {
        $this->period = $period;

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
     * @return EditPresentationCourseInfoCommand
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * @param null|string $mediaType
     * @return EditPresentationCourseInfoCommand
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param null|string $image
     * @return EditPresentationCourseInfoCommand
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param null|string $video
     * @return EditPresentationCourseInfoCommand
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTeachingMode()
    {
        return $this->teachingMode;
    }

    /**
     * @param null|string $teachingMode
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingMode($teachingMode)
    {
        $this->teachingMode = $teachingMode;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingCmClass()
    {
        return $this->teachingCmClass;
    }

    /**
     * @param float|null $teachingCmClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingCmClass($teachingCmClass)
    {
        $this->teachingCmClass = $teachingCmClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdClass()
    {
        return $this->teachingTdClass;
    }

    /**
     * @param float|null $teachingTdClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingTdClass($teachingTdClass)
    {
        $this->teachingTdClass = $teachingTdClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTpClass()
    {
        return $this->teachingTpClass;
    }

    /**
     * @param float|null $teachingTpClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingTpClass($teachingTpClass)
    {
        $this->teachingTpClass = $teachingTpClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherClass()
    {
        return $this->teachingOtherClass;
    }

    /**
     * @param float|null $teachingOtherClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingOtherClass($teachingOtherClass)
    {
        $this->teachingOtherClass = $teachingOtherClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingCmHybridClass()
    {
        return $this->teachingCmHybridClass;
    }

    /**
     * @param float|null $teachingCmHybridClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingCmHybridClass($teachingCmHybridClass)
    {
        $this->teachingCmHybridClass = $teachingCmHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdHybridClass()
    {
        return $this->teachingTdHybridClass;
    }

    /**
     * @param float|null $teachingTdHybridClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingTdHybridClass($teachingTdHybridClass)
    {
        $this->teachingTdHybridClass = $teachingTdHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTpHybridClass()
    {
        return $this->teachingTpHybridClass;
    }

    /**
     * @param float|null $teachingTpHybridClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingTpHybridClass($teachingTpHybridClass)
    {
        $this->teachingTpHybridClass = $teachingTpHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherHybridClass()
    {
        return $this->teachingOtherHybridClass;
    }

    /**
     * @param float|null $teachingOtherHybridClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingOtherHybridClass($teachingOtherHybridClass)
    {
        $this->teachingOtherHybridClass = $teachingOtherHybridClass;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingCmHybridDist()
    {
        return $this->teachingCmHybridDist;
    }

    /**
     * @param float|null $teachingCmHybridDist
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingCmHybridDist($teachingCmHybridDist)
    {
        $this->teachingCmHybridDist = $teachingCmHybridDist;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingTdHybridDist()
    {
        return $this->teachingTdHybridDist;
    }

    /**
     * @param float|null $teachingTdHybridDist
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingTdHybridDist($teachingTdHybridDist)
    {
        $this->teachingTdHybridDist = $teachingTdHybridDist;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTeachingOtherHybridDist()
    {
        return $this->teachingOtherHybridDist;
    }

    /**
     * @param float|null $teachingOtherHybridDist
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingOtherHybridDist($teachingOtherHybridDist)
    {
        $this->teachingOtherHybridDist = $teachingOtherHybridDist;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTeachers(): ArrayCollection
    {
        return $this->teachers;
    }

    /**
     * @param ArrayCollection $teachers
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachers(ArrayCollection $teachers): EditPresentationCourseInfoCommand
    {
        $this->teachers = $teachers;

        return $this;
    }

    /**
     * @param TeacherCommand $teacher
     * @return EditPresentationCourseInfoCommand
     */
    public function addTeacher(TeacherCommand $teacher): EditPresentationCourseInfoCommand
    {
        if(!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
        }

        return $this;
    }

    /**
     * @param TeacherCommand $teacher
     * @return EditPresentationCourseInfoCommand
     */
    public function removeTeacher(TeacherCommand $teacher): EditPresentationCourseInfoCommand
    {
        $this->teachers->removeElement($teacher);

        return $this;
    }

    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        // CourseInfo
        $entity->setPeriod($this->getPeriod())
            ->setSummary($this->getSummary())
            ->setMediaType($this->getMediaType())
            ->setImage($this->getImage())
            ->setVideo($this->getVideo())
            ->setTeachingMode($this->getTeachingMode())
            ->setTeachingCmClass($this->getTeachingCmClass())
            ->setTeachingTdClass($this->getTeachingTdClass())
            ->setTeachingTpClass($this->getTeachingTpClass())
            ->setTeachingOtherClass($this->getTeachingOtherClass())
            ->setTeachingCmHybridClass($this->getTeachingCmHybridClass())
            ->setTeachingTdHybridClass($this->getTeachingTdHybridClass())
            ->setTeachingTpHybridClass($this->getTeachingTpHybridClass())
            ->setTeachingOtherHybridClass($this->getTeachingOtherHybridClass())
            ->setTeachingCmHybridDist($this->getTeachingCmHybridDist())
            ->setTeachingTdHybridDist($this->getTeachingTdHybridDist())
            ->setTeachingOtherHybridDist($this->getTeachingOtherHybridDist());

        // CourseTeacher
        $courseTeachers = new ArrayCollection();
        foreach ($this->teachers as $teacher){
            $id = $teacher->getId();
            $courseTeacher = $entity->getCourseTeachers()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseTeacher){
                $courseTeacher = new CourseTeacher();
            }
            $courseTeacher = $teacher->filledEntity($courseTeacher);
            $courseTeacher->setCourseInfo($entity);
            $courseTeachers->add($courseTeacher);
        }
        $entity->setCourseTeachers($courseTeachers);

        return $entity;
    }
}