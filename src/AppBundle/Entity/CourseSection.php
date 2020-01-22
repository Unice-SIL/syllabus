<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

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
     * @ORM\Column(name="title", type="string", length=200, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseSections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $courseInfo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseSectionActivity", mappedBy="courseSection", cascade={ "persist", "remove" }, orphanRemoval=true)
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
     * @param $courseInfo
     * @return CourseSection
     */
    public function setCourseInfo($courseInfo): CourseSection
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
        if ($this->courseSectionActivities->contains($courseSectionActivity))
        {
            $this->courseSectionActivities->removeElement($courseSectionActivity);
            if ($courseSectionActivity->getCourseSection() === $this)
            {
                $courseSectionActivity->setCourseSection(null);
            }
        }
        return $this;
    }

    public function __clone()
    {
        $this->courseSectionActivities = clone $this->courseSectionActivities;
        /**
         * @var  $k
         * @var CourseSectionActivity $courseSectionActivity
         */
        foreach ($this->courseSectionActivities as $k => $courseSectionActivity){
            $courseSectionActivity = clone $courseSectionActivity;
            $courseSectionActivity->setId(Uuid::uuid4())
                ->setCourseSection($this);
            $this->courseSectionActivities->offsetSet($k, $courseSectionActivity);
        }
    }

}
