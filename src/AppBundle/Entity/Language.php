<?php


namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use mysql_xdevapi\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Language
 * @package AppBundle\Entity
 * @ORM\Table(name="language")
 * @ORM\Entity
 *
 */
class Language
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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CourseInfo", inversedBy="languages")
     * @JoinTable(name="courseInfo_language")
     */
    private $courseInfos;

    /**
     * Language constructor.
     */
    public function __construct()
    {
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

    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Language
     */
    public function addCourseInfo(CourseInfo $courseInfo): self
    {
        if (!$this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->add($courseInfo);
            if (!$courseInfo->getLanguages()->contains($this))
            {
                $courseInfo->getLanguages()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return Language
     */
    public function removeCourseInfo(CourseInfo $courseInfo): self
    {
        if ($this->courseInfos->contains($courseInfo))
        {
            $this->courseInfos->removeElement($courseInfo);
            if ($courseInfo->getLanguages()->contains($this))
            {
                $courseInfo->getLanguages()->removeElement($this);
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
}