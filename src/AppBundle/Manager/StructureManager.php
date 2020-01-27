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
     */
    public function create()
    {
        $structure = new Structure();
        $structure->setId(Uuid::uuid4());

        return $structure;
    }
}