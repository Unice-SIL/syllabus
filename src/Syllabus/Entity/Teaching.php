<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Teaching
 *
 * @ORM\Table(name="teaching")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\TeachingDoctrineRepository")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"},
 *     "access_control"="is_granted('ROLE_API_TEACHING')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_TEACHING_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_TEACHING_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_TEACHING_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_TEACHING_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_TEACHING_DELETE')"},
 *     }
 * )
 */
class Teaching
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=65)
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="hourlyVolume", type="float")
     * @Assert\NotNull()
     */
    private $hourlyVolume;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=15)
     * @Assert\NotNull()
     */
    private $mode;

    /**
     * @var CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="teachings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $courseInfo;

    /**
     * Teaching constructor.
     * @param string $type
     * @param float $hourlyVolume
     * @param string $mode
     */
    public function __construct(string $type  = null, float $hourlyVolume = null, string $mode = null)
    {
        $this->type = $type;
        $this->hourlyVolume = $hourlyVolume;
        $this->mode = $mode;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId(?string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Teaching
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set hourlyVolume.
     *
     * @param float $hourlyVolume
     *
     * @return Teaching
     */
    public function setHourlyVolume($hourlyVolume)
    {
        $this->hourlyVolume = $hourlyVolume;

        return $this;
    }

    /**
     * Get hourlyVolume.
     *
     * @return float
     */
    public function getHourlyVolume()
    {
        return $this->hourlyVolume;
    }

    /**
     * Set mode.
     *
     * @param string $mode
     *
     * @return Teaching
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode.
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return CourseInfo
     */
    public function getCourseInfo(): ?CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param $courseInfo
     * @return Teaching
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }
}
