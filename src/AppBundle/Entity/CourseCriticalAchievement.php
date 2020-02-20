<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Class CourseCriticalAchievement
 * @ORM\Table(name="course_critical_achievement")
 * @ORM\Entity
 */
class CourseCriticalAchievement
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @ORM\Column(name="rule", type="integer")
     */
    private $rule = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score = 0;

    /**
     * @OneToMany(targetEntity="LearningAchievement", mappedBy="courseCriticalAchievement")
     */
    private $learningAchievements;

    /**
     * @ManyToOne(targetEntity="CriticalAchievement", inversedBy="courseCriticalAchievements")
     * @JoinColumn(name="critical_achievement_course_critical_achievement", referencedColumnName="id")
     */
    private $courseCriticalAchievement;

    /**
     * @ManyToOne(targetEntity="CourseInfo", inversedBy="courseCriticalAchievements")
     * @JoinColumn(name="course_info_course_critical_achievement", referencedColumnName="id")
     */
    private $courseInfo;

    /**
     * CourseCriticalAchievement constructor.
     */
    public function __construct() {
        $this->learningAchievements = new ArrayCollection();
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
     * @return CourseCriticalAchievement
     */
    public function setId(string $id): CourseCriticalAchievement
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getRule(): int
    {
        return $this->rule;
    }

    /**
     * @param int $rule
     * @return CourseCriticalAchievement
     */
    public function setRule(int $rule): CourseCriticalAchievement
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return CourseCriticalAchievement
     */
    public function setScore(int $score): CourseCriticalAchievement
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @param LearningAchievement $learningAchievement
     * @return CourseCriticalAchievement
     */
    public function addLearningAchievement(LearningAchievement $learningAchievement): self
    {
        if (!$this->learningAchievements->contains($learningAchievement))
        {
            $this->learningAchievements->add($learningAchievement);
        }
        return $this;
    }

    /**
     * @param LearningAchievement $learningAchievement
     * @return CourseCriticalAchievement
     */
    public function removeLearningAchievement(LearningAchievement $learningAchievement): self
    {
        if ($this->learningAchievements->contains($learningAchievement))
        {
            $this->learningAchievements->removeElement($learningAchievement);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLearningAchievements()
    {
        return $this->learningAchievements;
    }

    /**
     * @param $learningAchievements
     * @return CourseCriticalAchievement
     */
    public function setLearningAchievements($learningAchievements): CourseCriticalAchievement
    {
        $this->learningAchievements = $learningAchievements;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCourseCriticalAchievement()
    {
        return $this->courseCriticalAchievement;
    }

    /**
     * @param mixed $courseCriticalAchievement
     */
    public function setCourseCriticalAchievement($courseCriticalAchievement): void
    {
        $this->courseCriticalAchievement = $courseCriticalAchievement;
    }

    /**
     * @return mixed
     */
    public function getCourseInfo()
    {
        return $this->courseInfo;
    }

    /**
     * @param $courseInfo
     * @return CourseCriticalAchievement
     */
    public function setCourseInfo($courseInfo): CourseCriticalAchievement
    {
        $this->courseInfo = $courseInfo;
        return $this;
    }

}