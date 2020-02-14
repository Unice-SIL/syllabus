<?php


namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Domain
 *
 * @ORM\Table(name="domain")
 * @ORM\Entity
 */
class Domain
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Structure", mappedBy="domains")
     */
    private $structures;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="domains")
     * @JoinTable(name="courseInfo_domain")
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return bool
     */
    public function isObsolete()
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     */
    public function setObsolete($obsolete)
    {
        $this->obsolete = $obsolete;
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
    public function setStructure(Collection $structures): Domain
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
            if (!$courseInfo->getCampuses()->contains($this))
            {
                $courseInfo->getCampuses()->add($this);
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
            if ($courseInfo->getCampuses()->contains($this))
            {
                $courseInfo->getCampuses()->removeElement($this);
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

    public function __toString()
    {
        return $this->getLabel();
    }
}