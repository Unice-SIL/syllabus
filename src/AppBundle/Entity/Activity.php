<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity
 */
class Activity
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=true)
     * @Assert\Length(max="200")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="label_visibility", type="boolean", nullable=false, options={"comment"="Témoin affichage de l'intitulé de l'activité"})
     */
    private $labelVisibility = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position = 0;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ActivityType", mappedBy="activities")
     */
    private $activityTypes;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Activity
     */
    public function setId(string $id): Activity
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
     * @return Activity
     */
    public function setLabel(?string $label): Activity
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLabelVisibility(): bool
    {
        return $this->labelVisibility;
    }

    /**
     * @param bool $labelVisibility
     * @return Activity
     */
    public function setLabelVisibility(bool $labelVisibility): Activity
    {
        $this->labelVisibility = $labelVisibility;

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
     * @return Activity
     */
    public function setObsolete(bool $obsolete): Activity
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Activity
     */
    public function setPosition(int $position): Activity
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Activity
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * @return Activity
     */
    public function setActivityTypes(Collection $activityTypes): Activity
    {
        $this->activityTypes = $activityTypes;
        return $this;
    }

    /**
     * @param ActivityType $activityType
     * @return Activity
     */
    public function addActivityType(ActivityType $activityType): self
    {
        if (!$this->activityTypes->contains($activityType))
        {
            $this->activityTypes->add($activityType);
            if (!$activityType->getActivities()->contains($this))
            {
                $activityType->getActivities()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param ActivityType $activityType
     * @return Activity
     */
    public function removeActivityType(ActivityType $activityType): self
    {
        if ($this->activityTypes->contains($activityType))
        {
            $this->activityTypes->removeElement($activityType);
            if ($activityType->getActivities()->contains($this))
            {
                $activityType->getActivities()->removeElement($this);
            }
        }
        return $this;
    }
}
