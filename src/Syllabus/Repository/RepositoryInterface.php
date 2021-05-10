<?php


namespace App\Syllabus\Repository;

/**
 * Interface RepositoryInterface
 * @package App\Syllabus\Repository
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