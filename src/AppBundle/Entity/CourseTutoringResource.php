<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseTutoringResource
 *
 * @ORM\Table(name="course_tutoring_resource", indexes={@ORM\Index(name="fk_course_tutoring_resources_course_info1_idx", columns={"course_info_id"})})
 * @ORM\Entity
 */
class CourseTutoringResource
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", reversedBy="courseTutoringResources", cascade={ "persist" })
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id")
     * })
     */
    private $courseInfo;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseTutoringResource
     */
    public function setId(string $id): CourseTutoringResource
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CourseTutoringResource
     */
    public function setDescription(string $description): CourseTutoringResource
    {
        $this->description = $description;

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
     * @return CourseTutoringResource
     */
    public function setCourseInfo(CourseInfo $courseInfo): CourseTutoringResource
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    
}
