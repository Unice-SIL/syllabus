<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CourseInfoField
 *
 * @ORM\Table(name="course_info_field")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CourseInfoFieldTranslation")
 * @ApiResource()
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
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="manually_duplication", type="boolean", nullable=false, options={"default" : 0})
     */
    private $manuallyDuplication = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="automatic_duplication", type="boolean", nullable=false, options={"default" : 0})
     */
    private $automaticDuplication = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="import", type="boolean", nullable=false, options={"default" : 0})
     */
    private $import = 0;

    /**
     * CourseInfoField constructor.
     * @param string $field
     */
    public function __construct(?string $field)
    {
        $this->field = $field;
    }


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

    /**
     * @return bool
     */
    public function getAutomaticDuplication(): bool
    {
        return $this->automaticDuplication;
    }

    /**
     * @param bool $automaticDuplication
     * @return CourseInfoField
     */
    public function setAutomaticDuplication($automaticDuplication): self
    {
        $this->automaticDuplication = $automaticDuplication;

        return $this;
    }

    /**
     * @return bool
     */
    public function isImport()
    {
        return $this->import;
    }

    /**
     * @param bool $import
     */
    public function setImport($import)
    {
        $this->import = $import;
    }
}
