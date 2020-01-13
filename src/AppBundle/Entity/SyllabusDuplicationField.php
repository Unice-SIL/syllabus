<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;

/**
 * SyllabusDuplicationField
 *
 * @ORM\Table(name="syllabus_duplication_field")
 * @ORM\Entity
 */
class SyllabusDuplicationField
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
     * @ORM\Column(name="import", type="boolean", nullable=false, options={"default" : 0})
     */
    private $import = 0;

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
    public function getImport(): bool
    {
        return $this->import;
    }

    /**
     * @param bool $import
     * @return $this
     */
    public function setImport(bool $import): self
    {
        $this->import = $import;

        return $this;
    }

}
