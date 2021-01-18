<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\Groups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class GroupsDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class GroupsDoctrineRepository  extends ServiceEntityRepository
{

    /**
     * GroupsDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groups::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Groups::class)
            ->createQueryBuilder('g')
            ->addOrderBy('g.id', 'ASC');
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
            $qb->andWhere('g.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->getQuery()->getResult();
    }

}