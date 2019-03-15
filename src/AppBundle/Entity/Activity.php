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
     * @ORM\Column(name="label_visibility", type="boolean", nullable=false, options={"default"="1","comment"="Témoin affichage de l'intitulé de l'activité"})
     */
    private $labelVisibility = '1';

    /**
     * @var bool
     *
     * @ORM\Column(name="evaluation", type="boolean", nullable=false)
     */
    private $evaluation = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="distant", type="boolean", nullable=false)
     */
    private $distant = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="teacher", type="boolean", nullable=false)
     */
    private $teacher = false;

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
     * @return bool
     */
    public function isEvaluation(): bool
    {
        return $this->evaluation;
    }

    /**
     * @param bool $evaluation
     * @return Activity
     */
    public function setEvaluation(bool $evaluation): Activity
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDistant(): bool
    {
        return $this->distant;
    }

    /**
     * @param bool $distant
     * @return Activity
     */
    public function setDistant(bool $distant): Activity
    {
        $this->distant = $distant;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTeacher(): bool
    {
        return $this->teacher;
    }

    /**
     * @param bool $teacher
     * @return Activity
     */
    public function setTeacher(bool $teacher): Activity
    {
        $this->teacher = $teacher;

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
