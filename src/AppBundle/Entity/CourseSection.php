<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseSection
 *
 * @ORM\Table(name="course_section", indexes={@ORM\Index(name="fk_course_section_course_info1_idx", columns={"course_info_id"}), @ORM\Index(name="fk_course_section_section_type1_idx", columns={"section_type_id"})})
 * @ORM\Entity
 */
class CourseSection
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
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $order = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseSections", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id")
     * })
     */
    private $courseInfo;

    /**
     * @var \AppBundle\Entity\SectionType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SectionType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_type_id", referencedColumnName="id")
     * })
     */
    private $sectionType;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseSection
     */
    public function setId(string $id): CourseSection
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     * @return CourseSection
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return CourseSection
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
     * @return CourseSection
     */
    public function setOrder(int $order): CourseSection
    {
        $this->order = $order;

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
     * @return CourseSection
     */
    public function setCourseInfo(CourseInfo $courseInfo): CourseSection
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return SectionType
     */
    public function getSectionType(): SectionType
    {
        return $this->sectionType;
    }

    /**
     * @param SectionType $sectionType
     * @return CourseSection
     */
    public function setSectionType(SectionType $sectionType): CourseSection
    {
        $this->sectionType = $sectionType;

        return $this;
    }


}
