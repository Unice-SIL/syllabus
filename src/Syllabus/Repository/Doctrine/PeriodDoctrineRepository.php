<?php


namespace App\Syllabus\Repository\Doctrine;


use App\Syllabus\Entity\Period;
use App\Syllabus\Entity\Structure;
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
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere('p.label LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $query
     * @param Structure $structure
     * @param string $field
     * @return array
     */
    public function findLikeWithStructureQuery(string $query, Structure $structure, $field = 'label'): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere('p.label LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->andWhere(':structure MEMBER OF p.structures')
            ->setParameter('structure', $structure)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $filters
     * @return array
     */
    public function findByFilters($filters=[]): array
    {
        return $this->findQueryBuilderForApi(['filters' => $filters])->getQuery()->getResult();
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
                case 'structure':
                    $qb->andWhere($qb->expr()->isMemberOf(':' . $valueName, 'p.structures'));
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('p.' . $filter, ':' . $valueName));
            }
            $qb->setParameter($valueName, $value);
        }

        return $qb;
    }
}