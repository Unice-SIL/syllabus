<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\ActivityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ActivityTypeDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class ActivityTypeDoctrineRepository extends ServiceEntityRepository
{
    /**
     * ActivityTypeDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityType::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(ActivityType::class)
            ->createQueryBuilder('at')
            ->addOrderBy('at.label', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        return $this->getIndexQueryBuilder()
            ->andWhere('at.'.$field.' LIKE :query ')
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
            switch ($filter){
                case 'label':
                    $qb->andWhere($qb->expr()->like('at.' . $filter, ':' . $valueName));
                    $value = "%{$value}%";
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('at.' . $filter, ':' . $valueName));
            }
            $qb->setParameter($valueName, $value);
        }

        return $qb;
    }
}