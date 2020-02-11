<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Structure;
use Ramsey\Uuid\Uuid;

/**
 * Class StructureManager
 * @package AppBundle\Manager
 */
class StructureManager
{
    /**
     * @return Structure
     * @throws \Exception
     */
    public function create()
    {
        $structure = new Structure();

        return $structure;
    }
}