<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseEvaluationCt;

/**
 * Interface CourseEvaluationCtRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseEvaluationCtRepositoryInterface
{
    /**
     * Find a course evaluation by id
     * @param string $id
     * @return CourseEvaluationCt|null
     */
    public function find(string $id): ?CourseEvaluationCt;

    /**
     * Create a course evaluation
     * @param CourseEvaluationCt $courseEvaluationCt
     */
    public function create(CourseEvaluationCt $courseEvaluationCt): void;

    /**
     * Delete a course section
     * @param CourseEvaluationCt $courseEvaluationCt
     */
    public function delete(CourseEvaluationCt $courseEvaluationCt): void;

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