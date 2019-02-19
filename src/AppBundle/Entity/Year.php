<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Year
 *
 * @ORM\Table(name="year")
 * @ORM\Entity
 */
class Year
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=4, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true, options={"fixed"=true})
     */
    private $label;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="import", type="boolean", nullable=true)
     */
    private $import = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="edit", type="boolean", nullable=true)
     */
    private $edit = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="current", type="boolean", nullable=true)
     */
    private $current = '0';


}
