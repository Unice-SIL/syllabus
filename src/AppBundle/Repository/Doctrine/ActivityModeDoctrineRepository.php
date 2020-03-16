<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\ActivityMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ActivityModeDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class ActivityModeDoctrineRepository extends ServiceEntityRepository
{
    /**
     * ActivityModeDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityMode::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(ActivityMode::class)
            ->createQueryBuilder('am')
            ->addOrderBy('am.label', 'ASC');
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->getIndexQueryBuilder()
            ->andWhere('am.label LIKE :query ')
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
        $qb = $this->getIndexQueryBuilder();


        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter){
                case 'label':
                    $qb->andWhere($qb->expr()->like('am.' . $filter, ':' . $valueName));
                    $value = "%{$value}%";
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('am.' . $filter, ':' . $valueName));
            }$qb->setParameter($valueName, $value);
        }

        return $qb;
    }
}