<?php


namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Trait Importable
 * @package AppBundle\Traits
 */
trait Importable
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=false)
     * @JMS\Groups(groups={"default"})
     */
    private $code;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true, options={"default" : "import effectué avant la mise en place de ce champ" })
     * @JMS\Groups(groups={"default"})
     */
    private $source;

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
    public function setCode(?string $code)
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
    public function setSource(?string $source)
    {
        $this->source = $source;

        return $this;
    }

}