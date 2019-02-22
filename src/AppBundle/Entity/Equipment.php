<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity
 */
class Equipment
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
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="label_visibility", type="boolean", nullable=false)
     */
    private $labelVisibility = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="icon", type="text", length=65535, nullable=true)
     */
    private $icon;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $ord = 0;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Equipment
     */
    public function setId(string $id): Equipment
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param null|string $label
     * @return Equipment
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLabelVisibility(): bool
    {
        return $this->labelVisibility;
    }

    /**
     * @param bool $labelVisibility
     * @return Equipment
     */
    public function setLabelVisibility(bool $labelVisibility): Equipment
    {
        $this->labelVisibility = $labelVisibility;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param null|string $icon
     * @return Equipment
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return bool
     */
    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     * @return Equipment
     */
    public function setObsolete(bool $obsolete): Equipment
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrd(): int
    {
        return $this->ord;
    }

    /**
     * @param int $ord
     * @return Equipment
     */
    public function setOrd(int $ord): Equipment
    {
        $this->ord = $ord;

        return $this;
    }


}
