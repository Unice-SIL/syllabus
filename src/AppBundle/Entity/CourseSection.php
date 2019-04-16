<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CourseSection
 *
 * @ORM\Table(name="course_section", indexes={@ORM\Index(name="fk_course_section_course_info1_idx", columns={"course_info_id"})})
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
     * @var null|string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseSectionActivity", mappedBy="courseSection", cascade={ "persist", "remove" })
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $courseSectionActivities;

    public function __construct()
    {
        $this->courseSectionActivities = new ArrayCollection();
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
     * @return Collection
     */
    public function getCourseSectionActivities(): Collection
    {
        return $this->courseSectionActivities;
    }

    /**
     * @param Collection $courseSectionActivities
     * @return CourseSection
     */
    public function setCourseSectionActivities(Collection $courseSectionActivities): CourseSection
    {
        $this->courseSectionActivities = $courseSectionActivities;

        return $this;
    }

    /**
     * @param CourseSectionActivity $courseSectionActivity
     * @return CourseSection
     */
    public function addCourseSectionActivity(CourseSectionActivity $courseSectionActivity): CourseSection
    {
        $this->courseSectionActivities->add($courseSectionActivity);

        return $this;
    }

    /**
     * @param CourseSectionActivity $courseSectionActivity
     * @return CourseSection
     */
    public function removeCourseSectionActivity(CourseSectionActivity $courseSectionActivity): CourseSection
    {
        $this->courseSectionActivities->removeElement($courseSectionActivity);

        return $this;
    }

}
