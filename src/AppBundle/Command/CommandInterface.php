<?php

namespace AppBundle\Command;

/**
 * Class CommandInterface
 * @package AppBundle\Port\Command
 */
interface CommandInterface
{
    /**
     * @return mixed
     */
    public function filledEntity($entity);
}