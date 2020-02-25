<?php


namespace AppBundle\Repository;

/**
 * Interface RepositoryInterface
 * @package AppBundle\Repository
 */
interface RepositoryInterface
{
    /**
     * Begin a transaction
     */
    public function beginTransaction(): void;

    /**
     * Commit change
     */
    public function commit(): void;

    /**
     * Rollback change
     */
    public function rollback(): void;
}