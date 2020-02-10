<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="etbId", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     */
    private $etbId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     *
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
    public function getEtbId(): ?string
    {
        return $this->etbId;
    }

    /**
     * @param string $etbId
     * @return Structure
     */
    public function setEtbId(string $etbId): Structure
    {
        $this->etbId = $etbId;

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
