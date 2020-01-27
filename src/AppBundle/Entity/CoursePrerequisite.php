<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoursePrerequisite
 *
 * @ORM\Table(name="course_prerequisite", indexes={@ORM\Index(name="fk_course_prerequisite_course_info1_idx", columns={"course_info_id"})})
 * @ORM\Entity
 */
class CoursePrerequisite
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
     */
    private $description = "";

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $order = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="coursePrerequisites")
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
     * @return CoursePrerequisite
     */
    public function setId(?string $id): CoursePrerequisite
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return CoursePrerequisite
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return CoursePrerequisite
     */
    public function setOrder(int $order): CoursePrerequisite
    {
        $this->order = $order;

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
     * @return CoursePrerequisite
     */
    public function setCourseInfo(?CourseInfo $courseInfo): CoursePrerequisite
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}
