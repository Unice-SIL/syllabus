<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\Domain;

/**
 * Class DomainMigration
 * @package AppBundle\Command\Migration
 */
class DomainMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:domain-migration';

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of domains creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of domains creation';
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Domain::class;
    }

    /**
     * @return array
     */
    protected function getEntities(): array
    {
        $domains = [];

        return $domains;
    }

}