<?php


namespace App\Syllabus\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Syllabus\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Domain
 *
 * @ORM\Table(name="domain")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\DomainDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\DomainTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_DOMAIN')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_DOMAIN_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_DOMAIN_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_DOMAIN_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_DOMAIN_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_DOMAIN_DELETE')"},
 *     }
 * )
 */
class Domain
{
    use Importable;

    /**
     * @var null|string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="grp", type="string", length=100, nullable=true)
     * @Gedmo\Translatable
     */
    private $grp;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\Structure", inversedBy="domains")
     * @ORM\OrderBy({"label" = "ASC"})
     * @ApiSubresource()
     */
    private $structures;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\CourseInfo", mappedBy="domains")
     */
    private $courseInfos;

    /**
     * Domain constructor.
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
     * @return Domain
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
     * @return Domain
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrp(): ?string
    {
        return $this->grp;
    }

    /**
     * @param string $grp
     * @return Domain
     */
    public function setGrp(string $grp): Domain
    {
        $this->grp = $grp;
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
     * @return Domain
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
     * @return Domain
     */
    public function setStructures(Collection $structures): Domain
    {
        $this->structures = $structures;
        return $this;
    }

    /**
     * @param Structure $structure
     * @return Domain
     */
    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure))
        {
            $this->structures->add($structure);
            if (!$structure->getDomains()->contains($this))
            {
                $structure->getDomains()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Structure $structure
     * @return Domain
     */
    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->contains($structure))
        {
            $this->structures->removeElement($structure);
            if ($structure->getDomains()->contains($this))
            {
                $structure->getDomains()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Domain
     */
    public function addCourseInfo(CourseInfo $courseInfo): self
    {
        if (!$this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->add($courseInfo);
            if (!$courseInfo->getDomains()->contains($this))
            {
                $courseInfo->getDomains()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Domain
     */
    public function removeCourseInfo(CourseInfo $courseInfo): self
    {
        if ($this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->removeElement($courseInfo);
            if ($courseInfo->getDomains()->contains($this))
            {
                $courseInfo->getDomains()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourseInfos()
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