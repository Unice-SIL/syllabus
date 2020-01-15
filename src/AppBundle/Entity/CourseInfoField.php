<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseInfoField
 *
 * @ORM\Table(name="course_info_field")
 * @ORM\Entity
 */
class CourseInfoField
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=150, nullable=false, unique=true)
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=150, nullable=false, unique=true)
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="manually_duplication", type="boolean", nullable=false, options={"default" : 0})
     */
    private $manuallyDuplication = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return bool
     */
    public function getManuallyDuplication(): bool
    {
        return $this->manuallyDuplication;
    }

    /**
     * @param $manuallyDuplication
     * @return $this
     */
    public function setManuallyDuplication($manuallyDuplication): self
    {
        $this->manuallyDuplication = $manuallyDuplication;

        return $this;
    }


}
