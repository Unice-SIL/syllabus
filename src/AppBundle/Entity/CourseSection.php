<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseSection
 *
 * @ORM\Table(name="course_section", indexes={@ORM\Index(name="fk_course_section_course_info1_idx", columns={"course_info_id"}), @ORM\Index(name="fk_course_section_section_type1_idx", columns={"section_type_id"})})
 * @ORM\Entity
 */
class CourseSection
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
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
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
     * @var \AppBundle\Entity\SectionType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SectionType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_type_id", referencedColumnName="id")
     * })
     */
    private $sectionType;


}
