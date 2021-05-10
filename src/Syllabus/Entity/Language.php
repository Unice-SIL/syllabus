<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Syllabus\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups as Groups;

/**
 * Class Language
 * @package App\Syllabus\Entity
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\LanguageDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\LanguageTranslation")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"language"}},
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_LANGUAGE')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_LANGUAGE_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_LANGUAGE_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_LANGUAGE_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_LANGUAGE_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_LANGUAGE_DELETE')"},
 *     }
 * )
 */
class Language
{

    use Importable;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Syllabus\Doctrine\IdGenerator")
     * @Groups({"language"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     * @Groups({"language"})
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @Groups({"language"})
     */
    private $obsolete = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\CourseInfo", mappedBy="languages")
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
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return Language
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
     * @return Language
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
     * @return Language
     */
    public function setObsolete($obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
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
            $courseInfo->getLanguages()->add($this);
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