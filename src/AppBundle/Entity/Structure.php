<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use JMS\Serializer\Annotation as JMS;
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
     * @var string|null
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"course_info", "structure"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="etbId", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     * @JMS\Groups(groups={"course_info", "structure"})
     */
    private $etbId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     * @JMS\Groups(groups={"course_info", "structure"})
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @JMS\Groups(groups={"course_info", "structure"})
     */
    private $obsolete = '0';

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Domain", inversedBy="structures")
     * @JoinTable(name="domain_structure")
     * @JMS\Groups(groups={"structure"})
     */
    private $domains;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Period", inversedBy="structures")
     * @JoinTable(name="period_structure")
     * @JMS\Groups(groups={"structure"})
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
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Structure
     */
    public function setId(string $id): self
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
    public function setEtbId(string $etbId): self
    {
        $this->etbId = $etbId;

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
    public function setLabel($label): self
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
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}
