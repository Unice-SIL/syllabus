<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Cron;
use AppBundle\Repository\CronRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CronDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CronDoctrineRepository  extends AbstractDoctrineRepository implements CronRepositoryInterface
{

    /**
     * CronDoctrineRepository constructor.
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
        return $this->entityManager->getRepository(Cron::class)
            ->createQueryBuilder('c')
            ->addOrderBy('c.label', 'ASC')
            ;
    }


}