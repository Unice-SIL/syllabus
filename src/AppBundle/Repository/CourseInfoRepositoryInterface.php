<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseInfo;
use Doctrine\ORM\QueryBuilder;

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
     * Find courses info by year
     * @param $year
     * @return array
     */
    public function findByYear( $year): array;

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

    /**
     * @return mixed
     */
    public function detach($entity);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * Find all course_info by value of $field is like $query
     *
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array;

    /**
     * Return the necessary QueryBuilder for index pagination
     *
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder;

}