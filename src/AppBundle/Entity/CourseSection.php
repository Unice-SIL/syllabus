<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use JMS\Serializer\Annotation as JMS;

/**
 * CourseSection
 *
 * @ORM\Table(name="course_section")
 * @ORM\Entity
 */
class CourseSection
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"api"})
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=true)
     * @JMS\Groups(groups={"api"})
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"api"})
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @JMS\Groups(groups={"api"})
     */
    private $position = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseSections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     *
     */
    private $courseInfo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseSectionActivity", mappedBy="courseSection", cascade={ "persist", "remove", "merge" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @JMS\Groups(groups={"api"})
     */
    private $courseSectionActivities;

    public function __construct()
    {
        $this->courseSectionActivities = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseSection
     */
    public function setId(?string $id): self
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
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return CourseSection
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;

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
     * @param $courseInfo
     * @return CourseSection
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
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
    public function setCourseSectionActivities(Collection $courseSectionActivities): self
    {
        $this->courseSectionActivities = $courseSectionActivities;

        return $this;
    }

    /**
     * @param CourseSectionActivity $courseSectionActivity
     * @return CourseSection
     */
    public function addCourseSectionActivity(CourseSectionActivity $courseSectionActivity): self
    {
        if(!$this->courseSectionActivities->contains($courseSectionActivity))
        {
            $this->courseSectionActivities->add($courseSectionActivity);
            $courseSectionActivity->setCourseSection($this);
        }

        return $this;
    }

    /**
     * @param CourseSectionActivity $courseSectionActivity
     * @return CourseSection
     */
    public function removeCourseSectionActivity(CourseSectionActivity $courseSectionActivity): self
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
