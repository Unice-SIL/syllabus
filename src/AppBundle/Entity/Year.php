<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Year
 *
 * @ORM\Table(name="year")
 * @ORM\Entity
 * @UniqueEntity("id")
 * @UniqueEntity("label")
 */
class Year
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=4, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^\d{4}$/",
     *     message="Cette valeure doit respecter le format AAAA"
     * )
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true, options={"fixed"=true})
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^\d{4}-\d{4}$/",
     *     message="Cette valeure doit respecter le format AAAA-AAAA"
     * )
     */
    private $label;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="import", type="boolean", nullable=true)
     */
    private $import = false;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="edit", type="boolean", nullable=true)
     */
    private $edit = false;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="current", type="boolean", nullable=true)
     */
    private $current = false;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Year
     */
    public function setId(string $id): Year
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
     * @return Year
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     * @param bool|null $import
     * @return Year
     */
    public function setImport($import)
    {
        $this->import = $import;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEdit()
    {
        return $this->edit;
    }

    /**
     * @param bool|null $edit
     * @return Year
     */
    public function setEdit($edit)
    {
        $this->edit = $edit;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param bool|null $current
     * @return Year
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }


}
