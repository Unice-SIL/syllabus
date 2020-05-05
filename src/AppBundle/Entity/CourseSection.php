<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CourseSection
 *
 * @ORM\Table(name="course_section")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CourseSectionTranslation")
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
     * @JMS\Groups(groups={"default", "course_section"})
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=true)
     * @JMS\Groups(groups={"default", "course_section"})
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var null|string
     *
     * @ORM\Column(name="url_course", type="string", length=200, nullable=true)
     * @JMS\Groups(groups={"default", "course_section"})
     *
     */
    private $urlCourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"default", "course_section"})
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @JMS\Groups(groups={"default", "course_section"})
     */
    private $position = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseSections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Groups(groups={"course_section"})
     */
    private $courseInfo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseSectionActivity", mappedBy="courseSection", cascade={ "persist", "remove", "merge" }, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @JMS\Groups(groups={"course_info", "course_section"})
     */
    private $courseSectionActivities;

    /**
     * CourseSection constructor.
     */
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     * @return CourseSection
     */
    public function setTitle($title): self
    {
        $this->title = $title;

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
     * @return CourseSection
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
     * @return CourseSection
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrlCourse(): ?string
    {
        return $this->urlCourse;
    }

    /**
     * @param $urlCourse
     * @return CourseSection
     */
    public function setUrlCourse($urlCourse): self
    {
        $this->urlCourse = $urlCourse;

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
            if($courseSectionActivity->getCourseSection() !== $this)
            {
                $courseSectionActivity->setCourseSection($this);
            }
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

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     *
     */
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
