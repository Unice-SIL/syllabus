<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseAchievement\CourseAchievementCommand;
use AppBundle\Command\CoursePrerequisite\CoursePrerequisiteCommand;
use AppBundle\Command\CourseTutoringResource\CourseTutoringResourceCommand;
use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Query\Course\EditObjectivesCourseInfoQuery;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EditObjectivesCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditObjectivesCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     * @Assert\Count(
     *     min = 1,
     *     minMessage = "Vous devez ajouter au moins un acquis d'apprentissage"
     * )
     */
    private $achievements;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     */
    private $prerequisites;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     */
    private $tutoringResources;

    /**
     * @var bool
     */
    private $tutoring = false;

    /**
     * @var bool
     *
     * @Assert\Expression(
     *     "not ( this.isTutoring() == true and this.isTutoringTeacher() == false and this.isTutoringStudent() == false)",
     *     message=""
     * )
     */
    private $tutoringTeacher = false;

    /**
     * @var bool
     *
     * @Assert\Expression(
     *     "not ( this.isTutoring() == true and this.isTutoringTeacher() == false and this.isTutoringStudent() == false)",
     *     message=""
     * )
     */
    private $tutoringStudent = false;

    /**
     * @var null|string
     *
     * //@Assert\Expression(
     * //    "not ( this.isTutoring() == true and this.getTutoringDescription() == null )"
     * //)
     */
    private $tutoringDescription;

    /**
     * @var bool
     */
    private $temObjectivesTabValid = false;

    /**
     * EditObjectivesCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->tutoring = $courseInfo->isTutoring();
        $this->tutoringTeacher = $courseInfo->isTutoringTeacher();
        $this->tutoringStudent = $courseInfo->isTutoringStudent();
        $this->tutoringDescription = $courseInfo->getTutoringDescription();
        $this->achievements = new ArrayCollection();
        foreach ($courseInfo->getCourseAchievements() as $courseAchievement) {
            $this->achievements->add(new CourseAchievementCommand($courseAchievement));
        }
        $this->prerequisites = new ArrayCollection();
        foreach ($courseInfo->getCoursePrerequisites() as $coursePrerequisite) {
            $this->prerequisites->add(new CoursePrerequisiteCommand($coursePrerequisite));
        }
        $this->tutoringResources = new ArrayCollection();
        foreach ($courseInfo->getCourseTutoringResources() as $courseTutoringResource) {
            $this->tutoringResources->add(new CourseTutoringResourceCommand($courseTutoringResource));
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
     * @return EditObjectivesCourseInfoCommand
     */
    public function setId(string $id): EditObjectivesCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTutoring(): bool
    {
        return $this->tutoring;
    }

    /**
     * @param bool $tutoring
     * @return EditObjectivesCourseInfoCommand
     */
    public function setTutoring(bool $tutoring): EditObjectivesCourseInfoCommand
    {
        $this->tutoring = $tutoring;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTutoringTeacher(): bool
    {
        return $this->tutoringTeacher;
    }

    /**
     * @param bool $tutoringTeacher
     * @return EditObjectivesCourseInfoCommand
     */
    public function setTutoringTeacher(bool $tutoringTeacher): EditObjectivesCourseInfoCommand
    {
        $this->tutoringTeacher = $tutoringTeacher;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTutoringStudent(): bool
    {
        return $this->tutoringStudent;
    }

    /**
     * @param bool $tutoringStudent
     * @return EditObjectivesCourseInfoCommand
     */
    public function setTutoringStudent(bool $tutoringStudent): EditObjectivesCourseInfoCommand
    {
        $this->tutoringStudent = $tutoringStudent;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTutoringDescription()
    {
        return $this->tutoringDescription;
    }

    /**
     * @param null|string $tutoringDescription
     * @return EditObjectivesCourseInfoCommand
     */
    public function setTutoringDescription($tutoringDescription)
    {
        $this->tutoringDescription = $tutoringDescription;

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getAchievements(): ArrayCollection
    {
        return $this->achievements;
    }

    /**
     * @param ArrayCollection $achievements
     * @return EditObjectivesCourseInfoCommand
     */
    public function setAchievements(ArrayCollection $achievements): EditObjectivesCourseInfoCommand
    {
        $this->achievements = $achievements;

        return $this;
    }

    /**
     * @param CourseAchievementCommand $achievement
     * @return EditObjectivesCourseInfoCommand
     */
    public function addAchievement(CourseAchievementCommand $achievement): EditObjectivesCourseInfoCommand
    {
        if(!$this->achievements->contains($achievement)) {
            $this->achievements->add($achievement);
        }

        return $this;
    }

    /**
     * @param CourseAchievementCommand $achievement
     * @return EditObjectivesCourseInfoCommand
     */
    public function removeAchievement(CourseAchievementCommand $achievement): EditObjectivesCourseInfoCommand
    {
        $this->achievements->removeElement($achievement);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPrerequisites(): ArrayCollection
    {
        return $this->prerequisites;
    }

    /**
     * @param ArrayCollection $prerequisites
     * @return EditObjectivesCourseInfoCommand
     */
    public function setPrerequisites(ArrayCollection $prerequisites): EditObjectivesCourseInfoCommand
    {
        $this->prerequisites = $prerequisites;

        return $this;
    }

    /**
     * @param CoursePrerequisiteCommand $prerequisite
     * @return EditObjectivesCourseInfoCommand
     */
    public function addPrerequisite(CoursePrerequisiteCommand $prerequisite): EditObjectivesCourseInfoCommand
    {
        if(!$this->prerequisites->contains($prerequisite)) {
            $this->prerequisites->add($prerequisite);
        }

        return $this;
    }

    /**
     * @param CoursePrerequisiteCommand $prerequisite
     * @return EditObjectivesCourseInfoCommand
     */
    public function removePrerequisite(CoursePrerequisiteCommand $prerequisite): EditObjectivesCourseInfoCommand
    {
        $this->prerequisites->removeElement($prerequisite);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTutoringResources(): ArrayCollection
    {
        return $this->tutoringResources;
    }

    /**
     * @param ArrayCollection $tutoringResources
     * @return EditObjectivesCourseInfoCommand
     */
    public function setTutoringResources(ArrayCollection $tutoringResources): EditObjectivesCourseInfoCommand
    {
        $this->tutoringResources = $tutoringResources;

        return $this;
    }

    /**
     * @param CourseTutoringResourceCommand $tutoringResources
     * @return EditObjectivesCourseInfoCommand
     */
    public function addTutoringResource(CourseTutoringResourceCommand $tutoringResources): EditObjectivesCourseInfoCommand
    {
        if(!$this->tutoringResources->contains($tutoringResources)) {
            $this->tutoringResources->add($tutoringResources);
        }

        return $this;
    }

    /**
     * @param CourseTutoringResourceCommand $tutoringResources
     * @return EditObjectivesCourseInfoCommand
     */
    public function removeTutoringResource(CourseTutoringResourceCommand $tutoringResources): EditObjectivesCourseInfoCommand
    {
        $this->tutoringResources->removeElement($tutoringResources);

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemObjectivesTabValid(): bool
    {
        return $this->temObjectivesTabValid;
    }

    /**
     * @param bool $temObjectivesTabValid
     * @return EditObjectivesCourseInfoCommand
     */
    public function setTemObjectivesTabValid(bool $temObjectivesTabValid): EditObjectivesCourseInfoCommand
    {
        $this->temObjectivesTabValid = $temObjectivesTabValid;

        return $this;
    }

    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        // Set achievements
        $courseAchievements = new ArrayCollection();
        foreach ($this->achievements as $achievement){
            $id = $achievement->getId();
            $courseAchievement = $entity->getCourseAchievements()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseAchievement){
                $courseAchievement = new CourseAchievement();
            }
            $achievement->setCourseInfo($entity);
            $courseAchievement = $achievement->filledEntity($courseAchievement);
            $courseAchievements->add($courseAchievement);
        }
        $entity->setCourseAchievements($courseAchievements);

        // Set prerequisites
        $coursePrerequisites = new ArrayCollection();
        foreach ($this->prerequisites as $prerequisite){
            $id = $prerequisite->getId();
            $coursePrerequisite = $entity->getCoursePrerequisites()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$coursePrerequisite){
                $coursePrerequisite = new CoursePrerequisite();
            }
            $prerequisite->setCourseInfo($entity);
            $coursePrerequisite = $prerequisite->filledEntity($coursePrerequisite);
            $coursePrerequisites->add($coursePrerequisite);
        }
        $entity->setCoursePrerequisites($coursePrerequisites);

        // Set tutoringResources
        $courseTutoringResources = new ArrayCollection();
        foreach ($this->tutoringResources as $tutoringResource){
            $id = $tutoringResource->getId();
            $courseTutoringResource = $entity->getCourseTutoringResources()->filter(function($entry) use ($id){
                return ($entry->getId() === $id)? true : false;
            })->first();
            if(!$courseTutoringResource){
                $courseTutoringResource = new CourseTutoringResource();
            }
            $tutoringResource->setCourseInfo($entity);
            $courseTutoringResource = $tutoringResource->filledEntity($courseTutoringResource);
            $courseTutoringResources->add($courseTutoringResource);
        }
        $entity->setCourseTutoringResources($courseTutoringResources);

        // Set tutoring
        $entity->setTutoring($this->isTutoring())
            ->setTutoringTeacher($this->isTutoringTeacher())
            ->setTutoringStudent($this->isTutoringStudent())
            ->setTutoringDescription($this->getTutoringDescription())
            ->setTemObjectivesTabValid($this->isTemObjectivesTabValid());

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
        $this->achievements = clone $this->achievements;
        foreach ($this->achievements as $key => $achievement){
            $this->achievements->offsetSet($key, clone $achievement);
        }
        $this->prerequisites = clone $this->prerequisites;
        foreach ($this->prerequisites as $key => $prerequisite){
            $this->prerequisites->offsetSet($key, clone $prerequisite);
        }
        $this->tutoringResources = clone $this->tutoringResources;
        foreach ($this->tutoringResources as $key => $tutoringResource){
            $this->tutoringResources->offsetSet($key, clone $tutoringResource);
        }
    }
}