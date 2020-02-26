<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DomainDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class DomainDoctrineRepository extends ServiceEntityRepository
{

    /**
     * DomainDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domain::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Domain::class)
            ->createQueryBuilder('d')
            ->addOrderBy('d.label', 'ASC')
            ;
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->getIndexQueryBuilder()
            ->andWhere('d.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            $qb->andWhere($qb->expr()->eq('d.' . $filter, ':' . $valueName))
                ->setParameter($valueName, $value)
            ;
        }

        return $qb;
    }
}