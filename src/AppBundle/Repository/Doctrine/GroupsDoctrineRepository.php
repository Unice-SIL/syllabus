<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Groups;
use AppBundle\Repository\GroupsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class GroupsDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class GroupsDoctrineRepository  extends AbstractDoctrineRepository implements GroupsRepositoryInterface
{

    /**
     * GroupsDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['label'])) {
            $qb->andWhere('g.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult();
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Groups::class)
            ->createQueryBuilder('g')
            ->addOrderBy('g.id', 'ASC')
            ;
    }

}