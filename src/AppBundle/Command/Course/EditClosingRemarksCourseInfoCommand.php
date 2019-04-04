<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EditClosingRemarksCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditClosingRemarksCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var null|string
     */
    private $closingRemarks;

    /**
     * @var null|string
     */
    private $closingVideo;

    /**
     * @var bool
     */
    private $temClosingRemarksTabValid = false;

    /**
     * EditClosingRemarksCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {
        $this->id = $courseInfo->getId();
        $this->closingRemarks = $courseInfo->getClosingRemarks();
        $this->closingVideo = $courseInfo->getClosingVideo();

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
     * @return EditClosingRemarksCourseInfoCommand
     */
    public function setId(string $id): EditClosingRemarksCourseInfoCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClosingRemarks()
    {
        return $this->closingRemarks;
    }

    /**
     * @param null|string $closingRemarks
     * @return EditClosingRemarksCourseInfoCommand
     */
    public function setClosingRemarks($closingRemarks)
    {
        $this->closingRemarks = $closingRemarks;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClosingVideo()
    {
        return $this->closingVideo;
    }

    /**
     * @param null|string $closingVideo
     * @return EditClosingRemarksCourseInfoCommand
     */
    public function setClosingVideo($closingVideo)
    {
        $this->closingVideo = $closingVideo;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemClosingRemarksTabValid(): bool
    {
        return $this->temClosingRemarksTabValid;
    }

    /**
     * @param bool $temClosingRemarksTabValid
     * @return EditClosingRemarksCourseInfoCommand
     */
    public function setTemClosingRemarksTabValid(bool $temClosingRemarksTabValid): EditClosingRemarksCourseInfoCommand
    {
        $this->temClosingRemarksTabValid = $temClosingRemarksTabValid;

        return $this;
    }


    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
        $entity->setClosingRemarks($this->getClosingRemarks())
            ->setClosingVideo($this->getClosingVideo())
            ->setTemClosingRemarksTabValid($this->isTemClosingRemarksTabValid());

        return $entity;
    }

    /**
     *
     */
    public function __clone()
    {
    }
}