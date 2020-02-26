<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Campus;
use AppBundle\Repository\CampusRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CampusDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CampusDoctrineRepository extends AbstractDoctrineRepository implements CampusRepositoryInterface
{
    /**
     * CampusDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Campus::class);
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
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Campus $campus
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Campus $campus): void
    {
        $this->entityManager->persist($campus);
        $this->entityManager->flush();
    }

    /**
     * @param Campus $campus
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Campus $campus): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param Campus $campus
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Campus $campus): void
    {
        $this->entityManager->remove($campus);
        $this->entityManager->flush();
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(Campus::class)->createQueryBuilder('c')
            ->andWhere('c.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->entityManager->getRepository(Campus::class)
            ->createQueryBuilder('c')
            ->addOrderBy('c.label', 'ASC');

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            $qb->andWhere($qb->expr()->eq('c.' . $filter, ':' . $valueName))
                ->setParameter($valueName, $value)
            ;
        }

        return $qb;
    }
}