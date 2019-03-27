<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Command\CourseAchievement\CourseAchievementCommand;
use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use Doctrine\Common\Collections\ArrayCollection;

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
     */
    private $achievements;

    /**
     * EditObjectivesCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->achievements = new ArrayCollection();
        foreach ($courseInfo->getCourseAchievements() as $courseAchievement) {
            $this->achievements->add(new CourseAchievementCommand($courseAchievement));
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
     * @return array
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
    }
}