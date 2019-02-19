<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseSectionActivity
 *
 * @ORM\Table(name="course_section_activity", indexes={@ORM\Index(name="fk_course_section_activity_course_section1_idx", columns={"course_section_id"}), @ORM\Index(name="fk_course_section_activity_activity1_idx", columns={"activity_id"})})
 * @ORM\Entity
 */
class CourseSectionActivity
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    private $order = '0';

    /**
     * @var \AppBundle\Entity\Activity
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Activity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     * })
     */
    private $activity;

    /**
     * @var \AppBundle\Entity\CourseSection
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CourseSection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_section_id", referencedColumnName="id")
     * })
     */
    private $courseSection;


}
