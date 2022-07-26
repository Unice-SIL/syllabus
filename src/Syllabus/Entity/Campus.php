<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Syllabus\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups as Groups;

/**
 * Class Campus
 * @package App\Syllabus\Entity
 * @ORM\Table(name="campus", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="code_source_on_campus_UNIQUE", columns={"code", "source"}),
 * })
 * @UniqueEntity(fields={"code", "source"}, message="Le campus avec pour code établissement {{ value }} existe déjà pour cette source", errorPath="code")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\CampusDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CampusTranslation")
 * @ApiResource(attributes={
 *          "normalization_context"={"groups"={"campuses"}},
 *          "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *          "access_control"="is_granted('ROLE_API_CAMPUS')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_CAMPUS_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_CAMPUS_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_CAMPUS_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_CAMPUS_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_CAMPUS_DELETE')"},
 *     }
 * )
 */
class Campus
{

    use Importable;

    /**
     * @var null|string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @Groups({"campuses"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Groups({"campuses"})
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="grp", type="string", length=100, nullable=true)
     * @Gedmo\Translatable
     * @Groups({"campuses"})
     */
    private $grp;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @Groups({"campuses"})
     */
    private $obsolete = false;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return Campus
     */
    public function setId(?string $id):self
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
     * @return Campus
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
     * @param string|null $grp
     * @return Campus
     */
    public function setGrp(?string $grp): self
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
     * @return Campus
     */
    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}