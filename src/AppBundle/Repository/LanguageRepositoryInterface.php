<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Language;
use Doctrine\ORM\QueryBuilder;

interface LanguageRepositoryInterface
{
    /**
     * @param string $id
     * @return Language|null
     */
    public function find(string $id): ?Language;

    /**
     * @return \ArrayObject
     */
    public function findAll(): \ArrayObject;

    /**
     * Create Language
     * @param Language $language
     */
    public function create(Language $language): void;

    /**
     * Update Language
     * @param Language $language
     */
    public function update(Language $language): void;

    /**
     * Delete Language
     * @param Language $language
     */
    public function delete(Language $language): void;

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