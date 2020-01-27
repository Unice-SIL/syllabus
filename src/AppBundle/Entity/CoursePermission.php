<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CoursePermission
 *
 * @ORM\Table(name="course_permission")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"user", "courseInfo", "permission"},
 *     errorPath="user",
 *     message="Cet utilisateur a déjà ce droit."
 * )
 */
class CoursePermission
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="permission", type="string", length=45, nullable=false, options={"fixed"=true})
     * @Assert\NotBlank()
     */
    private $permission = 'READ';

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="coursePermissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private $courseInfo;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={ "persist" })
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CoursePermission
     */
    public function setId(string $id): CoursePermission
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param null|string $permission
     * @return CoursePermission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return CourseInfo
     */
    public function getCourseInfo(): ?CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return CoursePermission
     */
    public function setCourseInfo(CourseInfo $courseInfo): CoursePermission
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return CoursePermission
     */
    public function setUser(User $user): CoursePermission
    {
        $this->user = $user;

        return $this;
    }

}
