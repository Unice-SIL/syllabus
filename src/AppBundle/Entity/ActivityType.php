<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Activity
 *
 * @ORM\Table(name="activity_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\ActivityTypeDoctrineRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\ActivityTypeTranslation")
 */
class ActivityType
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"default", "activity_type"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @JMS\Groups(groups={"default", "activity_type"})
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="icon", type="text", length=65535, nullable=true)
     * @Assert\File(
     *    maxSize="2M",
     *     mimeTypes={ "image/jpeg", "image/png" }
     *     )
     */
    private $icon;

    /**
     * @var string|null
     */
    private $previousIcon = null;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @JMS\Groups(groups={"default", "activity_type"})
     */
    private $obsolete = false;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Activity", inversedBy="activityTypes")
     * @JoinTable(name="activity_type_activity")
     * @JMS\Groups(groups={"activity_type"})
     */
    private $activities;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ActivityMode", inversedBy="activityTypes")
     * @JoinTable(name="activity_type_activity_mode")
     * @JMS\Groups(groups={"activity_type"})
     */
    private $activityModes;

    /**
     * ActivityType constructor.
     */
    public function __construct()
    {
        $this->activityModes = new ArrayCollection();
        $this->activities = new ArrayCollection();
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
     * @return ActivityType
     */
    public function setId(?string $id): self
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
     * @return ActivityType
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return string|null
     */
    public function getPreviousIcon(): ?string
    {
        return $this->previousIcon;
    }

    /**
     * @return ActivityType
     */
    public function setPreviousIcon(): ActivityType
    {
        $this->previousIcon = $this->getIcon();
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
     * @return ActivityType
     */
    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    /**
     * @param Collection $activities
     * @return ActivityType
     */
    public function setActivities(Collection $activities): self
    {
        $this->activities = $activities;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getActivityModes(): Collection
    {
        return $this->activityModes;
    }

    /**
     * @param Collection $activityModes
     * @return ActivityType
     */
    public function setActivityModes(Collection $activityModes): self
    {
        $this->activityModes = $activityModes;
        return $this;
    }

    /**
     * @param Activity $activity
     * @return ActivityType
     */
    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity))
        {
            $this->activities->add($activity);
            if (!$activity->getActivityTypes()->contains($this))
            {
                $activity->getActivityTypes()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Activity $activity
     * @return ActivityType
     */
    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity))
        {
            $this->activities->removeElement($activity);
            if ($activity->getActivityTypes()->contains($this))
            {
                $activity->getActivityTypes()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @param ActivityMode $activityMode
     * @return ActivityType
     */
    public function addActivityMode(ActivityMode $activityMode): self
    {
        if (!$this->activityModes->contains($activityMode))
        {
            $this->activityModes->add($activityMode);
            if (!$activityMode->getActivityTypes()->contains($this))
            {
                $activityMode->getActivityTypes()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param ActivityMode $activityMode
     * @return ActivityType
     */
    public function removeActivityMode(ActivityMode $activityMode): self
    {
        if ($this->activityModes->contains($activityMode))
        {
            $this->activityModes->removeElement($activityMode);
            if ($activityMode->getActivityTypes()->contains($this))
            {
                $activityMode->getActivityTypes()->removeElement($this);
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