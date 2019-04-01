<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Equipment;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface EquipmentRepositoryInterface
 * @package AppBundle\Repository
 */
interface EquipmentRepositoryInterface
{
    /**
     * Find equipment by id
     * @param string $id
     * @return Equipment|null
     */
    public function find(string $id): ?Equipment;

    /**
     * Get all equipment
     * @return ArrayCollection
     */
    public function findAll(): ArrayCollection;

    /**
     * Create equipment
     * @param Equipment $equipment
     */
    public function create(Equipment $equipment): void;

    /**
     * Update equipment
     * @param Equipment $equipment
     */
    public function update(Equipment $equipment): void;

    /**
     * Delete equipment
     * @param Equipment $equipment
     */
    public function delete(Equipment $equipment): void;

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