<?php

namespace App\Syllabus\Command;

/**
 * Class CommandInterface
 * @package AppBundle\Port\Command
 */
interface CommandInterface
{
    /**
     * @param $entity
     * @return mixed
     */
    public function filledEntity($entity);
}