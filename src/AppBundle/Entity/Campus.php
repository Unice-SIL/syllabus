<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Campus
 * @package AppBundle\Entity
 * @ORM\Table(name="campus")
 * @ORM\Entity
 *
 */
class Campus
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
}