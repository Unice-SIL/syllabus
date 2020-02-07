<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ActivityMode
 *
 * @ORM\Table(name="activity_mode")
 * @ORM\Entity
 */
class ActivityMode
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
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ActivityType", mappedBy="activityModes")
     */
    private $activityTypes;

    /**
     * ActivityMode constructor.
     */
    public function __construct()
    {
        $this->activityTypes = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ActivityMode
     */
    public function setId(string $id): ActivityMode
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return ActivityMode
     */
    public function setLabel(string $label): ActivityMode
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
     * @return ActivityMode
     */
    public function setObsolete(bool $obsolete): ActivityMode
    {
        $this->obsolete = $obsolete;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getActivityTypes(): Collection
    {
        return $this->activityTypes;
    }

    /**
     * @param Collection $activityTypes
     * @return ActivityMode
     */
    public function setActivityTypes(Collection $activityTypes): ActivityMode
    {
        $this->activityTypes = $activityTypes;
        return $this;
    }

    /**
     * @param ActivityType $activityType
     * @return ActivityMode
     */
    public function addActivityType(ActivityType $activityType): self
    {
        if (!$this->activityTypes->contains($activityType))
        {
            $this->activityTypes->add($activityType);
            if (!$activityType->getActivityModes()->contains($this))
            {
                $activityType->getActivityModes()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param ActivityType $activityType
     * @return ActivityMode
     */
    public function removeActivityType(ActivityType $activityType): self
    {
        if ($this->activityTypes->contains($activityType))
        {
            $this->activityTypes->removeElement($activityType);
            if ($activityType->getActivityModes()->contains($this))
            {
                $activityType->getActivityModes()->removeElement($this);
            }
        }
        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}