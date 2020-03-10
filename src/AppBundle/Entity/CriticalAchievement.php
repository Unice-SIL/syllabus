<?php


namespace AppBundle\Entity;

use AppBundle\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CriticalAchievement
 * @package AppBundle\Entity
 * @ORM\Table(name="critical_achievement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\CriticalAchievementDoctrineRepository")
 */
class CriticalAchievement
{
    use Importable;

    /**
     * @var null|string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @OneToMany(targetEntity="CourseCriticalAchievement", mappedBy="criticalAchievement")
     */
    private $courseCriticalAchievements;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="criticalAchievements")
     */
    private $courses;


    /**
     * CriticalAchievement constructor.
     */
    public function __construct() {
        $this->courseCriticalAchievements = new ArrayCollection();
        $this->courses = new ArrayCollection();
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
     * @return CriticalAchievement
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return CriticalAchievement
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return bool
     */
    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     * @return CriticalAchievement
     */
    public function setObsolete(bool $obsolete): CriticalAchievement
    {
        $this->obsolete = $obsolete;
        return $this;
    }

    /**
     * @param $courseCriticalAchievement
     * @return CriticalAchievement
     */
    public function addCourseCriticalAchievement(CourseCriticalAchievement $courseCriticalAchievement): self
    {
        if (!$this->courseCriticalAchievements->contains($courseCriticalAchievement))
        {
            $this->courseCriticalAchievements->add($courseCriticalAchievement);
        }
        return $this;
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @return CriticalAchievement
     */
    public function removeCourseCriticalAchievement(CourseCriticalAchievement $courseCriticalAchievement): self
    {
        if ($this->courseCriticalAchievements->contains($courseCriticalAchievement))
        {
            $this->courseCriticalAchievements->removeElement($courseCriticalAchievement);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCourseCriticalAchievements()
    {
        return $this->courseCriticalAchievements;
    }

    /**
     * @param $courseCriticalAchievements
     * @return CriticalAchievement
     */
    public function setCourseCriticalAchievements($courseCriticalAchievements): CriticalAchievement
    {
        $this->courseCriticalAchievements = $courseCriticalAchievements;
        return $this;
    }

    /**
     * @param Course $course
     * @return CriticalAchievement
     */
    public function addCourse(Course $course): self
    {
        if(!$this->courses->contains($course))
        {
            $this->courses->add($course);
            if($course->getCriticalAchievements() !== $this)
            {
                $course->getCriticalAchievements()->add($this);
            }
        }
        $this->courses->add($course);

        return $this;
    }

    /**
     * @param Course $course
     * @return CriticalAchievement
     */
    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course))
        {
            $this->courses->removeElement($course);
            if ($course->getCriticalAchievements()->contains($this))
            {
                $course->getCriticalAchievements()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    /**
     * @param Collection $courses
     * @return CriticalAchievement
     */
    public function setCourses(Collection $courses): CriticalAchievement
    {
        $this->courses = $courses;
        return $this;
    }

}