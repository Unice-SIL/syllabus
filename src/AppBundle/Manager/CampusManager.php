<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Campus;
use AppBundle\Repository\CampusRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CampusManager
 * @package AppBundle\Manager
 */
class CampusManager
{
    /**
     * @var CampusRepositoryInterface
     */
    private $repository;

    public function __construct(CampusRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Campus
     */
    public function new()
    {
        return new Campus();
    }

    /**
     * @param $id
     * @return Campus|null
     */
    public function find($id): ?Campus
    {
        return $this->repository->find($id);
    }

    /**
     * @return Campus[]|array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Campus $campus
     */
    public function create(Campus $campus)
    {
        $this->repository->create($campus);
    }

    /**
     * @param Campus $campus
     */
    public function update(Campus $campus)
    {
        $this->repository->update($campus);
    }

    /**
     * @param Campus $campus
     */
    public function delete(Campus $campus)
    {
        $this->repository->delete($campus);
    }

    /**
     * @param $query
     * @return array
     */
    public function findLikeQuery($query): array
    {
        return $this->repository->findLikeQuery($query);
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $this->repository->findQueryBuilderForApi($config);
    }
}