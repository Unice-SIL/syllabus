<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\Domain;
use App\Syllabus\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DomainDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
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
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field = 'label'): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere('d.label LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }

        return $qb->orderBy('d.grp', 'ASC')
            ->addOrderBy('d.code', 'ASC')
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
            $qb->andWhere('d.label LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->andWhere(':structure MEMBER OF d.structures')
            ->setParameter('structure', $structure)
            ->orderBy('d.grp', 'ASC')
            ->addOrderBy('d.code', 'ASC')
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
                    $qb->andWhere($qb->expr()->like('d.' . $filter, ':' . $valueName));
                    $value = "%{$value}%";
                    break;
                case 'structure':
                    $qb->andWhere($qb->expr()->isMemberOf(':' . $valueName, 'd.structures'));
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('d.' . $filter, ':' . $valueName));
            }
            $qb->setParameter($valueName, $value);
            ;
        }

        return $qb;
    }
}