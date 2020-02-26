<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Domain;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DomainRepositoryInterface
 * @package AppBundle\Repository
 */
interface DomainRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     * @return Domain|null
     */
    public function find(string $id): ?Domain;

    /**
     * @return Domain[]
     */
    public function findAll(): array;

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
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query): array;
}