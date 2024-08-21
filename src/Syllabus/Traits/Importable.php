<?php


namespace App\Syllabus\Traits;

use Doctrine\ORM\Mapping as ORM;


/**
 * Trait Importable
 * @package App\Syllabus\Traits
 */
trait Importable
{
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $code;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $source;

    
    #[ORM\Column(name: 'synchronized', type: 'boolean')]
    private bool $synchronized = false;

    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return $this
     */
    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return $this
     */
    public function setSource(?string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function isSynchronized(): ?bool
    {
        return $this->synchronized;
    }

    /**
     * @param bool $synchronized
     */
    public function setSynchronized(?bool $synchronized): self
    {
        $this->synchronized = $synchronized;

        return $this;
    }

}