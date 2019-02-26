<?php

namespace AppBundle\Command\Teacher;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseTeacher;
use Ramsey\Uuid\Uuid;

class TeacherCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

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


    private $courseInfoId;

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
            $this->firstname = $courseTeacher->getFirstname();
            $this->lastname = $courseTeacher->getLastname();
            $this->email = $courseTeacher->getEmail();
            $this->manager = $courseTeacher->isManager();
            $this->courseInfoId = $courseTeacher->getCourseInfo()->getId();
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
     * @return TeacherCommand
     */
    public function setId(string $id): TeacherCommand
    {
        $this->id = $id;

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
     * @return TeacherCommand
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
     * @return TeacherCommand
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
     * @return TeacherCommand
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
     * @return TeacherCommand
     */
    public function setManager(bool $manager): TeacherCommand
    {
        $this->manager = $manager;

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
        return $entity;
    }
}