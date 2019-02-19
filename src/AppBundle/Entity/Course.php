<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course", uniqueConstraints={@ORM\UniqueConstraint(name="etb_id_UNIQUE", columns={"etb_id"})})
 * @ORM\Entity
 */
class Course
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="etb_id", type="string", length=36, nullable=false, options={"fixed"=true})
     */
    private $etbId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Course", inversedBy="courseChild")
     * @ORM\JoinTable(name="course_hierarchy",
     *   joinColumns={
     *     @ORM\JoinColumn(name="course_child_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="course_parent_id", referencedColumnName="id")
     *   }
     * )
     */
    private $courseParent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courseParent = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
