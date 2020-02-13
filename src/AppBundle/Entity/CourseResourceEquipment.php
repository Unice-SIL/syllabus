<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * CourseResourceEquipment
 *
 * @ORM\Table(name="course_resource_equipment")
 * @ORM\Entity
 */
class CourseResourceEquipment
{
    /**
     * @var null|string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"default", "course_resource_equipment"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @JMS\Groups(groups={"default", "course_resource_equipment"})
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @JMS\Groups(groups={"default", "course_resource_equipment"})
     */
    private $position = 0;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="courseResourceEquipments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Groups(groups={"course_resource_equipment"})
     */
    private $courseInfo;

    /**
     * @var \AppBundle\Entity\Equipment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Groups(groups={"course_info", "course_resource_equipment"})
     */
    private $equipment;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return CourseResourceEquipment
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
     * @return CourseResourceEquipment
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
     * @return CourseResourceEquipment
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
     * @return CourseResourceEquipment
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @return Equipment
     */
    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups(groups={"api"})
     * @JMS\SerializedName("equipment")
     *
     * @return Equipment|null
     */
    public function getEquipmentApi()
    {
        return $this->getEquipment()->getId();
    }

    /**
     * @param Equipment $equipment
     * @return CourseResourceEquipment
     */
    public function setEquipment(Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

}
