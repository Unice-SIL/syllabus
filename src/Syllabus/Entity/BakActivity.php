<?php
namespace App\Syllabus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity
 */
#[ORM\Entity]
#[ORM\Table(name: 'bak_activity')]
class BakActivity
{
    /**
     * @var string
     */
    #[ORM\Column(name: 'id', type: 'string', length: 36, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'label', type: 'string', length: 100, nullable: false)]
    private $label;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'description', type: 'string', length: 200, nullable: true)]
    #[Assert\Length(max: 200)]
    private $description;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'label_visibility', type: 'boolean', nullable: false, options: ['comment' => "Témoin affichage de l'intitulé de l'activité"])]
    private $labelVisibility = true;

    /**
     * @var string
     */
    #[ORM\Column(name: 'type', type: 'string', length: 25, nullable: false)]
    private $type = 'activity';

    /**
     * @var string
     */
    #[ORM\Column(name: 'mode', type: 'string', length: 25, nullable: false)]
    private $mode = 'class';

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'grp', type: 'string', length: 25, nullable: true)]
    private $grp;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private $obsolete = false;

    /**
     * @var int
     */
    #[ORM\Column(name: 'ord', type: 'integer', nullable: false)]
    private $ord = 0;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isLabelVisibility(): bool
    {
        return $this->labelVisibility;
    }

    public function setLabelVisibility(bool $labelVisibility): self
    {
        $this->labelVisibility = $labelVisibility;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getGrp()
    {
        return $this->grp;
    }

    /**
     * @param $grp
     * @return $this
     */
    public function setGrp($grp)
    {
        $this->grp = $grp;

        return $this;
    }


    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }

    public function getOrd(): int
    {
        return $this->ord;
    }

    public function setOrd(int $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

}