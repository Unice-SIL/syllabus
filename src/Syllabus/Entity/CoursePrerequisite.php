<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CoursePrerequisite
 *
 * @ORM\Table(name="course_prerequisite")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CoursePrerequisiteTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"},
 *     "access_control"="is_granted('ROLE_API_COURSE_PREREQUISITE')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_COURSE_PREREQUISITE_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_COURSE_PREREQUISITE_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_COURSE_PREREQUISITE_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_COURSE_PREREQUISITE_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_COURSE_PREREQUISITE_DELETE')"},
 *     }
 * )
 */
class CoursePrerequisite
{
    /**
     * @var null|string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Syllabus\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @Gedmo\Translatable
     */
    private $description = "";

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position = 0;

    /**
     * @var CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\CourseInfo", inversedBy="coursePrerequisites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $courseInfo;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_course_associated", type="boolean", nullable=false)
     */
    private $isCourseAssociated = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="coursePrerequisites")
     *
     */
    private $courses;

    /**
     * CoursePrerequisite constructor.
     */
    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return CoursePrerequisite
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

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
     * @return CoursePrerequisite
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
     * @return CoursePrerequisite
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return CourseInfo|null
     */
    public function getCourseInfo(): ?CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo|null $courseInfo
     * @return CoursePrerequisite
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCourseAssociated(): bool
    {
        return $this->isCourseAssociated;
    }

    /**
     * @param bool $isCourseAssociated
     * @return CoursePrerequisite
     */
    public function setIsCourseAssociated(bool $isCourseAssociated): CoursePrerequisite
    {
        $this->isCourseAssociated = $isCourseAssociated;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param Collection|null $courses
     * @return CoursePrerequisite
     */
    public function setCourses(?Collection $courses): CoursePrerequisite
    {
        $this->courses = $courses;
        return $this;
    }

    /**
     * @param Course $course
     * @return CoursePrerequisite
     */
    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course))
        {
            $this->courses->add($course);
            if (!$course->getCoursePrerequisites()->contains($this))
            {
                $course->getCoursePrerequisites()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Course $course
     * @return CoursePrerequisite
     */
    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course))
        {
            $this->courses->removeElement($course);
            if ($course->getCoursePrerequisites()->contains($this))
            {
                $course->getCoursePrerequisites()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getDescription();
    }

    /**
     *
     */
    public function __clone()
    {
        /** @var Course $course */
        foreach ($this->courses as $course)
        {
            $course->addCoursePrerequisite($this);
        }
    }

}
