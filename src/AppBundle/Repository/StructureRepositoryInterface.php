<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Structure;

/**
 * Interface StructureRepositoryInterface
 * @package AppBundle\Repository
 */
interface StructureRepositoryInterface
{
    /**
     * Find structure info by id
     * @param string $id
     * @return Structure|null
     */
    public function find(string $id): ?Structure;

    /**
     * @param string $etbId
     * @return Structure|null
     */
    public function findByEtbId(string $etbId): ?Structure;

    /**
     * Create structure
     * @param Structure $structure
     */
    public function create(Structure $structure): void;

    /**
     * Update structure
     * @param Structure $structure
     */
    public function update(Structure $structure): void;


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