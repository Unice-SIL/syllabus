<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="label_visibility", type="boolean", nullable=false, options={"comment"="Témoin affichage de l'intitulé de l'activité"})
     */
    private $labelVisibility = true;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     */
    private $type = 'activity';

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=25, nullable=false)
     */
    private $mode = 'class';

    /**
     * @var string|null
     *
     * @ORM\Column(name="grp", type="string", length=25, nullable=true)
     */
    private $grp;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = false;

    /**
     * @var int
     *
     * @ORM\Column(name="ord", type="integer", nullable=false)
     */
    private $ord = 0;

    /**
     * @return string
     */
    public function getId(): string
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
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Activity
     */
    public function setLabel(string $label): Activity
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Activity
     */
    public function setType(string $type): Activity
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return Activity
     */
    public function setMode(string $mode): Activity
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
     * @param null|string $grp
     * @return Activity
     */
    public function setGrp($grp)
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
    public function getOrd(): int
    {
        return $this->ord;
    }

    /**
     * @param int $ord
     * @return Activity
     */
    public function setOrd(int $ord): Activity
    {
        $this->ord = $ord;

        return $this;
    }

}
