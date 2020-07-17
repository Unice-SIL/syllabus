<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ActivityMode
 *
 * @ORM\Table(name="activity_mode")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\ActivityModeDoctrineRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\ActivityModeTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_ACTIVITY_MODE')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_ACTIVITY_MODE_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_ACTIVITY_MODE_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_ACTIVITY_MODE_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_ACTIVITY_MODE_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_ACTIVITY_MODE_DELETE')"},
 *     }
 * )
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
     * @Gedmo\Translatable
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
     * @ApiSubresource()
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
     * @param null|string $id
     * @return ActivityMode
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
     * @return ActivityMode
     */
    public function setLabel(string $label): self
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
    public function setObsolete(bool $obsolete): self
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
    public function setActivityTypes(Collection $activityTypes): self
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

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}