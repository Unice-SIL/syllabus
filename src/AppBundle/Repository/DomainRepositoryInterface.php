<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Domain;
use Doctrine\ORM\QueryBuilder;

interface DomainRepositoryInterface
{

    public function find(string $id): ?Domain;

    /**
     * @return \ArrayObject
     */
    public function findAll(): \ArrayObject;

    /**
     * Create domain
     * @param Domain $domain
     */
    public function create(Domain $domain): void;

    /**
     * Update domain
     * @param Domain $domain
     */
    public function update(Domain $domain): void;

    /**
     * Delete domain
     * @param Domain $domain
     */
    public function delete(Domain $domain): void;

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