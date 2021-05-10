<?php


namespace App\Syllabus\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Syllabus\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Level
 * @package App\Syllabus\Entity
 * @ORM\Table(name="level")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\LevelDoctrineRepository")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_LEVEL')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_LEVEL_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_LEVEL_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_LEVEL_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_LEVEL_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_LEVEL_DELETE')"},
 *     }
 * )
 */
class Level
{

    use Importable;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Syllabus\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @Gedmo\Translatable
     */
    private $label;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseInfo", mappedBy="levels")
     */
    private $courseInfos;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\Structure", inversedBy="levels")
     * @ORM\OrderBy({"label" = "ASC"})
     */
    private $structures;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * Level constructor.
     */
    public function __construct()
    {
        $this->courseInfos = new ArrayCollection();
        $this->structures = new ArrayCollection();
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
     * @return Level
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
     * @return Level
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
     * @param $obsolete
     * @return Level
     */
    public function setObsolete($obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }


    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * @return mixed
     */
    public function getCourseInfos()
    {
        return $this->courseInfos;
    }

    /**
     * @param mixed $courseInfos
     */
    public function setCourseInfos($courseInfos): void
    {
        $this->courseInfos = $courseInfos;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Level
     */
    public function addCourseInfo(CourseInfo $courseInfo): self
    {
        if (!$this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->add($courseInfo);
            if (!$courseInfo->getLevels()->contains($this))
            {
                $courseInfo->getLevels()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Level
     */
    public function removeCourseInfo(CourseInfo $courseInfo): self
    {
        if ($this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->removeElement($courseInfo);
            if ($courseInfo->getLevels()->contains($this))
            {
                $courseInfo->getLevels()->removeElement($this);
            }
        }
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
     * @return Level
     */
    public function setStructures(Collection $structures): Level
    {
        $this->structures = $structures;
        return $this;
    }

    /**
     * @param Structure $structure
     * @return Level
     */
    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure))
        {
            $this->structures->add($structure);
            if (!$structure->getLevels()->contains($this))
            {
                $structure->getLevels()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param Structure $structure
     * @return Level
     */
    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->contains($structure))
        {
            $this->structures->removeElement($structure);
            if ($structure->getLevels()->contains($this))
            {
                $structure->getLevels()->removeElement($this);
            }
        }
        return $this;
    }

}