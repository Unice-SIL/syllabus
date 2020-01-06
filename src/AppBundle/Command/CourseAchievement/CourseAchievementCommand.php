<?php

namespace AppBundle\Command\CourseAchievement;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CourseAchievementCommand
 * @package AppBundle\Command\CourseTeacher
 */
class CourseAchievementCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

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
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * CourseAchievementCommand constructor.
     * @param CourseAchievement|null $courseAchievement
     * @throws \Exception
     */
    public function __construct(CourseAchievement $courseAchievement=null)
    {
        if (is_null($courseAchievement)) {
            $this->id = Uuid::uuid4();
        }else{
            $this->id = $courseAchievement->getId();
            $this->description = $courseAchievement->getDescription();
            $this->order = $courseAchievement->getOrder();
            $this->courseInfo = $courseAchievement->getCourseInfo();
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
     * @return CourseAchievementCommand
     */
    public function setId(string $id): CourseAchievementCommand
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
     * @return CourseAchievementCommand
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
     * @return CourseAchievementCommand
     */
    public function setOrder(int $order): CourseAchievementCommand
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
     * @return CourseAchievementCommand
     */
    public function setCourseInfo(CourseInfo $courseInfo): CourseAchievementCommand
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @param CourseAchievement $entity
     * @return CourseAchievement
     */
    public function filledEntity($entity): CourseAchievement
    {
        $entity->setId($this->getId())
            ->setDescription($this->getDescription())
            ->setOrder($this->getOrder());
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}