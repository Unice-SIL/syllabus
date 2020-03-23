<?php


namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Level
 * @package AppBundle\Entity
 * @ORM\Table(name="level")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\LevelDoctrineRepository")
 *
 */
class Level
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     * @JMS\Groups(groups={"default", "level"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @JMS\Groups(groups={"default", "level"})
     */
    private $label;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseInfo", mappedBy="CourseInfos")
     */
    private $courseInfos;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @JMS\Groups(groups={"default", "level"})
     */
    private $obsolete = false;

    /**
     * Level constructor.
     */
    public function __construct()
    {
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

}