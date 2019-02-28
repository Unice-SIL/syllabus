<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permission
 *
 * @ORM\Table(name="permission", indexes={@ORM\Index(name="fk_permission_course_info1_idx", columns={"course_info_id"}), @ORM\Index(name="fk_permission_user1_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class Permission
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
     */
    private $permission = 'READ';

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id")
     * })
     */
    private $courseInfo;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
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
     * @return Permission
     */
    public function setId(string $id): Permission
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
     * @return Permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

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
     * @return Permission
     */
    public function setCourseInfo(CourseInfo $courseInfo): Permission
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Permission
     */
    public function setUser(User $user): Permission
    {
        $this->user = $user;

        return $this;
    }



}
