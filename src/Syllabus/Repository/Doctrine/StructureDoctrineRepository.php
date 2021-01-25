<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class StructureDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class StructureDoctrineRepository extends ServiceEntityRepository
{
    /**
     * StructureDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structure::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Structure::class)
            ->createQueryBuilder('s')
            ->addOrderBy('s.code', 'ASC')
            ->addOrderBy('s.label', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['code', 'label'])) {
            $qb->andWhere('s.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->getQuery()->getResult();
    }

}