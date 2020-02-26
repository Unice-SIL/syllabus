<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Campus;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface CampusRepositoryInterface
 * @package AppBundle\Repository
 */
interface CampusRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $id
     * @return Campus|null
     */
    public function find($id): ?Campus;

    /**
     * @return Campus[]
     */
    public function findAll(): array;

    /**
     * @param Campus $campus
     */
    public function create(Campus $campus): void;

    /**
     * @param Campus $campus
     */
    public function update(Campus $campus): void;

    /**
     * @param Campus $campus
     */
    public function delete(Campus $campus): void;

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array;

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder;
}