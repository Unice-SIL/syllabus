<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Structure
 *
 * @ORM\Table(name="structure")
 * @ORM\Entity
 */
class Structure
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
     * @ORM\Column(name="etb_code", type="string", length=45, nullable=false)
     */
    private $etbCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=true)
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="campus", type="string", length=100, nullable=true)
     */
    private $campus;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = '0';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Structure
     */
    public function setId(string $id): Structure
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getEtbCode(): string
    {
        return $this->etbCode;
    }

    /**
     * @param string $etbCode
     * @return Structure
     */
    public function setEtbCode(string $etbCode): Structure
    {
        $this->etbCode = $etbCode;

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
     * @return Structure
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param null|string $campus
     * @return Structure
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;

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
     * @return Structure
     */
    public function setObsolete(bool $obsolete): Structure
    {
        $this->obsolete = $obsolete;

        return $this;
    }

}
