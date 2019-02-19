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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="distant", type="boolean", nullable=false)
     */
    private $distant = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="teacher", type="boolean", nullable=false)
     */
    private $teacher = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private $obsolete = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    private $order = '0';


}
