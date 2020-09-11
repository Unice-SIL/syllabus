<?php


namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use AppBundle\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Period
 *
 * @ORM\Table(name="period")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\PeriodDoctrineRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\PeriodTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_PERIOD')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_PERIOD_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_PERIOD_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_PERIOD_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_PERIOD_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_PERIOD_DELETE')"},
 *     }
 * )
 */
class Period
{

    use Importable;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Structure", inversedBy="periods")
     */
    private $structures;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CourseInfo", mappedBy="periods")
     */
    private $courseInfos;

    /**
     * Period constructor.
     */
    public function __construct()
    {
        $this->structures = new ArrayCollection();
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
     * @return Period
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
     * @return Period
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
     * @return Period
     */
    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getStructures(): ?Collection
    {
        return $this->structures;
    }

    /**
     * @param Collection $structures
     * @return Period
     */
    public function setStructures(Collection $structures): Period
    {
        $this->structures = $structures;
        return $this;
    }

    /**
     * @param Structure $structure
     * @return Period
     */
    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure))
        {
            $this->structures->add($structure);
            if (!$structure->getPeriods()->contains($this))
            {
                $structure->getPeriods()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Structure $structure
     * @return Period
     */
    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->contains($structure))
        {
            $this->structures->removeElement($structure);
            if ($structure->getPeriods()->contains($this))
            {
                $structure->getPeriods()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Period
     */
    public function addCourseInfo(CourseInfo $courseInfo): self
    {
        if (!$this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->add($courseInfo);
            if (!$courseInfo->getPeriods()->contains($this))
            {
                $courseInfo->getPeriods()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Period
     */
    public function removeCourseInfo(CourseInfo $courseInfo): self
    {
        if ($this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->removeElement($courseInfo);
            if ($courseInfo->getPeriods()->contains($this))
            {
                $courseInfo->getPeriods()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCourseInfos(): Collection
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