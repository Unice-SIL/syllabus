<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Period;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface PeriodRepositoryInterface
 * @package AppBundle\Repository
 */
interface PeriodRepositoryInterface
{
    /**
     * @param string $id
     * @return Period|null
     */
    public function find(string $id): ?Period;

    /**
     * @return \ArrayObject
     */
    public function findAll(): \ArrayObject;

    /**
     * Create period
     * @param Period $period
     */
    public function create(Period $period): void;

    /**
     * Update period
     * @param Period $period
     */
    public function update(Period $period): void;

    /**
     * Delete period
     * @param Period $period
     */
    public function delete(Period $period): void;

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
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder;

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query): array;
}