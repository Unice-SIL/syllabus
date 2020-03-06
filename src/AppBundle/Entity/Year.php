<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Year
 *
 * @ORM\Table(name="year")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\YearDoctrineRepository")
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
     * @JMS\Groups(groups={"default", "year"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true, options={"fixed"=true})
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     * @JMS\Groups(groups={"default", "year"})
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="import", type="boolean", nullable=true)
     * @JMS\Groups(groups={"year"})
     */
    private $import = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="edit", type="boolean", nullable=true)
     * @JMS\Groups(groups={"year"})
     */
    private $edit = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="current", type="boolean", nullable=true)
     * @JMS\Groups(groups={"year"})
     */
    private $current = false;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CourseInfo", mappedBy="year")
     */
    private $courseInfos;

    /**
     * Year constructor.
     */
    public function __construct()
    {
        $this->courseInfos = new ArrayCollection();
    }


    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return Year
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param null|string $label
     * @return Year
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
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
     * @return Year
     */
    public function setImport(bool $import): self
    {
        $this->import = $import;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEdit(): bool
    {
        return $this->edit;
    }

    /**
     * @param bool $edit
     * @return Year
     */
    public function setEdit(bool $edit): self
    {
        $this->edit = $edit;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCurrent(): bool
    {
        return $this->current;
    }

    /**
     * @param bool $current
     * @return Year
     */
    public function setCurrent(bool $current): self
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseInfos(): ?Collection
    {
        return $this->courseInfos;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }


}
