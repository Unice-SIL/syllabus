<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseResourceEquipment;

/**
 * Interface UserRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseResourceEquipmentRepositoryInterface
{
    /**
     * Find a course resource equipment by id
     * @param string $id
     * @return CourseResourceEquipment|null
     */
    public function find(string $id): ?CourseResourceEquipment;

    /**
     * Create a course resource equipment
     * @param CourseResourceEquipment $courseResourceEquipment
     */
    public function create(CourseResourceEquipment $courseResourceEquipment): void;

    /**
     * Delete a course resource equipment
     * @param CourseResourceEquipment $courseResourceEquipment
     */
    public function delete(CourseResourceEquipment $courseResourceEquipment): void;

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