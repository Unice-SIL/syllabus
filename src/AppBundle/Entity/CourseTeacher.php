<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CourseTeacher
 *
 * @ORM\Table(name="course_teacher")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CourseTeacherTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "user.search_filter"}
 *     })
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
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=100, nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=100, nullable=true)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="manager", type="boolean", nullable=false)
     */
    private $manager = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_visibility", type="boolean", nullable=false)
     */
    private $emailVisibility = false;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseTeachers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
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
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return CourseTeacher
     */
    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return CourseTeacher
     */
    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return CourseTeacher
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function isManager(): ?bool
    {
        return $this->manager;
    }

    /**
     * @param bool $manager
     * @return CourseTeacher
     */
    public function setManager(bool $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailVisibility(): ?bool
    {
        return $this->emailVisibility;
    }

    /**
     * @param bool $emailVisibility
     * @return CourseTeacher
     */
    public function setEmailVisibility(bool $emailVisibility): self
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
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        if($courseInfo !== $this->courseInfo)
        {
            $this->courseInfo = $courseInfo;
            $courseInfo->addCourseTeacher($this);
        }

        return $this;
    }

}
