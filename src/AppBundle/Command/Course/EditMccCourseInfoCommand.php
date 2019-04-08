<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EditMccCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditMccCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var null|string
     */
    private $mccAdvice;

    /**
     * @var bool
     */
    private $temMccTabValid = false;

    /**
     * EditMccCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->mccAdvice = $courseInfo->getMccAdvice();
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
     * @return EditInfosCourseInfoCommand
     */
    public function setId(string $id): EditInfosCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMccAdvice()
    {
        return $this->mccAdvice;
    }

    /**
     * @param null|string $mccAdvice
     * @return EditInfosCourseInfoCommand
     */
    public function setMccAdvice($mccAdvice)
    {
        $this->mccAdvice = $mccAdvice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemMccTabValid(): bool
    {
        return $this->temMccTabValid;
    }

    /**
     * @param bool $temMccTabValid
     * @return EditMccCourseInfoCommand
     */
    public function setTemMccTabValid(bool $temMccTabValid): EditMccCourseInfoCommand
    {
        $this->temMccTabValid = $temMccTabValid;

        return $this;
    }


    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $entity->setMccAdvice($this->getMccAdvice())
            ->setTemMccTabValid($this->isTemMccTabValid());

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
    }
}