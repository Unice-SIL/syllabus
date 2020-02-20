<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Course
 *
 * @ORM\Table(name="course", uniqueConstraints={@ORM\UniqueConstraint(name="code_UNIQUE", columns={"code"})})
 * @UniqueEntity(fields={"code"}, message="Le cours avec pour code établissement {{ value }} existe déjà", errorPath="code")
 * @ORM\Entity
 */
class Course
{
    use Importable;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"course", "course_info"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=5, nullable=false, options={"fixed"=true})
     * @JMS\Groups(groups={"course", "course_info"})
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false)
     * @JMS\Groups(groups={"course", "course_info"})
     */
    private $code;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="children", cascade={ "persist" })
     * @ORM\JoinTable(name="course_hierarchy",
     *   joinColumns={
     *     @ORM\JoinColumn(name="course_child_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="course_parent_id", referencedColumnName="id")
     *   }
     * )
     */
    private $parents;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="parents")
     */
    private $children;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CourseInfo", mappedBy="course", cascade={ "persist" })
     * @ORM\OrderBy({"year" = "ASC"})
     */
    private $courseInfos;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="CriticalAchievement", inversedBy="courses")
     */
    private $criticalAchievements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->courseInfos = new ArrayCollection();
        $this->criticalAchievements = new ArrayCollection();
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
     * @return Course
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Course
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    /**
     * @param Collection $parents
     * @return Course
     */
    public function setParents(Collection $parents): self
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function addParent(Course $course): self
    {
        if(!$this->parents->contains($course))
        {
            $this->parents->add($course);
            if(!$course->getChildren()->contains($this))
            {
                $course->addChild($this);
            }
        }

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function removeParent(Course $course): self
    {
        if($this->parents->contains($course))
        {
            $this->parents->removeElement($course);
            if($course->getChildren()->contains($this))
            {
                $course->removeChild($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Collection $children
     * @return Course
     */
    public function setChildren(Collection $children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function addChild(Course $course): self
    {

        if(!$this->children->contains($course))
        {
            $this->children->add($course);
            if(!$course->getParents()->contains($this))
            {
                $course->addParent($this);
            }
        }

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function removeChild(Course $course): self
    {
        if($this->children->contains($course))
        {
            $this->children->removeElement($course);
            if($course->getParents()->contains($this))
            {
                $course->removeParent($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseInfos(): Collection
    {
        return $this->courseInfos;
    }

    /**
     * @param Collection $courseInfos
     * @return Course
     */
    public function setCourseInfos(Collection $courseInfos): self
    {
        $this->courseInfos = $courseInfos;

        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Course
     */
    public function addCourseInfo(CourseInfo $courseInfo): self
    {
        if(!$this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->add($courseInfo);
            if($courseInfo->getCourse() !== $this)
            {
                $courseInfo->setCourse($this);
            }
        }
        $this->courseInfos->add($courseInfo);

        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Course
     */
    public function removeCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfos->removeElement($courseInfo);
        // Do not set course $courseInfo->course to null !

        return $this;
    }

    /**
     * @param CriticalAchievement $criticalAchievement
     * @return Course
     */
    public function addCriticalAchievement(CriticalAchievement $criticalAchievement): self
    {
        if(!$this->criticalAchievements->contains($criticalAchievement))
        {
            $this->criticalAchievements->add($criticalAchievement);
            if($criticalAchievement->getCourses() !== $this)
            {
                $criticalAchievement->getCourses($this);
            }
        }
        return $this;
    }

    /**
     * @param CriticalAchievement $criticalAchievement
     * @return Course
     */
    public function removeCriticalAchievement(CriticalAchievement $criticalAchievement): self
    {
        if ($this->criticalAchievements->contains($criticalAchievement))
        {
            $this->criticalAchievements->removeElement($criticalAchievement);
            if ($criticalAchievement->getActivities()->contains($this))
            {
                $criticalAchievement->getActivities()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCriticalAchievements(): Collection
    {
        return $this->criticalAchievements;
    }

    /**
     * @param Collection $criticalAchievements
     * @return Course
     */
    public function setCriticalAchievements(Collection $criticalAchievements): Course
    {
        $this->criticalAchievements = $criticalAchievements;
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getCode();
    }
}
