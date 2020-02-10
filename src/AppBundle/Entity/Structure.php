<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
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
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Domain", inversedBy="structures")
     * @JoinTable(name="domain_structure")
     */
    private $domains;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Period", inversedBy="structures")
     * @JoinTable(name="period_structure")
     */
    private $periods;

    /**
     * Structure constructor.
     */
    public function __construct()
    {
        $this->domains = new ArrayCollection();
        $this->periods = new ArrayCollection();
    }

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
            if ($domain->getDomain()->contains($this))
            {
                $domain->getDomain()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDomains()
    {
        return $this->domains;
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
            if ($period->getPeriod()->contains($this))
            {
                $period->getPeriod()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPeriods()
    {
        return $this->periods;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}
