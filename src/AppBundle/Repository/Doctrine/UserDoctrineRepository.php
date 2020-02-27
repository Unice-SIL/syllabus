<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class UserDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class UserDoctrineRepository extends ServiceEntityRepository
{
    /**
     * UserDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->addOrderBy('u.lastname', 'ASC');
    }

    /**
     * @param $query
     * @param array $searchFields
     * @return array
     */
    public function findLikeQuery($query, array $searchFields): array
    {
        $qb = $this->getIndexQueryBuilder()
            ->setParameter('query', '%' . $query . '%');

        foreach ($searchFields as $field) {
            if (!in_array($field, ['u.firstname', 'u.lastname'])) {
                continue;
            }
            $qb->orWhere($field . ' LIKE :query');
        }
        return $qb->getQuery()->getResult();
    }
}