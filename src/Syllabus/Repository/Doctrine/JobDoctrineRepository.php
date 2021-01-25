<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class JobDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class JobDoctrineRepository  extends AbstractDoctrineRepository
{

    /**
     * JobDoctrineRepository constructor.
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
            $qb->andWhere('c.' . $field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult();
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Job::class)
            ->createQueryBuilder('c')
            ->addOrderBy('c.label', 'ASC')
            ;
    }


}