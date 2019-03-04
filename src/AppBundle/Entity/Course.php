<?php

namespace AppBundle\Entity;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Course", inversedBy="courseChild")
     * @ORM\JoinTable(name="course_hierarchy",
     *   joinColumns={
     *     @ORM\JoinColumn(name="course_child_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="course_parent_id", referencedColumnName="id")
     *   }
     * )
     */
    private $courseParent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Course", mappedBy="courseParent")
     */
    private $courseChild;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courseParent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->courseChild = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseParent(): \Doctrine\Common\Collections\Collection
    {
        return $this->courseParent;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $courseParent
     * @return Course
     */
    public function setCourseParent(\Doctrine\Common\Collections\Collection $courseParent): Course
    {
        $this->courseParent = $courseParent;

        return $this;
    }

    /**
     * @param Course $courseParent
     * @return Course
     */
    public function addCourseParent(Course $courseParent): Course
    {
        $this->courseParent->add($courseParent);

        return $this;
    }

    /**
     * @param Course $courseParent
     * @return Course
     */
    public function removeCourseParent(Course $courseParent): Course
    {
        $this->courseParent->removeElement($courseParent);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseChild(): \Doctrine\Common\Collections\Collection
    {
        return $this->courseChild;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $courseChild
     * @return Course
     */
    public function setCourseChild(\Doctrine\Common\Collections\Collection $courseChild): Course
    {
        $this->courseChild = $courseChild;

        return $this;
    }

    /**
     * @param Course $courseCild
     * @return Course
     */
    public function addCourseChild(Course $courseCild): Course
    {
        $this->courseChild->add($courseCild);

        return $this;
    }

    /**
     * @param Course $courseChild
     * @return Course
     */
    public function removeCourseChild(Course $courseChild): Course
    {
        $this->courseChild->removeElement($courseChild);

        return $this;
    }

}
