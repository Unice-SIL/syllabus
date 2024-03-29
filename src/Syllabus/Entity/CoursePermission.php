<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Syllabus\Constant\Permission;
use App\Syllabus\Traits\Importable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CoursePermission
 *
 * @ORM\Table(name="course_permission")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"user", "courseInfo", "permission"},
 *     errorPath="user",
 *     message="Cet utilisateur possède déjà une permission identique."
 * )
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CoursePermissionTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"},
 *     "access_control"="is_granted('ROLE_API_COURSE_PERMISSION')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_COURSE_PERMISSION_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_COURSE_PERMISSION_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_COURSE_PERMISSION_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_COURSE_PERMISSION_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_COURSE_PERMISSION_DELETE')"},
 *     }
 * )
 */
class CoursePermission
{

    use Importable;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Syllabus\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="permission", type="string", length=45, nullable=false, options={"fixed"=true})
     * @Assert\NotBlank()
     */
    private $permission = Permission::READ;

    /**
     * @var CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\CourseInfo", inversedBy="coursePermissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private $courseInfo;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return CoursePermission
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPermission(): ?string
    {
        return $this->permission;
    }

    /**
     * @param null|string $permission
     * @return CoursePermission
     */
    public function setPermission($permission): self
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
     * @param CourseInfo|null $courseInfo
     * @return CoursePermission
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
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
     * @return null|string
     */
    public function getUserApi(): ?string
    {
        return $this->getUser()->getId();
    }

    /**
     * @param User $user
     * @return CoursePermission
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
