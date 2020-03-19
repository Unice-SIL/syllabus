<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Period;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PeriodDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class PeriodDoctrineRepository extends ServiceEntityRepository
{

    /**
     * PeriodDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Period::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Period::class)
            ->createQueryBuilder('p')
            ->addOrderBy('p.label', 'ASC');
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->getIndexQueryBuilder()
            ->andWhere('p.label LIKE :query ')
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
                    $qb->andWhere($qb->expr()->like('p.' . $filter, ':' . $valueName));
                    $value = "%{$value}%";
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('p.' . $filter, ':' . $valueName));
            }
            $qb->setParameter($valueName, $value);
        }

        return $qb;
    }
}