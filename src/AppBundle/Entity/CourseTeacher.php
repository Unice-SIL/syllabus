<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * CourseTeacher
 *
 * @ORM\Table(name="course_teacher")
 * @ORM\Entity
 */
class CourseTeacher
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"course_info", "course_teacher"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=100, nullable=true)
     * @JMS\Groups(groups={"course_info", "course_teacher"})
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=100, nullable=true)
     * @JMS\Groups(groups={"course_info", "course_teacher"})
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @JMS\Groups(groups={"course_info", "course_teacher"})
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="manager", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info", "course_teacher"})
     */
    private $manager = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_visibility", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info", "course_teacher"})
     */
    private $emailVisibility = false;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseTeachers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Groups(groups={"course_teacher"})
     */
    private $courseInfo;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return CourseTeacher
     */
    public function setId(?string $id): CourseTeacher
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
     * @return CourseTeacher
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
     * @return CourseTeacher
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
     * @return CourseTeacher
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
     * @return CourseTeacher
     */
    public function setManager(bool $manager): CourseTeacher
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailVisibility(): bool
    {
        return $this->emailVisibility;
    }

    /**
     * @param bool $emailVisibility
     * @return CourseTeacher
     */
    public function setEmailVisibility(bool $emailVisibility): CourseTeacher
    {
        $this->emailVisibility = $emailVisibility;

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
     * @param CourseInfo|null $courseInfo
     * @return CourseTeacher
     */
    public function setCourseInfo(?CourseInfo $courseInfo): CourseTeacher
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}
