<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class EquipmentDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class EquipmentDoctrineRepository extends ServiceEntityRepository
{

    /**
     * EquipmentDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Equipment::class)
            ->createQueryBuilder('e')
            ->addOrderBy('e.label', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere('e.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->getQuery()->getResult();
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
            $qb->andWhere($qb->expr()->eq('e.' . $filter, ':' . $valueName))
                ->setParameter($valueName, $value);
        }

        return $qb;
    }

}