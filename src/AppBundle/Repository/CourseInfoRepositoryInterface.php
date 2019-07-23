<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseInfo;

/**
 * Interface CourseInfoRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseInfoRepositoryInterface
{
    /**
     * Find course info by id
     * @param string $id
     * @return CourseInfo|null
     */
    public function find(string $id): ?CourseInfo;

    /**
     * Find course info by course etablishment id and year
     * @param $etbId
     * @param $year
     * @return CourseInfo|null
     */
    public function findByEtbIdAndYear($etbId, $year): ?CourseInfo;

    /**
     * Create a course info
     * @param CourseInfo $courseInfo
     */
    public function create(CourseInfo $courseInfo): void;

    /**
     * Update course info
     * @param CourseInfo $courseInfo
     */
    public function update(CourseInfo $courseInfo): void;

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