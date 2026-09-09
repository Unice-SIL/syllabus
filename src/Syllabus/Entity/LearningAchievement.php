<?php


namespace App\Syllabus\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Syllabus\Traits\Importable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @package App\Syllabus\Entity
 * @ORM\Table(name="learning_achievement")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\LearningAchievementTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"},
 *     "access_control"="is_granted('ROLE_API_LEARNING_ACHIEVEMENT')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_LEARNING_ACHIEVEMENT_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_LEARNING_ACHIEVEMENT_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_LEARNING_ACHIEVEMENT_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_LEARNING_ACHIEVEMENT_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_LEARNING_ACHIEVEMENT_DELETE')"},
 *     }
 * )
 */
class LearningAchievement
{
    use Importable;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Syllabus\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score = 0;

    /**
     * @ManyToOne(targetEntity="CourseCriticalAchievement", inversedBy="learningAchievements")
     * @JoinColumn(name="course_critical_achievement_learning_achievement", referencedColumnName="id")
     */
    private $courseCriticalAchievement;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return LearningAchievement
     */
    public function setId(string $id): LearningAchievement
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return LearningAchievement
     */
    public function setDescription(string $description): LearningAchievement
    {
        $this->description = $description;
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
     * @param $courseCriticalAchievement
     * @return LearningAchievement
     */
    public function setCourseCriticalAchievement($courseCriticalAchievement): LearningAchievement
    {
        $this->courseCriticalAchievement = $courseCriticalAchievement;
        return $this;
    }

    /**
     * @return int
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}