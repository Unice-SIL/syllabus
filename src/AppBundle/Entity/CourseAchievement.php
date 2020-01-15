<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * CourseAchievement
 *
 * @ORM\Table(name="course_achievement", indexes={@ORM\Index(name="fk_course_achievement_course_info1_idx", columns={"course_info_id"})})
 * @ORM\Entity
 */
class CourseAchievement
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description = "";

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $order = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseAchievements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $courseInfo;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CourseAchievement
     */
    public function setId(string $id): CourseAchievement
    {
        $this->id = $id;

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
     * @return CourseAchievement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return CourseAchievement
     */
    public function setOrder(int $order): CourseAchievement
    {
        $this->order = $order;

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
     * @return CourseAchievement
     */
    public function setCourseInfo(?CourseInfo $courseInfo): CourseAchievement
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}
