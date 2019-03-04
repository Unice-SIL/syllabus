<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoursePrerequisite
 *
 * @ORM\Table(name="course_prerequisite", indexes={@ORM\Index(name="fk_course_prerequisite_course_info1_idx", columns={"course_info_id"})})
 * @ORM\Entity
 */
class CoursePrerequisite
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
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


}
