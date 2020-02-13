<?php


namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Importable
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $code;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=false, options={"default" : "import effectué avant la mise en place de ce champ" })
     *
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
     * @param string|null $code
     */
    public function setCode(?string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     */
    public function setSource(?string $source)
    {
        $this->source = $source;

        return $this;
    }

}