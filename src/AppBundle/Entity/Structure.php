<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use AppBundle\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Structure
 *
 * @ORM\Table(name="structure", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="code_source_on_structure_UNIQUE", columns={"code", "source"}),
 * })
 * @UniqueEntity(fields={"code", "source"}, message="La structure avec pour code établissement {{ value }} existe déjà pour cette source", errorPath="code")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\StructureDoctrineRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\StructureTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"}
 *     })
 */
class Structure
{
    use Importable;
    /**
     * @var string|null
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = '0';

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Domain", mappedBy="structures")
     */
    private $domains;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Period", mappedBy="structures")
     */
    private $periods;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Level", mappedBy="structures")
     */
    private $levels;

    /**
     * Structure constructor.
     */
    public function __construct()
    {
        $this->domains = new ArrayCollection();
        $this->periods = new ArrayCollection();
        $this->levels = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return Structure
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
     * @return Structure
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

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
    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDomains(): Collection
    {
        return $this->domains;
    }

    /**
     * @param Collection $domains
     * @return Structure
     */
    public function setDomains(Collection $domains): self
    {
        $this->domains = $domains;

        return $this;
    }

    /**
     * @param Domain $domain
     * @return Structure
     */
    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain))
        {
            $this->domains->add($domain);
            if (!$domain->getStructures()->contains($this))
            {
                $domain->getStructures()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Domain $domain
     * @return Structure
     */
    public function removeDomain(Domain $domain): self
    {
        if ($this->domains->contains($domain))
        {
            $this->domains->removeElement($domain);
            if ($domain->getStructures()->contains($this))
            {
                $domain->getStructures()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    /**
     * @param Collection $periods
     * @return Structure
     */
    public function setPeriods(Collection $periods): self
    {
        $this->periods = $periods;

        return $this;
    }

    /**
     * @param Period $period
     * @return Structure
     */
    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period))
        {
            $this->periods->add($period);
            if (!$period->getStructures()->contains($this))
            {
                $period->getStructures()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Period $period
     * @return Structure
     */
    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period))
        {
            $this->periods->removeElement($period);
            if ($period->getStructures()->contains($this))
            {
                $period->getStructures()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }

    /**
     * @param Collection $levels
     * @return Structure
     */
    public function setLevels(Collection $levels): self
    {
        $this->levels = $levels;
        return $this;
    }

    /**
     * @param Level $level
     * @return Structure
     */
    public function addLevel(Level $level): self
    {
        if (!$this->periods->contains($level))
        {
            $this->levels->add($level);
            if (!$level->getStructures()->contains($this))
            {
                $level->getStructures()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Level $level
     * @return Structure
     */
    public function removeLevel(Level $level): self
    {
        if ($this->levels->contains($level))
        {
            $this->levels->removeElement($level);
            if ($level->getStructures()->contains($this))
            {
                $level->getStructures()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}
