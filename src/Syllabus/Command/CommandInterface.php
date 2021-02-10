<?php

namespace App\Syllabus\Command;

/**
 * Class CommandInterface
 * @package App\Syllabus\Port\Command
 */
interface CommandInterface
{
    /**
     * @param $entity
     * @return mixed
     */
    public function filledEntity($entity);
}