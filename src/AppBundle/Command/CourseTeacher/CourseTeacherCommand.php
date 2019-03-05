<?php

namespace AppBundle\Command\CourseTeacher;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use Ramsey\Uuid\Uuid;

class CourseTeacherCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $completeName;

    /**
     * @var null|string
     */
    private $firstname;

    /**
     * @var null|string
     */
    private $lastname;

    /**
     * @var null|string
     */
    private $email;

    /**
     * @var bool
     */
    private $manager;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * TeacherCommand constructor.
     * @param CourseTeacher|null $courseTeacher
     */
    public function __construct(CourseTeacher $courseTeacher=null)
    {
        if (is_null($courseTeacher)) {
            $this->id = Uuid::uuid4();
            $this->manager = false;
        }else{
            $this->id = $courseTeacher->getId();
            $this->completeName = trim($courseTeacher->getLastname()." ".$courseTeacher->getFirstname());
            $this->firstname = $courseTeacher->getFirstname();
            $this->lastname = $courseTeacher->getLastname();
            $this->email = $courseTeacher->getEmail();
            $this->manager = $courseTeacher->isManager();
            $this->courseInfo = $courseTeacher->getCourseInfo();
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
     * @return CourseTeacherCommand
     */
    public function setId(string $id): CourseTeacherCommand
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompleteName(): ?string
    {
        return $this->completeName;
    }

    /**
     * @param string $completeName
     * @return CourseTeacherCommand
     */
    public function setCompleteName(string $completeName): CourseTeacherCommand
    {
        $this->completeName = $completeName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return CourseTeacherCommand
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return CourseTeacherCommand
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return CourseTeacherCommand
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->manager;
    }

    /**
     * @param bool $manager
     * @return CourseTeacherCommand
     */
    public function setManager(bool $manager): CourseTeacherCommand
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return CourseInfo|null
     */
    public function getCourseInfo(): ?CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return $this
     */
    public function setCourseInfo(CourseInfo $courseInfo)
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @param CourseTeacher $entity
     * @return CourseTeacher
     */
    public function filledEntity($entity): CourseTeacher
    {
        $entity->setId($this->getId())
            ->setFirstname($this->getFirstname())
            ->setLastname($this->getLastname())
            ->setEmail($this->getEmail())
            ->setManager($this->isManager());
        if(!is_null($this->getCourseInfo())){
            $entity->setCourseInfo($this->getCourseInfo());
        }
        return $entity;
    }
}