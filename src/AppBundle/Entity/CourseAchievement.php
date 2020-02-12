<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Ramsey\Uuid\UuidInterface;

/**
 * CourseAchievement
 *
 * @ORM\Table(name="course_achievement")
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
     * @JMS\Groups(groups={"course_achievement", "course_info"})
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @JMS\Groups(groups={"course_achievement", "course_info"})
     */
    private $description = "";

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     * @JMS\Groups(groups={"course_achievement", "course_info"})
     */
    private $order = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseAchievements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Groups(groups={"course_achievement"})
     */
    private $courseInfo;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return CourseAchievement
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
     * @return CourseAchievement
     */
    public function setDescription($description): self
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
    public function setOrder(int $order): self
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
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

}
