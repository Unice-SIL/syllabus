<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseTeacher\CourseTeacherCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var null|string
     *
     *
     */
    private $period;

    /**
     * @var null|string
     *
     * @Assert\NotBlank()
     */
    private $level;

    /**
     * @var null|string
     *
     * @Assert\NotBlank()
     */
    private $domain;

    /**
     * @var null|string
     *
     * @Assert\NotBlank(
     *     message = "Vous devez renseigner ce champ"
     * )
     */
    private $summary;

    /**
     * @var null|string
     *
     */
    private $mediaType;

    /**
     * @var mixed
     *
     * @Assert\Expression(
     *     "not ( (this.getMediaType() == 'image' or this.getMediaType() == null) and this.getImage() == null)"
     * )
     */
    private $image;

    /**
     * @var null|string
     *
     * @Assert\Expression(
     *     "not ( this.getMediaType() == 'video' and this.getVideo() == null)"
     * )
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
     *
     * @Assert\Type("numeric")
     */
    private $teachingOtherClass;

    /**
     * @var string|null
     *
     * @Assert\Expression(
     *     "not (this.getTeachingMode() == 'class' and this.getTeachingOtherClass() != null and this.getTeachingOtherTypeClass() == null )"
     * )
     */
    private $teachingOtherTypeClass;

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
     *
     * @Assert\Type("numeric")
     */
    private $teachingOtherHybridClass;

    /**
     * @var string|null
     *
     * @Assert\Expression(
     *     "not (this.getTeachingMode() == 'hybrid' and this.getTeachingOtherHybridClass() != null and this.getTeachingOtherTypeHybridClass() == null )"
     * )
     */
    private $teachingOtherTypeHybridClass;

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
     *
     * @Assert\Type("numeric")
     */
    private $teachingOtherHybridDist;

    /**
     * @var string|null
     *
     * @Assert\Expression(
     *     "not (this.getTeachingMode() == 'hybrid' and this.getTeachingOtherHybridDist() != null and this.getTeachingOtherTypeHybridDistant() == null )"
     * )
     */
    private $teachingOtherTypeHybridDistant;

    /**
     * @var bool
     */
    private $temPresentationTabValid = false;

    /**
     * @var array
     *
     * @Assert\Count(
     *     min = 1,
     *     minMessage = "Vous devez ajouter au moins un enseignant à l'équipe pédagogique"
     * )
     */
    private $teachers;

    /**
     * EditCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->period = $courseInfo->getPeriod();
        $this->level = $courseInfo->getLevel();
        $this->domain = $courseInfo->getDomain();
        $this->summary = $courseInfo->getSummary();
        $this->mediaType = $courseInfo->getMediaType();
        $this->image = $courseInfo->getImage();
        $this->video = $courseInfo->getVideo();
        $this->teachingMode = $courseInfo->getTeachingMode();
        $this->teachingCmClass = $courseInfo->getTeachingCmClass();
        $this->teachingTdClass = $courseInfo->getTeachingTdClass();
        $this->teachingTpClass = $courseInfo->getTeachingTpClass();
        $this->teachingOtherClass = $courseInfo->getTeachingOtherClass();
        $this->teachingOtherTypeClass = $courseInfo->getTeachingOtherTypeClass();
        $this->teachingCmHybridClass = $courseInfo->getTeachingCmHybridClass();
        $this->teachingTdHybridClass = $courseInfo->getTeachingTdHybridClass();
        $this->teachingTpHybridClass = $courseInfo->getTeachingTpHybridClass();
        $this->teachingOtherHybridClass = $courseInfo->getTeachingOtherHybridClass();
        $this->teachingCmHybridDist = $courseInfo->getTeachingCmHybridDist();
        $this->teachingTdHybridDist = $courseInfo->getTeachingTdHybridDist();
        $this->teachingOtherHybridDist = $courseInfo->getTeachingOtherHybridDist();
        $this->teachers = new ArrayCollection();
        foreach ($courseInfo->getCourseTeachers() as $teacher){
            $this->teachers->add(new CourseTeacherCommand($teacher));
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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param null|string $level
     * @return EditPresentationCourseInfoCommand
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param null|string $domain
     * @return EditPresentationCourseInfoCommand
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

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
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
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
     * @return null|string
     */
    public function getTeachingOtherTypeClass()
    {
        return $this->teachingOtherTypeClass;
    }

    /**
     * @param null|string $teachingOtherTypeClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingOtherTypeClass($teachingOtherTypeClass)
    {
        $this->teachingOtherTypeClass = $teachingOtherTypeClass;

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
     * @return null|string
     */
    public function getTeachingOtherTypeHybridClass()
    {
        return $this->teachingOtherTypeHybridClass;
    }

    /**
     * @param null|string $teachingOtherTypeHybridClass
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingOtherTypeHybridClass($teachingOtherTypeHybridClass)
    {
        $this->teachingOtherTypeHybridClass = $teachingOtherTypeHybridClass;

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
     * @return null|string
     */
    public function getTeachingOtherTypeHybridDistant()
    {
        return $this->teachingOtherTypeHybridDistant;
    }

    /**
     * @param null|string $teachingOtherTypeHybridDistant
     * @return EditPresentationCourseInfoCommand
     */
    public function setTeachingOtherTypeHybridDistant($teachingOtherTypeHybridDistant)
    {
        $this->teachingOtherTypeHybridDistant = $teachingOtherTypeHybridDistant;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemPresentationTabValid(): bool
    {
        return $this->temPresentationTabValid;
    }

    /**
     * @param bool $temPresentationTabValid
     * @return EditPresentationCourseInfoCommand
     */
    public function setTemPresentationTabValid(bool $temPresentationTabValid): EditPresentationCourseInfoCommand
    {
        $this->temPresentationTabValid = $temPresentationTabValid;

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
     * @param CourseTeacherCommand $teacher
     * @return EditPresentationCourseInfoCommand
     */
    public function addTeacher(CourseTeacherCommand $teacher): EditPresentationCourseInfoCommand
    {
        if(!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
        }

        return $this;
    }

    /**
     * @param CourseTeacherCommand $teacher
     * @return EditPresentationCourseInfoCommand
     */
    public function removeTeacher(CourseTeacherCommand $teacher): EditPresentationCourseInfoCommand
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
            ->setLevel($this->getLevel())
            ->setDomain($this->getDomain())
            ->setSummary($this->getSummary())
            ->setMediaType($this->getMediaType())
            ->setImage($this->getImage())
            ->setVideo($this->getVideo())
            ->setTeachingMode($this->getTeachingMode())
            ->setTeachingCmClass($this->getTeachingCmClass())
            ->setTeachingTdClass($this->getTeachingTdClass())
            ->setTeachingTpClass($this->getTeachingTpClass())
            ->setTeachingOtherClass($this->getTeachingOtherClass())
            ->setTeachingOtherTypeClass($this->getTeachingOtherTypeClass())
            ->setTeachingCmHybridClass($this->getTeachingCmHybridClass())
            ->setTeachingTdHybridClass($this->getTeachingTdHybridClass())
            ->setTeachingTpHybridClass($this->getTeachingTpHybridClass())
            ->setTeachingOtherHybridClass($this->getTeachingOtherHybridClass())
            ->setTeachingCmHybridDist($this->getTeachingCmHybridDist())
            ->setTeachingTdHybridDist($this->getTeachingTdHybridDist())
            ->setTeachingOtherHybridDist($this->getTeachingOtherHybridDist())
            ->setTemPresentationTabValid($this->isTemPresentationTabValid());

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
            $teacher->setCourseInfo($entity);
            $courseTeacher = $teacher->filledEntity($courseTeacher);
            $courseTeachers->add($courseTeacher);
        }
        $entity->setCourseTeachers($courseTeachers);

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
        $this->teachers = clone $this->teachers;
        foreach ($this->teachers as $key => $teacher){
            $this->teachers->offsetSet($key, clone $teacher);
        }
    }
}