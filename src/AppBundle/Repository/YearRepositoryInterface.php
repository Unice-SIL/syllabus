<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Year;

/**
 * Interface YearRepositoryInterface
 * @package AppBundle\Repository
 */
interface YearRepositoryInterface
{
    /**
     * Find year info by id
     * @param string $id
     * @return Year|null
     */
    public function find(string $id): ?Year;


    /**
     * Find year to import
     * @return array
     */
    public function findToImport(): array;

    /**
     * Create year
     * @param Year $year
     */
    public function create(Year $year): void;

    /**
     * Update year
     * @param Year $year
     */
    public function update(Year $year): void;


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