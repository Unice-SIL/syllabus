<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity
 *
 * @ORM\Table(name="activity_type")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\ActivityTypeDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\ActivityTypeTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_ACTIVITY_TYPE')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_ACTIVITY_TYPE_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_ACTIVITY_TYPE_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_ACTIVITY_TYPE_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_ACTIVITY_TYPE_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_ACTIVITY_TYPE_DELETE')"},
 *     }
 * )
 */
class ActivityType
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
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
     */
    private $obsolete = false;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\Activity", inversedBy="activityTypes")
     * @JoinTable(name="activity_type_activity")
     */
    private $activities;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\ActivityMode", inversedBy="activityTypes")
     * @JoinTable(name="activity_type_activity_mode")
     * @ApiSubresource()
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
     * @param string|null $id
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
     * @param string|null $label
     * @return ActivityType
     */
    public function setLabel(?string $label): self
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
     * @param $previousIcon
     * @return ActivityType
     */
    public function setPreviousIcon($previousIcon): ActivityType
    {
        $this->previousIcon = $previousIcon;
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