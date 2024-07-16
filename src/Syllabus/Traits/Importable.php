<?php


namespace App\Syllabus\Traits;

use Doctrine\ORM\Mapping as ORM;


/**
 * Trait Importable
 * @package App\Syllabus\Traits
 */
trait Importable
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $code;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $source;

    /**
     * @var bool
     *
     * @ORM\Column(name="synchronized", type="boolean")
     */
    private bool $synchronized = false;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     * @return $this
     */
    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param null|string $source
     * @return $this
     */
    public function setSource(?string $source): static
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isSynchronized(): ?bool
    {
        return $this->synchronized;
    }

    /**
     * @param bool $synchronized
     * @return Importable
     */
    public function setSynchronized(?bool $synchronized): self
    {
        $this->synchronized = $synchronized;

        return $this;
    }

}