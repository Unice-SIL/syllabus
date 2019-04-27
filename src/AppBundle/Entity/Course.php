<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course", uniqueConstraints={@ORM\UniqueConstraint(name="etb_id_UNIQUE", columns={"etb_id"})})
 * @ORM\Entity
 */
class Course
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
     * @ORM\Column(name="type", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="etb_id", type="string", length=36, nullable=false, options={"fixed"=true})
     */
    private $etbId;

    /**
     * @var \Doctrine\Common\Collections\Collection
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
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="parents")
     */
    private $children;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CourseInfo", mappedBy="course", cascade={ "persist" })
     */
    private $courseInfos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->courseInfos = new ArrayCollection();
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
     * @return Course
     */
    public function setId(string $id): Course
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Course
     */
    public function setType(string $type): Course
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getEtbId(): string
    {
        return $this->etbId;
    }

    /**
     * @param string $etbId
     * @return Course
     */
    public function setEtbId(string $etbId): Course
    {
        $this->etbId = $etbId;

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
    public function setParents(Collection $parents): Course
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function addParent(Course $course): Course
    {
        $this->parents->add($course);

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function removeParent(Course $course): Course
    {
        $this->parents->removeElement($course);

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
    public function setChildren(Collection $children): Course
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function addChild(Course $course): Course
    {
        $this->children->add($course);

        return $this;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function removeChild(Course $course): Course
    {
        $this->children->removeElement($course);

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
    public function setCourseInfos(Collection $courseInfos): Course
    {
        $this->courseInfos = $courseInfos;

        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Course
     */
    public function addCourseInfo(CourseInfo $courseInfo): Course
    {
        $this->courseInfos->add($courseInfo);

        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Course
     */
    public function removeCourseInfo(CourseInfo $courseInfo): Course
    {
        $this->courseInfos->removeElement($courseInfo);

        return $this;
    }

}
