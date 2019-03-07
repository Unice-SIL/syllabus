<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseSectionActivity
 *
 * @ORM\Table(name="course_section_activity", indexes={@ORM\Index(name="fk_course_section_activity_course_section1_idx", columns={"course_section_id"}), @ORM\Index(name="fk_course_section_activity_activity1_idx", columns={"activity_id"})})
 * @ORM\Entity
 */
class CourseSectionActivity
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $order = 0;

    /**
     * @var \AppBundle\Entity\Activity
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Activity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     * })
     */
    private $activity;

    /**
     * @var \AppBundle\Entity\CourseSection
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseSection", inversedBy="courseSectionActivities",)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_section_id", referencedColumnName="id")
     * })
     */
    private $courseSection;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseSectionActivity
     */
    public function setId(string $id): CourseSectionActivity
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
     * @return CourseSectionActivity
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
     * @return CourseSectionActivity
     */
    public function setOrder(int $order): CourseSectionActivity
    {
        $this->order = $order;

        return $this;
    }


    /**
     * @return Activity
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity $activity
     * @return CourseSectionActivity
     */
    public function setActivity(Activity $activity): CourseSectionActivity
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return CourseSection
     */
    public function getCourseSection(): CourseSection
    {
        return $this->courseSection;
    }

    /**
     * @param CourseSection $courseSection
     * @return CourseSectionActivity
     */
    public function setCourseSection(CourseSection $courseSection): CourseSectionActivity
    {
        $this->courseSection = $courseSection;

        return $this;
    }

}
