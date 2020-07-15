<?php


namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use AppBundle\Traits\Importable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class CourseCriticalAchievement
 * @ORM\Table(name="course_critical_achievement")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CourseCriticalAchievementTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"}
 *     })
 */
class CourseCriticalAchievement
{
    use Importable;

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
     * @var string|null
     *
     * @ORM\Column(name="rule", type="text", length=50, nullable=false)
     * @Gedmo\Translatable
     */
    private $rule;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score = 0;

    /**
     * @OneToMany(targetEntity="LearningAchievement", mappedBy="courseCriticalAchievement", cascade={"persist"}, orphanRemoval=true)
     */
    private $learningAchievements;

    /**
     * @ManyToOne(targetEntity="CriticalAchievement", inversedBy="courseCriticalAchievements", cascade={"persist"})
     * @JoinColumn(name="critical_achievement_course_critical_achievement", referencedColumnName="id")
     */
    private $criticalAchievement;

    /**
     * @ManyToOne(targetEntity="CourseInfo", inversedBy="courseCriticalAchievements", cascade={"persist"})
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
     * @return string
     */
    public function getRule(): ?string
    {
        return $this->rule;
    }

    /**
     * @param string $rule
     * @return CourseCriticalAchievement
     */
    public function setRule(string $rule): CourseCriticalAchievement
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
    public function getCriticalAchievement()
    {
        return $this->criticalAchievement;
    }

    /**
     * @param $criticalAchievement
     */
    public function setCriticalAchievement($criticalAchievement): void
    {
        $this->criticalAchievement = $criticalAchievement;
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