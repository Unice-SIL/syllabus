<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseResourceEquipment
 *
 * @ORM\Table(name="course_resource_equipment", indexes={@ORM\Index(name="fk_course_resource_equipment_course_info1_idx", columns={"course_info_id"}), @ORM\Index(name="fk_course_resource_equipment_equipment1_idx", columns={"equipment_id"})})
 * @ORM\Entity
 */
class CourseResourceEquipment
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \AppBundle\Entity\CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseInfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id")
     * })
     */
    private $courseInfo;

    /**
     * @var \AppBundle\Entity\Equipment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     * })
     */
    private $equipment;


}
