<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CourseTutoringResource
 *
 * @ORM\Table(name="course_tutoring_resource")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CourseTutoringResourceTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"},
 *     "access_control"="is_granted('ROLE_API_COURSE_TUTORING_RESOURCE')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_COURSE_TUTORING_RESOURCE_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_COURSE_TUTORING_RESOURCE_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_COURSE_TUTORING_RESOURCE_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_COURSE_TUTORING_RESOURCE_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_COURSE_TUTORING_RESOURCE_DELETE')"},
 *     }
 * )
 */
class CourseTutoringResource
{
    /**
     * @var null|string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @Gedmo\Translatable
     */
    private $description = "";

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseTutoringResources")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $courseInfo;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return CourseTutoringResource
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return CourseTutoringResource
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return CourseTutoringResource
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

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
     * @return CourseTutoringResource
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getDescription();
    }

}
